<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'person',
        'role',
        'name',
        'surname',
        'date_of_birth',
        'email',
        'personal_number',
        'commercial_name',
        'commercial_code',
        'email',
        'country',
        'city',
        'address',
        'phone',
        'representative',
        'representative_name',
        'representative_surname',
        'representative_date_of_birth',
        'representative_email',
        'representative_personal_number',
        'representative_phone',
        'representative_file',
    ];
}
