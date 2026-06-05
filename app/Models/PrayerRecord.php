<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerRecord extends Model
{
    protected $fillable = [
        'user_id',
        'prayer_name',
        'prayer_date',
        'prayer_time',
        'status',
        'image_path',
    ];

    protected $casts = [
        'prayer_date' => 'date',
        'prayer_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}