<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;

// TRAITS
use App\Traits\FilesHandler;
use App\Traits\Base64FilesHandler;

class AdminAgentsController extends Controller
{    
    use FilesHandler;
    use Base64FilesHandler;

    /*
    |===========================================================
    | Get listing of all agents
    |===========================================================
    */
    public function index()
    {
        try {
            $agents = User::where('role_id', 2)
                        ->withCount('cases')
                        ->get();

            $total_agents   =  $agents->count();
            $active_agents   = $agents->where('status', true)->count();
            $inactive_agents = $agents->where('status', false)->count();
            // dd($agents);

            return view('admin.agents.index')->with([
                'agents'          => $agents,
                'total_agents'    => $total_agents,
                'active_agents'   => $active_agents,
                'inactive_agents' => $inactive_agents,
            ]);

        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Show the form for creating new agent
    |===========================================================
    */
    public function create()
    {
        try {
            return view('admin.agents.create');
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    
    /*
    |===========================================================
    | Store newly created case in database
    |===========================================================
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'mobile_no' => 'required|string|max:15|unique:users,mobile_no',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:15',
            'date_of_birth' => 'nullable|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $formData = [
                'name'      => $request->name,
                'role_id'   => 2,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'mobile_no' => $request->mobile_no,
                'address'   => $request->address,
                'gender'    => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'status'    => $request->status ?? false,
            ];

            // save profile image
            if ($request->profile_image) {
                $image_file = $request->profile_image;
                $base64_file = $this->file64($image_file);
                
                // SAVE BASE64 IMAGE IN STORAGE
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/", true);
                $formData['profile_image'] = $saved_image->file_name;    
            }

            User::create($formData);

            Session::flash('Alert', [
                'status' => 200,
                'message' => 'New agent is added successfully.',
            ]);

            return back();
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Edit specific agent details
    |===========================================================
    */
    public function edit($id)
    {
        try {
            $agent = User::find($id);
            // dd($agent);

            return view('admin.agents.edit')->with([
                'agent' => $agent,
            ]);

        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |============================================================
    | Update the specific agent information in storage
    |============================================================
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'string', 'max:100', Rule::unique('users', 'email')->ignore($id)],
            'mobile_no' => ['required', 'string', 'max:100', Rule::unique('users', 'mobile_no')->ignore($id)],
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:15',
            'date_of_birth' => 'nullable|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $formData = [
                'name'      => $request->name,
                'role_id'   => 2,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'mobile_no' => $request->mobile_no,
                'address'   => $request->address,
                'gender'    => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'status'    => $request->status,
            ];

            // save profile image
            if ($request->profile_image) {
                $image_file = $request->profile_image;
                $base64_file = $this->file64($image_file);
                
                // SAVE BASE64 IMAGE IN STORAGE
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/", true);
                $formData['profile_image'] = $saved_image->file_name;    
            }

            User::where('id', $id)->update($formData);

            Session::flash('Alert', [
                'status'  => 200,
                'message' => 'Agent information is updated successfully.',
            ]);

            return back();            
        } 
        catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===========================================================
    | Soft-delete the specified agent in storage
    |===========================================================
    */
    public function destroy($id)
    {
        try {
            $is_deleted = User::where('id', $id)->delete();
            // dd($is_deleted);

            if ($is_deleted) {
                Session::flash('Alert', [
                    'status' => 200,
                    'message'=> 'Agent profile is soft deleted successfully.'
                ]);

                return back();
            }

            Session::flash('Alert', [
                'status' => 100,
                'message'=> 'Something went wrong.'
            ]);

            return back();

        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }


}