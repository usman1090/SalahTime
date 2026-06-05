<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    protected $fillable = [
        'city',
        'country',
        'prayer_date',
        'fajr',
        'dhuhr',
        'asr',
        'maghrib',
        'isha',
    ];

    protected $casts = [
        'prayer_date' => 'date',
    ];
}