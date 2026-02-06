<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ictForm extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'w9forms';

    protected $fillable = [
        'user_id',
        'name',
        'business_name',
        'federal_tax_classification',
        'exempt_payee_code',
        'fatca_reporting_code',
        'address',
        'city_state_zipcode',
        'account_number',
        'requester_name',
        'social_security_number',
        'employer_identification_number',
        'date',
        'digital_signature',
        'status',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get user details for this w9form
    |========================================================
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
