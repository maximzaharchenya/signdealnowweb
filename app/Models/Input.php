<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    use HasFactory;

    protected $table = 'inputs';

    protected $fillable = [
        'user_id',
        'document_id',
        'content',
        'position',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Document');
    }
}
