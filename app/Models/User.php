<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'role_id',
        'email',
        'verification_code',
        'email_verified_at',
        'mobile_no',
        'profile_image',
        'country_id',
        'state',
        'city',
        'zipcode',
        'address',
        'gender',
        'date_of_birth',
        'password',
        'flat_rate',

        // documents columns
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'resume',
        'certificate',
        'expiry_date',

        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /*
    |========================================================
    | Get role details for this user
    |========================================================
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    /*
    |========================================================
    | Get country details for this user
    |========================================================
    */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function checkAvailibity()
    {
        $check = JobMember::Join('jobs_c', 'jobs_c.id', '=', 'job_members.job_id')
            ->where('job_members.user_id', $this->id)
            ->whereNull('jobs_c.deleted_at')
            ->where('jobs_c.date', '>=', date('Y-m-d'))
            ->orderBy('jobs_c.date', 'ASC')
            // ->first()
            ->exists()
        ;

        return $check;
    }
public function isOnShift()
{
    return WorkHistory::where('user_id', $this->id)
        ->where('is_active_shift', 1)       // ✅ 1 matlab user abhi kaam kar raha hai
        ->whereNotNull('check_in')          // Check-in ho chuka ho
        ->whereNull('check_out')            // Check-out na hua ho
        ->exists();
}
public function userRecaps()
{
    return $this->hasMany(UserRecap::class, 'user_id', 'id');
}


}
