<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrayerRecord;
use App\Services\PrayerTimeService;

class DashboardController extends Controller
{
     public function index(PrayerTimeService $prayerTimeService)
    {
        $user = auth()->user();

        $prayers = [
            'fajr',
            'dhuhr',
            'asr',
            'maghrib',
            'isha',
        ];

        $today = now()->toDateString();

        $todayRecords = PrayerRecord::where('user_id', $user->id)
            ->where('prayer_date', $today)
            ->get()
            ->keyBy('prayer_name');

        $completedCount = $todayRecords->whereIn('status', [
            'on_time',
            'late',
            'qaza',
        ])->count();

        $missedCount = $todayRecords->where('status', 'missed')->count();

        $groups = $user->groups;

        $prayerTimes = $prayerTimeService->getTodayTimes();

        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();

        $monthlyRecords = PrayerRecord::where('user_id', $user->id)
            ->whereBetween('prayer_date', [$monthStart, $monthEnd])
            ->get();

        $monthlyStats = [
            'total' => $monthlyRecords->count(),
            'on_time' => $monthlyRecords->where('status', 'on_time')->count(),
            'late' => $monthlyRecords->where('status', 'late')->count(),
            'qaza' => $monthlyRecords->where('status', 'qaza')->count(),
            'missed' => $monthlyRecords->where('status', 'missed')->count(),
        ];

        return view('dashboard', compact(
            'prayers',
            'todayRecords',
            'completedCount',
            'missedCount',
            'groups',
            'prayerTimes',
            'monthlyStats'
        ));
    }
}