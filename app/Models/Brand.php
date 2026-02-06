<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'image',
        'is_quiz_uploaded',
        'is_recap_uploaded',
        'is_training_uploaded',
        'is_info_uploaded',
        'status',
        'featured',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get admin details for this brand
    |========================================================
    */
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /*
    |========================================================
    | Get listing of all trainings for this brand
    |========================================================
    */
    public function trainings()
    {
        return $this->hasMany(Training::class, 'brand_id', 'id');
    }



   /*
    |========================================================
    | Get listing of all infos for this brand
    |========================================================
    */
    public function infos()
    {
        return $this->hasMany(Infos::class, 'brand_id', 'id');
    }

    public function trainingFile(){
        return $this->hasMany(TrainingFile::class,'trainig_in' , 'id')->where('is_deletesd',0);
    }
}
