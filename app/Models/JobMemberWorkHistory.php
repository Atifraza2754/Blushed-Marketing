<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMemberWorkHistory extends Model
{
    use HasFactory;
    protected $table = 'job_members_work_history';
    protected $guarded = [];
}
