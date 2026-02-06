<?php

namespace App\Http\Controllers\Auth;

use App\Models\Invite;
use Carbon\Carbon;
use App\Models\User;

use App\Services\OTPService;

use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Services\RolesService;
use App\Services\InvitesService;
use App\Traits\Base64FilesHandler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use FilesHandler;
    use Base64FilesHandler;

    protected $otp_service;
    protected $roles_service;

    public function __construct(OTPService $os, RolesService $rs, InvitesService $is)
    {
        $this->otp_service = $os;
        $this->roles_service = $rs;
        $this->invites_service = $is;
    }


    /*
    |===================================================
    | Show login form
    |===================================================
    */
    public function otpEmail()
    {
        try {
            $details = [
                'link' => 'https://blushed.thelastresort.com.pk/invite/shahzadhussain786786@gmail.com/step-1'
            ];

            return view('emails.invite-admin')->with([
                'details' => $details
            ]);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
    |===================================================
    | Show login form
    |===================================================
    */
    public function loginForm()
    {
        try {
            $response = $this->roles_service->get_active_roles();
            // dd($response);

            if ($response['status'] == 200) {

                return view('auth.login')->with([
                    'roles' => $response['roles']
                ]);
            }

            return "Sorry, something went wrong.";

        }
        catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
    |===================================================
    | Login admin user
    |===================================================
    */
    public function login(Request $request)
    {
         try {
            $request->validate([
                'email'    => 'required|string|email',
                'password' => 'required|string'
            ]);

            $remember_token = false;

            if ($request->remember_token) {
                $remember_token = $request->remember_token ? true : false;
            }

            // check if user is invalid - display validation errors
            if (!Auth::attempt($request->except('_method', '_token', 'remember_token'), $remember_token)) {
                Session::flash('Alert', [
                    'status' => 100,
                    'message'=> 'These Credentials do not match our record'
                ]);

                return back();
            }

            // check if account is active or not
            if (!Auth::user()->status) {
                $this->logout();
            }

            // redirect to dashboard
            return redirect('/dashboard');

        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===================================================
    | Show signup form
    |===================================================
    */
    public function signupForm1()
    {
        try {
            $response = $this->roles_service->get_active_roles();
            // dd($response);

            if ($response['status'] == 200) {

                return view('auth.register')->with([
                    'roles' => $response['roles']
                ]);
            }

            return "Sorry, something went wrong.";

        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



        /*
    |===================================================
    | Register step 1
    |===================================================
    */
    public function registerStep1(Request $request)
    {
        try {
            $request->validate([
                'name'    => 'required|string|max:255',
                'email'   => 'required|email|max:100|unique:users,email',
                'password'=> 'required|string|min:8'
            ]);

            $formData = [
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => 5, // by default role will be user (5)
                'status'   => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // create new user account
            $user_id = User::insertGetId($formData);

            // auto login user account
            $is_login = $this->loginUserById($user_id);
            Invite::where('email' , $request->email)->update(['has_signup' => 1]);
            Session::flash('Alert', [
                'status' => 200,
                'message'=> 'Step-1 is successfully completed'
            ]);

            if ($request->is_invited_user) {
                return redirect("/invite/$request->email/step-2");
            }
            return redirect('register/step-2');
        }
        catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===================================================
    | Show signup form
    |===================================================
    */
    public function signupForm2()
    {
        try {
            $response = $this->roles_service->get_active_roles();
            // dd($response);

            if ($response['status'] == 200) {

                return view('auth.register2')->with([
                    'roles' => $response['roles']
                ]);
            }

            return "Sorry, something went wrong.";

        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===================================================
    | Register step 2
    |===================================================
    */
    public function registerStep2(Request $request)
    {
        try {
            $request->validate([
                'role_id'  => 'required|integer',
                'mobile_no'=> 'nullable|string|min:10|max:15',
                'address'  => 'nullable|string|max:255',
            ]);

            $formData = [
                'role_id'  => $request->role_id ?? 5,
                'mobile_no'=> $request->mobile_no,
                'address'  => $request->address,
            ];

            if ($request->profile_image) {
                $image_file = $request->profile_image;
                $base64_file = $this->file64($image_file);

                // SAVE BASE64 IMAGE IN STORAGE
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/", true);

                $formData['profile_image'] = $saved_image->file_name;
            }

            User::find(Auth::id())->update($formData);

            return redirect('/dashboard');

        }
        catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===================================================
    | Show signup form for invited user/admin
    |===================================================
    */
    public function inviteSignupForm1($email)
    {
        try {
            // find invite by email
            $exist = User::where('email', $email)->get();
             $response = $this->invites_service->get_invite_info($email);

            if ($response['status'] == 200) {

                return view('auth.register')->with([
                    'invite' => $response['invite']
                ]);
            }
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===================================================
    | Show signup form for invited user/admin
    |===================================================
    */
    public function inviteSignupForm2($email)
    {
        try {
            // find invite by email
            $response = $this->invites_service->get_invite_info($email);
            // dd($response);

            if ($response['status'] == 200) {

                return view('auth.register2')->with([
                    'invite' => $response['invite']
                ]);
            }
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |=========================================================
    | Show the form for email address to send OTP
    |=========================================================
    */
    public function forgetPasswordForm()
    {
        try {
            return view('auth.passwords.email');
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |=========================================================
    | Send OTP to provided email address
    |=========================================================
    */
    public function sendOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
            ]);

            // send otp
            $response  = $this->otp_service->sendOTP($request->email);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status' => 200,
                    'message'=> $response['message']
                ]);

                return redirect('/verify-otp');
            }

            Session::flash('Alert', [
                'status' => 100,
                'message'=> $response['message']
            ]);

            return back();
        }
        catch (\Throwable $th) {
            throw $th;
        }

    }


    /*
    |=========================================================
    | Show the form for verifying OTP
    |=========================================================
    */
    public function verifyOTPForm(Request $request)
    {
        try {
            return view('auth.passwords.otp');
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
    |=========================================================
    | Verify OTP and redirect user to reset password
    |=========================================================
    */
    public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|string|max:10',
            ]);

            $response  = $this->otp_service->verifyOtp($request->otp);
            // dd($response);

            if ($response['status'] == 200) {
                Session::flash('Alert', [
                    'status' => $response['status'],
                    'message'=> $response['message']
                ]);

                return redirect('/reset-password');
            }

            Session::flash('Alert', [
                'status' => $response['status'],
                'message'=> $response['error']
            ]);

            return back();

        }
        catch (\Throwable $th) {
            throw $th;
        }

    }


    /*
    |=========================================================
    | Show reset password form after otp verification
    |=========================================================
    */
    public function resetPasswordForm(Request $request)
    {
        try {
            return view('auth.passwords.reset');
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
    |=========================================================
    | Reset new password
    |=========================================================
    */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|max:20',
            'password' => 'required|min:8|max:20|confirmed'
        ]);

        try {
            $response = $this->otp_service->setNewPassword(Auth::id(), $request->password);
            // dd($response, Auth::id());

            if ($response['status'] == 200) {
                Session::flash('Alert', [
                    'status' => $response['status'],
                    'message'=> $response['message']
                ]);

                if (Auth::id() == 1) {
                    return redirect('/dashboard');
                }

                return redirect('/dashboard');
            }

            Session::flash('Alert', [
                'status' => $response['status'],
                'message'=> $response['message']
            ]);

            return back();
        }
        catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===================================================
    | Logout auth user
    |===================================================
    */
    public function logout()
    {
        try {
            Auth::logout();
            Session::flush();

            return redirect('/');
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===================================================
    | Login user (manually) by his id
    |===================================================
    */
    private function loginUserById($id)
    {
       if ($id) {
            $user = User::find($id);
            Auth::login($user);

            return true;
       }

       return false;
    }


}
