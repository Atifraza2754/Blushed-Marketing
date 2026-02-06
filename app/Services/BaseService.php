<?php
namespace App\Services;

use App\Models\SiteSetting;
use App\Models\User;

class BaseService
{

    /*
    |=========================================================
    | Get user-id from user-email
    |=========================================================
    */
    public function email_to_id($email = null)
    {
        if (!$email) {
            return "<email> is missing";
        }
        $user_id = User::where('email', $email)->first()->id;

        return $user_id;
    }


    /*
    |=========================================================
    | Get user-id from user-slug
    |=========================================================
    */
    public function slug_to_id($slug = null)
    {
        if (!$slug) {
            return "<slug> is missing";
        }
        $user_id = User::where('slug', $slug)->first()->id;

        return $user_id;
    }


    /*
    |=========================================================
    | Get app settings
    |=========================================================
    */
    public function get_app_settings()
    {

        $app_settings = SiteSetting::first();

        return $app_settings;
    }



}
