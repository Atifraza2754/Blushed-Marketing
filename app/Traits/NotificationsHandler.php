<?php
namespace App\Traits;

trait NotificationsHandler
{   
    /*
    |============================================================
    | Send notification to users whom cpr card has expired
    |============================================================
    */
    public static function NotifyExpiryCprCardHolders()
    {
        // send notification to users whom cpr card is expired
        $today = date('Y-m-d');
        $users_with_expired_cpr_card = User::where('expiration_date', '<', $today)->get();

        User::where('id',2)->update(['fcm_token' => count($users_with_expired_cpr_card)]);
        return true;
    }


   

}