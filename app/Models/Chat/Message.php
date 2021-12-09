<?php

namespace App\Models\Chat;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'document_id', 'user_name', 'user_image', 'is_file', 'is_image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function document(){
        return $this->belongsTo(Document::class);
    }

    public function setReceived(){
        $this->is_read = 1;
        $this->save();
    }
}
