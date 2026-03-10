<?php

namespace App\Models;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'division', 'name',
        'playerid', 'place', 'wins', 'losses', 'ties'
    ];

    public function tournament () {
        return $this->belongsTo(Tournament::class);
    }
}
