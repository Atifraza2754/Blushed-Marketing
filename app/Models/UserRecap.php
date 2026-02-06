<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRecap extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "user_recaps";

    protected $fillable = [
        'user_id',
        'recap_id',
        'submit_date',
        'shift_date',
        'feedback',
        'rating',
        'status',
        'shift_id'
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get user details for this user-recap
    |========================================================
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    /*
    |========================================================
    | Get recap details for this user-recap
    |========================================================
    */
    public function recap()
    {
        return $this->belongsTo(Recap::class, 'recap_id', 'id');
    }

     public function job()
    {
        return $this->belongsTo(Job::class, 'shift_id');
    }
}
