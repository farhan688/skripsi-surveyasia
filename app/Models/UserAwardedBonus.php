<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAwardedBonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bonus_point_threshold_id',
        'awarded_at',
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bonusPointThreshold()
    {
        return $this->belongsTo(BonusPointThreshold::class);
    }
}