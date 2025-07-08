<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusPointThreshold extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_points',
        'max_points',
        'bonus_amount',
    ];

    public function awardedBonuses()
    {
        return $this->hasMany(UserAwardedBonus::class);
    }
}