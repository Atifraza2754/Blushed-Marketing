<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCoverageOffer extends Model
{
    use HasFactory;

    protected $table = 'job_coverage_offers';

    protected $fillable = [
        'coverage_request_id',
        'user_id',
        'status',
    ];

    // Optional relationships
    /*
    public function coverageRequest()
    {
        return $this->belongsTo(JobCoverageRequest::class, 'coverage_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    */
}
