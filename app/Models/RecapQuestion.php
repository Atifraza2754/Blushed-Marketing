<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecapQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "recap_questions";

    protected $fillable = [
        'recap_id',
        'title',
        'description',
        'question_type',
        'options',
        'status',
    ];
 

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get recap details for this recap-question
    |========================================================
    */
    public function recap()
    {
        return $this->belongsTo(Recap::class, 'recap_id', 'id');
    }


    /*
    |========================================================
    | Get listing of all options for this recap-question
    |========================================================
    */
    public function options()
    {
        return $this->hasMany(RecapQuestionOption::class, 'recap_question_id', 'id');
    }

}
