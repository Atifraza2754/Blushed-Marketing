<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;

use App\Services\OTPService;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    protected $otp_service;

    public function __construct(OTPService $os)
    {
        $this->otp_service = $os;
    }
    
    
    /*
    |===================================================
    | Show login form
    |===================================================
    */
    public function loginForm()
    {
        try {
            return view('auth.login');
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

            // dd($request->all());
            
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
            return redirect('admin/dashboard');
            
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===================================================
    | Redirect to the login url
    |===================================================
    */
    public function register(Request $request)
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
                'role_id'  => 2,
                'status'   => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $user_id = User::insertGetId($formData);

            // login user by id
            $is_login = $this->loginUserById($user_id);

            // redirect logged in user
            if ($is_login) {
                return redirect('student/dashboard');
            }
            else{
                return \redirect('error.page-500');
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
            return view('auth.forget-password');
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

            Session::flash('Alert', [
                'status' => $response['status'],
                'message'=> $response['message']
            ]);

            if ($response['status'] == 200) {
                return redirect('/verify-otp');
            }

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
            return view('auth.verify-otp');
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
            return view('auth.reset-password');
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
                    return redirect('/admin/dashboard');
                }

                return redirect('/student/dashboard');
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