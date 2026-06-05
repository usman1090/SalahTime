<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\PrayerRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index()
    {
        $groups = auth()->user()->groups;

        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => auth()->id(),
            'invite_code' => strtoupper(Str::random(8)),
        ]);

        $group->members()->attach(auth()->id(), [
            'joined_at' => now(),
        ]);

        return redirect()->route('groups.index')
            ->with('success', 'Group created successfully.');
    }

    public function show(Group $group)
{
    abort_unless($group->members->contains(auth()->id()), 403);

    $members = $group->members;

    $prayers = [
        'fajr',
        'dhuhr',
        'asr',
        'maghrib',
        'isha',
    ];

    $today = now()->toDateString();

    $records = PrayerRecord::whereIn('user_id', $members->pluck('id'))
        ->where('prayer_date', $today)
        ->get()
        ->groupBy('user_id');

    return view('groups.show', compact(
        'group',
        'members',
        'prayers',
        'records'
    ));
}

    public function joinForm()
    {
        return view('groups.join');
    }

    public function join(Request $request)
    {
        $request->validate([
            'invite_code' => 'required',
        ]);

        $group = Group::where('invite_code', strtoupper($request->invite_code))->first();

        if (!$group) {
            return back()->withErrors([
                'invite_code' => 'Invalid invite code.',
            ]);
        }

        $group->members()->syncWithoutDetaching([
            auth()->id() => [
                'joined_at' => now(),
            ],
        ]);

        return redirect()->route('groups.index')
            ->with('success', 'Joined group successfully.');
    }
}