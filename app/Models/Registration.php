<?php

namespace App\Models;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'first_name', 'last_name',
        'playerid', 'birthdate', 'email'
    ];

    public function tournament () {
        return $this->belongsTo(Tournament::class);
    }
}
