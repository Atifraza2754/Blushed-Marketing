<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invite extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invited_by',
        'role_id',
        'email',
        'has_signup',
        'invite_link',
        'invite_qr_code',
        'status',
    ];
 

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /*
    |========================================================
    | Get inviter details for this invite
    |========================================================
    */
    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by', 'id');
    }



    /*
    |========================================================
    | Get admin role details for this invite
    |========================================================
    */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

}
