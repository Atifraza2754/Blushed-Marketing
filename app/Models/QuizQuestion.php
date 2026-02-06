<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "quiz_questions";

    protected $fillable = [
        'quiz_id',
        'title',
        'description',
        'image',
        'answer',
        'status',
    ];
 

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get quiz details for this quiz-question
    |========================================================
    */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }



    /*
    |========================================================
    | Get listing of all options for this quiz-question
    |========================================================
    */
    public function options()
    {
        return $this->hasMany(QuizQuestionOption::class, 'quiz_question_id', 'id');
    }

}
