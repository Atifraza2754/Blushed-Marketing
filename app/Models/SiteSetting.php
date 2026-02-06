<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteSetting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'site_name',
        'site_publisher',
        'logo',
        'favicon',
        'about',
        'email',
        'mobile_no',
        'phone_no',
        'whatsapp_no',
        'address',
        'facebook',
        'instagram',
        'twitter',
        'snapchat',
        'linkedin',
    ];
 

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
