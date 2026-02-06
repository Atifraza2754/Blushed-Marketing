<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPaymentJobHistory extends Model
{
    protected $table = 'user_payment_job_history';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'job_id',
        'flat_rate',
        'work_history_id',
        'is_payable',
        'is_paid',
        'date',
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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
