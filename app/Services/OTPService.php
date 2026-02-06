<?php
namespace App\Services;

use Carbon\Carbon;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use \App\Mail\PasswordResetEmail;

class OTPService extends BaseService
{
    /*
    |================================================================
    |  Send otp to user via email address
    |================================================================
    */
    public function sendOtp($email)
    { 
        try{
            $user = User::where('email', $email)->first();

            if (!$user) {
                return [
                    'status' => 100,
                    'message'=> 'There is no account associated with the provided email address',
                ];
            }

            // generate OTP Code
            $otp = $this->otp(6);
            // $otp = "123456"; // temporary

            $user->verification_code = $otp;
            $user->save();

            // send otp in email to user
            $otp_sent = $this->sendOTPEmail($user, $otp);

            if (true) {
                return  [
                    'status'  => 200,
                    'message' => 'Verification code has been sent successfully',
                ];
            }

            return [
                'status'  => 100,
                'message' => 'Something went wrong',
            ];

        }
        catch (\Exception $e) {
            return response()->json([
                "status" => 100,
                "errors" => $e->getMessage()
            ]);
        }

    }




    /*
    |================================================================
    |  Generate New OTP
    |================================================================
    */
    public function otp($strength)
    {
        // $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input = '0123456789';

        $input_length = strlen($input);
        $random_string = '';

        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }



    /*
    |================================================================
    |  Send OTP to user's email address
    |================================================================
    */
    public function sendOTPEmail($user, $otp)
    {
        if ($user && $otp) {
            
            $sender_email = config('mail.from')['address'];
            $app_name = config('app.name');

            $details = [
                'title' => 'Your OTP',
                'body'  => 'Use the following OTP to verify its you',
                'otp'   => $otp,
                'user'  => $user->name
            ];
    
            \Mail::to($user->email, $user->name)->send(new PasswordResetEmail($details));

            return true;
        }
        else{
            return "<user> or <otp> is missing";
        }
    }

    // /*
    // |================================================================
    // |  Send OTP to user's email address
    // |================================================================
    // */
    // public function sendOTPEmail($user, $otp)
    // {
    //     if ($user && $otp) {
            
    //         $sender_email = config('app.mail_from');
    //         $app_name = config('app.name');

    //         Mail::send('auth.otp.sendotpemail', compact('otp'), function ($message) use ($user , $sender_email , $app_name) {
    //             $message->from( $sender_email ,  $app_name);
    //             $message->to($user->email, $user->name);
    //             $message->subject('Verify Email Address');
    //             // $message->priority(3);
    //         });
    //     }
    //     else{
    //         return "<user> or <otp> is missing";
    //     }
    // }



    /*
    |================================================================
    |  Verify User OTP VIA Email Address
    |================================================================
    */
    public function verifyOtp($otp)
    {
        if ($otp) {

            $user = User::where('verification_code', $otp)->first();
            // dd($user);

            if($user) {
                
                // login this user
                Auth::login($user);

                $user->is_email_verified = 1;
                $user->verification_code = null;
                $user->email_verified_at = Carbon::now();
                $user = $user->save();

                return  [
                    'status'  => 200,
                    'message' => 'Your email address has been verified',
                ];
            }
            else{
                return [
                    'status' => 100,
                    'error'  => 'The OTP code does not match',
                ];
            }
        }
        else{
            return "<otp> is missing";
        }

    }    



    /*
    |===================================================================
    |  Set user new password
    |===================================================================
    */
    public function setNewPassword($user_id, $new_password)
    {        
        try{
            if ($user_id && $new_password) {

                User::where('id', $user_id)
                    ->update(['password' => Hash::make($new_password)]);

                return  [
                    'status'  => 200,
                    'message' => 'You have updated your password successfully'
                ];
            }

            return  [
                'status'  => 100,
                'message' => " <user_id> OR <new_password> is missing >",
            ];

        }
        catch (\Exception $e) {
            return response()->json([
                "status" => 100,
                "errors" => $e->getMessage()
            ]);
        }

    }



    /*
    |===================================================================
    |  Update user old password
    |===================================================================
    */
    public function updateOldPassword($old_password, $new_password)
    {        
        try{
            if ($old_password && $new_password) {

                // validate old password
                if (!(Hash::check($old_password, Auth::user()->password))) {

                    return [
                        'status' => 100,
                        'message'=> 'The old password is incorrect'
                    ];
                }

                // setup new password
                User::where('id',Auth::id())
                    ->update(['password' => Hash::make($new_password)]);

                return  [
                    'status'  => 200,
                    'message' => 'You have updated your password successfully'
                ];
            }

            return  [
                'status'  => 100,
                'message' => " <old_password> OR <new_password> is missing >",
            ];

        }
        catch (\Exception $e) {
            return response()->json([
                "status" => 100,
                "errors" => $e->getMessage()
            ]);
        }

    }
    
    
    
    /*
    |================================================================
    |  Verify user mobile-no status in storage
    |================================================================
    */
    public function updateMobileNoStatus($user_id)
    {
        try{
            if ($user_id) {
                $user = User::find($user_id);

                if($user) {

                    $user->is_mobile_verified = 1;
                    $user->mobile_verified_at = Carbon::now();
                    $user->save();

                    return  [
                        'status'  => 200,
                        'message' => "Your mobile no has been verified",
                    ];
                }

                return [
                    'status' => 100,
                    'error'  => 'Sorry, something went wrong',
                ];
            }

            return  [
                'status'  => 100,
                'message' => "<user_id> is missing.",
            ];
            
        }
        catch (\Exception $e) {
            return response()->json([
                "status" => 100,
                "errors" => $e->getMessage()
            ]);
        }

    }



    /*
    |================================================================
    |  Logout user
    |================================================================
    */
    public function logoutUser($user_id)
    {
        try{
            if ($user_id) {

                Auth::logout();
                Session::flush();

                return  [
                    'status'  => 200,
                    'message' => "User is logout successfully",
                ];
            }

            return  [
                'status'  => 100,
                'message' => " <user_id> is missing.",
            ];
            
        }
        catch (\Exception $e) {
            return response()->json([
                "status" => 100,
                "errors" => $e->getMessage()
            ]);
        }
    }
    
}