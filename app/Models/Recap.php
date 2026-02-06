<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recap extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "recaps";

    protected $fillable = [
        'user_id',
        'brand_id',
        'title',
        'description',
        'event_date',
        'due_date',
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
    | Get admin details for this recap
    |========================================================
    */
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    /*
    |========================================================
    | Get brand details for this recap
    |========================================================
    */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }



    /*
    |========================================================
    | Get listing of all questions for this recap
    |========================================================
    */
    public function questions()
    {
        return $this->hasMany(RecapQuestion::class, 'recap_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
