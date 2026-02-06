<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'brand_id',
        'title',
        'slug',
        'description',
        'file',
        'start_date',
        'end_date',
        'status',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get admin details for this training
    |========================================================
    */
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    /*
    |========================================================
    | Get brand details for this training
    |========================================================
    */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }



   /*
    |========================================================
    | Get listing of all users for this training
    |========================================================
    */
    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
    
}
