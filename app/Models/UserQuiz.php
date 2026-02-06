<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class UserQuiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "user_quizzes";

    protected $fillable = [
        'quiz_id',
        'user_id',
        'submit_date',
        'shift_date',
        'total_questions',
        'all_answers',
        'attempted_questions',
        'right_answers',
        'wrong_answers',
        'feedback',
        'status',
        'percentage'
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get user details for this user-quiz
    |========================================================
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    /*
    |========================================================
    | Get quiz details for this user-quiz
    |========================================================
    */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id')->whereNull('quizzes.deleted_at');
    }

    public function getStatus($id){
        return self::where('quiz_id' , $id)->where('user_id' , Auth::user()->id)->value('status');
    }
}
