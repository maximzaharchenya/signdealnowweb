<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    public const STATUS_CREATED = 1;
    public const STATUS_WORK_WITH_DOCUMENT = 2;
    public const STATUS_NOTARY_INVITED = 3;
    public const STATUS_WAITING_FOR_NOTARY = 4;
    public const STATUS_NOTARY_ACCEPTED = 5;
    public const STATUS_NOTARY_DECLINED = 12;
    public const STATUS_APPROVAL_OF_THE_SIGNING_TIME = 6;
//    public const STATUS_WAITING_FOR_THE_SIGNING = 6;
    public const STATUS_SIGNING = 7;
    public const STATUS_OBJECT_BOOKED = 8;
    public const STATUS_NOT_ACTIVE = 9;
    public const STATUS_CANCELED = 10;
    public const STATUS_CLOSED = 11;

    protected $fillable = [
        'notary_id',
        'status',
        'title',
        'cadastral_number',
        'cadastral_number_data',
        'type',
        'country',
        'city',
        'address',
        'image',

        'additional_seller_data',
        'seller_data',
        'additional_client_data',
        'client_data',
        'property_data',
        'mortgage_data',
        'married_data',
        'representative_data',
        'co_owner_data',
        'sign_info',
        'sign_info_file',
        'notary_fees',
        'fees',
        'notary_data',

        'document_file',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'documents_users')->withPivot(['user_role', 'user_signs', 'user_present', 'approved', 'from', 'sign_approved', 'fees_approved']);
    }

    public function inputs()
    {
        return $this->hasMany('App\Models\Input', 'document_id', 'id');
    }

    public function unauthorized_users()
    {
        return $this->hasMany('App\Models\UnauthorizedUser');
    }

    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    public function contributors()
    {
        return $this->hasMany('App\Models\Contributor');
    }

    public function mortgages()
    {
        return $this->hasMany('App\Models\Mortgage');
    }
}
