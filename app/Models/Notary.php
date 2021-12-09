<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'image',
        'office_name',
        'deals_in_progress',
        'closed_deals',
        'language',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
