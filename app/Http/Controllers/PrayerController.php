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
        ]);

        $status = $prayerTimeService->detectStatus($request->prayer_name);

        PrayerRecord::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'prayer_name' => $request->prayer_name,
                'prayer_date' => now()->toDateString(),
            ],
            [
                'status' => $status,
                'prayer_time' => now(),
            ]
        );

        return back()->with('success', 'Prayer marked as ' . str_replace('_', ' ', $status));
    }

    public function destroy(PrayerRecord $prayerRecord)
    {
        abort_unless($prayerRecord->user_id === auth()->id(), 403);

        $prayerRecord->delete();

        return back()->with('success', 'Prayer removed successfully.');
    }
}