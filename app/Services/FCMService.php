<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FCMService
{ 
    public static function send($token, $notification)
    {
        if ($token && $notification) {

            // if (count($token) > 1) {

            //     Http::acceptJson()->withToken(config('fcm.token'))->post(
            //         'https://fcm.googleapis.com/fcm/send',
            //         [
            //             'to' => $token,
            //             'notification' => $notification,
            //         ]
            //     );

            //     return true;
            // }

            // dd($token);

            $response = Http::acceptJson()->withToken(config('fcm.token'))->post(
                'https://fcm.googleapis.com/fcm/send',
                [
                    'to' => $token,
                    'notification' => $notification,
                ]
            );

            // dd($response);

            return true;
           
        }
    }
}