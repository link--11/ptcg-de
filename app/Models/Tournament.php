<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'date', 'type', 'format',
        'cost', 'cap', 'notes',
        'locator_id'
    ];

    public function store () {
        return $this->belongsTo(Store::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function delete()
    {
        $this->registrations()->delete();
        return parent::delete();
    }
}
