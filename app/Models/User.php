<?php

namespace App\Models;

use App\Models\Chat\Message;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public const ADMIN_TYPE = 2;

    protected $fillable = [
        'name',
        'surname',
        'date_of_birth',
        'email',
        'middle_name',
        'password',
        'profile_image',
        'type',
        'phone',
        'personal_number',
        'country',
        'city',
        'address',
        'languages',
        'about',
        'country_registry',
        'authentication',
        'authentication_type',
        'authentication_transaction_id',
        'authentication_data',
        'user_certificate',
        'personal_code',
        'personal_code_type',
        'email_check',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function delete()
    {
        if (!empty($this->profile_image)) Storage::delete('/public/' . $this->profile_image);
        return parent::delete();
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'documents_users');
    }

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
