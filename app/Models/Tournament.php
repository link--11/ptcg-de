<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'date', 'type', 'format',
        'cost', 'cap', 'notes', 'registration', 'results',
        'locator_id'
    ];

    public function store () {
        return $this->belongsTo(Store::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function delete()
    {
        $this->registrations()->delete();
        $this->standings()->delete();
        return parent::delete();
    }
}
