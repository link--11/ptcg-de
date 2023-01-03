<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'zip_code', 'city',
        'email', 'phone', 'website',
        'league'
    ];

    public function tournaments () {
        return $this->hasMany(Tournament::class);
    }

    public function users () {
        return $this->belongsToMany(User::class);
    }
}
