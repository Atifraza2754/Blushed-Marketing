<?php

namespace App\Http\Controllers\Common;

use App\Models\User;
use App\Models\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MessagesController extends Controller
{
    /*
    |===========================================================
    | Get listing of all messages
    |===========================================================
    */
    public function index()
    {
        try {
            $messages = Message::select('id', 'user_id', 'message', 'created_at', 'updated_at')
                                ->whereIn('id', function ($query) {
                                    $query->selectRaw('MAX(id)')
                                        ->from('messages')
                                        ->groupBy('user_id');
                                })
                                ->with('user:id,name,profile_image,email')
                                ->orderBy('id', 'DESC')
                                ->get();
            // dd($messages);

            return view('messages.index')->with([
                'messages'=> $messages,
            ]);

        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Get specific user all messages
    |===========================================================
    */
    public function userMessages($user_id)
    {
        try {
            $user = User::where('id', $user_id)->first();
            $messages = Message::where('user_id', $user_id)
                                ->orderBy('id','DESC')
                                ->get();
            // dd($messages);

            return view('messages.detail')->with([
                'messages'=> $messages,
                'user' => $user
            ]);

        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }


    
    /*
    |===========================================================
    | Send new message
    |===========================================================
    */
    public function sendNewMessage()
    {
        $request->validate([
            "message" => "required|string|max:255",
        ]);

        try {
            $formData = [
                'user_id' => Auth::id(),
                'message' => $request->message,
                'status' => true,
            ];

            Message::create($formData);

            Session::flash('Alert', [
                'status'  => 200,
                'message' => "Message is sent successfully",
            ]);

            return back();
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }
    
}