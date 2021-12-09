<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mortgage extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'type',
        'area',
        'land_area',
        'used_land_area',
        'living_area',
        'purpose',
        'energy_class',
        'city',
        'country',
        'address',
        'cadastral_number',
        'registration_number',
        'serf_number',
        'partnership_code',
        'owner',
        'owner_code',
        'cost',
        'holder_data',
    ];
}
