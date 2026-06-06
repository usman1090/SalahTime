<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrayerTimeService;
use App\Models\PrayerRecord;

class PrayerController extends Controller
{
   public function store(Request $request, PrayerTimeService $prayerTimeService)
{
    $request->validate([
        'prayer_name' => 'required|in:fajr,dhuhr,asr,maghrib,isha',
        'proof_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
    ]);

    $status = $prayerTimeService->detectStatus($request->prayer_name);

    $imagePath = null;

    if ($request->hasFile('proof_image')) {
        $imagePath = $request->file('proof_image')->store('prayer-proofs', 'public');
    }

    $existingRecord = PrayerRecord::where('user_id', auth()->id())
    ->where('prayer_name', $request->prayer_name)
    ->where('prayer_date', now()->toDateString())
    ->first();

    $data = [
        'status' => $status,
        'prayer_time' => now(),
    ];

    if ($request->hasFile('proof_image')) {
        $data['image_path'] = $request->file('proof_image')
            ->store('prayer-proofs', 'public');
    }

    if ($existingRecord) {
        $existingRecord->update($data);
    } else {
        PrayerRecord::create(array_merge([
            'user_id' => auth()->id(),
            'prayer_name' => $request->prayer_name,
            'prayer_date' => now()->toDateString(),
        ], $data));
    }

    return back()->with('success', 'Prayer marked with proof successfully.');
}

    public function destroy(PrayerRecord $prayerRecord)
    {
        abort_unless($prayerRecord->user_id === auth()->id(), 403);

        $prayerRecord->delete();

        return back()->with('success', 'Prayer removed successfully.');
    }
}