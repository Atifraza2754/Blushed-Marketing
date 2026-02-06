<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTraining extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "users_trainings";

    protected $fillable = [
        'user_id',
        'training_id',
        'status',
        'due_date',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get user details for this user-training
    |========================================================
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



   /*
    |========================================================
    | Get listing of all users for this user-training
    |========================================================
    */
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id')->whereNull('deleted_at');
    }
}
