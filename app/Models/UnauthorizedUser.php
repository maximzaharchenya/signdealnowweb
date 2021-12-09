<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnauthorizedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'pin',
        'name',
        'surname',
        'email',
        'phone',
        'type',
        'signs',
        'present',
        'from',
    ];
}
