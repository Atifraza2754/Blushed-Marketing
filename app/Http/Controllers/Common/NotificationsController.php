<?php

namespace App\Http\Controllers\Common;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class NotificationsController extends Controller
{
    /*
    |=================================================================
    | Get all notification of this auth user
    |=================================================================
    */
    public function index()
    {
        try {
            $notifications = Notification::where('user_id', Auth::id())
                                        ->orderBy('id', 'DESC')
                                        ->paginate(20);

            // if login account role is user
            if (Auth::user()->role_id == 5) {

                return view('user.notifications.index')->with([
                    'tab'  => "notifications",
                    'notifications' => $notifications,
                ]);
            }

            // return admin view
            return view('notifications.index')->with([
                'tab'  => "notifications",
                'notifications' => $notifications,
            ]);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function detail($id){
        $notification = Notification::where('id' , $id)->first();
        return view('user.notifications.detail')->with(
            [
                'notification'=>$notification
            ]
        );
    }


}
