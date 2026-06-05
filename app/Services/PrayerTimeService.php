<?php

namespace App\Services;

use App\Models\PrayerTime;
use Illuminate\Support\Facades\Http;

class PrayerTimeService
{
    public function getTodayTimes($city = 'Karachi', $country = 'Pakistan')
    {
        $today = now()->toDateString();

        $existing = PrayerTime::where('city', $city)
            ->where('country', $country)
            ->where('prayer_date', $today)
            ->first();

        if ($existing) {
            return $existing;
        }

        $response = Http::get('https://api.aladhan.com/v1/timingsByCity', [
            'city' => $city,
            'country' => $country,
            'method' => 1,
        ]);

        $timings = $response->json('data.timings');

        return PrayerTime::create([
            'city' => $city,
            'country' => $country,
            'prayer_date' => $today,
            'fajr' => $this->cleanTime($timings['Fajr']),
            'dhuhr' => $this->cleanTime($timings['Dhuhr']),
            'asr' => $this->cleanTime($timings['Asr']),
            'maghrib' => $this->cleanTime($timings['Maghrib']),
            'isha' => $this->cleanTime($timings['Isha']),
        ]);
    }

    private function cleanTime($time)
    {
        return explode(' ', $time)[0];
    }

    public function detectStatus($prayerName)
    {
        $times = $this->getTodayTimes();

        $now = now();

        $prayerStart = now()->setTimeFromTimeString($times->$prayerName);

        $nextPrayer = match ($prayerName) {
            'fajr' => now()->setTimeFromTimeString($times->dhuhr),
            'dhuhr' => now()->setTimeFromTimeString($times->asr),
            'asr' => now()->setTimeFromTimeString($times->maghrib),
            'maghrib' => now()->setTimeFromTimeString($times->isha),
            'isha' => now()->endOfDay(),
        };

        if ($now->between($prayerStart, $nextPrayer)) {
            return 'on_time';
        }

        if ($now->greaterThan($nextPrayer)) {
            return 'qaza';
        }

        return 'late';
    }
}