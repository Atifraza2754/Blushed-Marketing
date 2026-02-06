<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestionOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "quiz_question_options";

    protected $fillable = [
        'quiz_question_id',
        'option',
        'type',
        'status',
    ];
 

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get question details for this quiz-question-option
    |========================================================
    */
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id', 'id');
    }

}
