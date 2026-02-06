<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'user_id',
        'flat_rate',
        'status',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get job detail for this job member
    |========================================================
    */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }


    /*
    |========================================================
    | Get user detail for this job member
    |========================================================
    */
        public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->whereNull('deleted_at');
    }
    public function userPayment()
    {
        return $this->hasMany(UserPaymentJobHistory::class, 'job_id', 'job_id')
        ->where('is_payable' , 1)
        ->where('is_paid' , 0)
        ;
    }
}
