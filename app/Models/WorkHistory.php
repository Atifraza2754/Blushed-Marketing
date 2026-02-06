<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    use HasFactory;

    protected $table = 'work_history';

    protected $fillable = [
        'status',
        'user_id',
        'job_id',
        'date',
        'image',
        'shift_hours',
        'user_working_hour',
        'falt_rate',
        'check_in',
        'check_out',
        'lat',
        'lon',
        'is_active_shift',
        'is_confirm',
        'is_complete',
        'mileage',
        'sale_incentive',
        'out_of_pocket_expense',
        'deduction',
        'total_paid',
        'total_due',
        'grand_total',
        'is_allownce_save',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function flat_rate_deduction()
    {
        return $this->belongsTo(FlatRateDeduction::class, 'job_id', 'job_id')
            ->where('user_id', $this->user_id)
            ->where('paid_to_user', 0);
    }

    // WorkHistory.php
public function payment()
{
    return $this->hasOne(
        UserPaymentJobHistory::class,
        'work_history_id',
        'id'
    );
}

}
