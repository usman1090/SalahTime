<?php

namespace App\Services;

use App\Models\PrayerRecord;
use Carbon\Carbon;

class StreakService
{
    public function getCurrentStreak($userId)
    {
        $streak = 0;
        $date = now();

        while (true) {
            $completedCount = PrayerRecord::where('user_id', $userId)
                ->whereDate('prayer_date', $date->toDateString())
                ->whereIn('status', ['on_time', 'late', 'qaza'])
                ->count();

            if ($completedCount < 5) {
                break;
            }

            $streak++;
            $date->subDay();
        }

        return $streak;
    }

    public function getBestStreak($userId)
    {
        $records = PrayerRecord::where('user_id', $userId)
            ->whereIn('status', ['on_time', 'late', 'qaza'])
            ->orderBy('prayer_date')
            ->get()
            ->groupBy(function ($record) {
                return Carbon::parse($record->prayer_date)->toDateString();
            });

        $bestStreak = 0;
        $currentStreak = 0;
        $previousDate = null;

        foreach ($records as $date => $dayRecords) {
            if ($dayRecords->count() < 5) {
                $currentStreak = 0;
                continue;
            }

            $currentDate = Carbon::parse($date);

            if ($previousDate && $currentDate->diffInDays($previousDate) === 1) {
                $currentStreak++;
            } else {
                $currentStreak = 1;
            }

            $bestStreak = max($bestStreak, $currentStreak);
            $previousDate = $currentDate;
        }

        return $bestStreak;
    }
}