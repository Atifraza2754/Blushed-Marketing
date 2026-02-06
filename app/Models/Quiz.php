<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "quizzes";

    protected $fillable = [
        'user_id',
        'brand_id',
        'slug',
        'description',
        'image',
        'no_of_questions',
        'status',
    ];
 

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get admin details for this quiz
    |========================================================
    */
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    /*
    |========================================================
    | Get brand details for this quiz
    |========================================================
    */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }



    /*
    |========================================================
    | Get listing of all questions for this quiz
    |========================================================
    */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id', 'id');
    }
}
