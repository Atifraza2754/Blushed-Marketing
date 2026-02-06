<?php
namespace App\Services;

use App\Models\SiteSetting;

class SettingService extends BaseService
{
    /*
    |=========================================================
    | Get all site settings
    |=========================================================
    */
    public function get_all_settings()
    {
        $settings = SiteSetting::first();
                                    
        return $settings;
    }


    /*
    |=========================================================
    | Get notification settings only
    |=========================================================
    */
    public function get_notification_settings()
    {
        $settings = SiteSetting::select('notification_title','notification_body')->first();
                                    
        return $settings;
    }
    
}