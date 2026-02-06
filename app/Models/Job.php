<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'jobs_c';
    // protected $fillable = [
    //     'user_id',
    //     'date',
    //     'account',
    //     'address',
    //     'contact',
    //     'phone',
    //     'scheduled_time',
    //     'timezone',
    //     'email',
    //     'method_of_communication',
    //     'brand',
    //     'skus',
    //     'samples_requested',
    //     'reschedule',
    //     'added_to_homebase',
    //     'confirmed',
    //     'is_published',
    //     'shift_start',
    //     'shift_end',
    // ];
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get admin details for this brand
    |========================================================
    */
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function jobMembers()
    {
        return $this->belongsTo(JobMember::class, 'job_id', 'id');
    }

    public function jobMemberDetail()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function totalCount($job_id)
    {
        $JobMember = JobMember::join('user_payment_job_history', 'user_payment_job_history.user_id', '=', 'job_members.user_id')
            ->where('user_payment_job_history.job_id', $job_id)
            ->where('user_payment_job_history.is_paid', 0)
            ->whereNull('user_payment_job_history.deleted_at')
            ->where('job_members.status', '=', 'approved')
            ->sum('job_members.flat_rate');
        return $JobMember;
    }
    function calculateTotalHours($shift_start = null, $shift_end = null)
    {
        // If no values are provided, fetch from the current model instance
        if ($shift_start === null || $shift_end === null) {
            $shift_start = $this->shift_start ?? "00:00:00"; // Default to midnight if no value
            $shift_end = $this->shift_end ?? "00:00:00";
        }

        // Create Carbon instances
        $start_time = Carbon::createFromFormat('H:i:s', $shift_start);
        $end_time = Carbon::createFromFormat('H:i:s', $shift_end);

        // Calculate total hours
        return $start_time->diffInMinutes($end_time) / 60;
    }

    public function getTotalHours()
    {
        return $this->calculateTotalHours();
    }

    // Allow custom values to be passed
    public function getCustomTotalHours($shift_start, $shift_end)
    {
        return $this->calculateTotalHours($shift_start, $shift_end);
    }

    public function getCoverageStatusAttribute(){
        return JobCoverageRequest::where('job_id', $this->id)->value('id');
    }

    // App\Models\Job.php

public function brand()
{
    return $this->belongsTo(Brand::class, 'brand_id', 'id');
}

}
