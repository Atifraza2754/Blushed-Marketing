<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'payrolls';

    protected $fillable = [
        'user_id',
        'name',
        'phone_no',
        'payment_preference',
        'email_address',
        'fatca_reporting_code',
        'address',
        'voided_check',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get user details for this payroll
    |========================================================
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
