<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobCoverageRequest extends Model
{
    use HasFactory;

    protected $table = 'job_coverage_requests';

    protected $fillable = [
        'job_id',
        'requestor_id',
        'type',
        'status',
    ];

    // Optional: relationships (if needed later)
    public function offers()
    {
        return $this->hasMany(JobCoverageOffer::class, 'coverage_request_id');
    }

    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
