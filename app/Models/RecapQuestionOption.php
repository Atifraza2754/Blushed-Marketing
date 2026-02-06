<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecapQuestionOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "recap_question_options";

    protected $fillable = [
        'recap_question_id',
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
    | Get question details for this recap-question-option
    |========================================================
    */
    public function question()
    {
        return $this->belongsTo(RecapQuestion::class, 'recap_question_id', 'id');
    }

}
