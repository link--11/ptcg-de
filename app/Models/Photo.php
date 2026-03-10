<?php

namespace App\Models;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'id', 'tournament_id'
    ];

    public function tournament () {
        return $this->belongsTo(Tournament::class);
    }
}
