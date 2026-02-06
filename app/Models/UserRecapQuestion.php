<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecapQuestion extends Model
{
    use HasFactory;

    protected $table = "user_recap_questions";

    protected $fillable = [
        'user_recap_id',
        'recap_question_type',
        'recap_question',
        'recap_question_options',
        'recap_question_answer',
    ];
 

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    /*
    |========================================================
    | Get user-recap details for this user-recap-question
    |========================================================
    */
    public function userRecap()
    {
        return $this->belongsTo(UserRecap::class, 'user_recap_id', 'id');
    }



    /*
    |========================================================
    | Get user-recap-question details for user-recap-question
    |========================================================
    */
    public function userRecapQuestion()
    {
        return $this->belongsTo(UserRecapQuestion::class, 'user_recap_question_id', 'id');
    }
}
