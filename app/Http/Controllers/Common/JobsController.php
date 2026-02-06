<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Services\RolesService;
use App\Services\UsersService;
use App\Services\InvitesService;
use App\Http\Controllers\Controller;
use App\Imports\jobsImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class jobsController extends Controller
{
    protected $users_service;

    public function __construct(UsersService $us)
    {
        $this->users_service = $us;
    }


    /*
    |===========================================================
    | Get listing of all jobs_c
    |===========================================================
    */
    public function index(Request $request)
    {
        try {
            // $filter = $request->tab;
            // $users = $this->users_service->get_all_users($filter);
            // dd($users);

            return view('shift.index')->with([
                // 'tab'  => $filter,
                // 'users'=> $users,
            ]);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Store newly created job in storage
    |===========================================================
    */
    public function importJob(Request $request)
    {
        $request->validate([
            'jobs_c' => 'required|mimes:xls,xlsx' // Validate file as Excel (XLS or XLSX)
        ]);

        $jobs_c_file = $request->file('jobs_c');
        Excel::import(new jobsImport, $jobs_c_file);

        return redirect()->back()->with('success', 'Data imported successfully!');

        try {
            $data = $request->all();
            $response = $this->info_service->add_new_info($data);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status'  => 200,
                    'message' => $response['message'],
                ]);

                return back();
            }

            Session::flash('Alert', [
                'status' => 100,
                'message' => $response['message'],
            ]);

            return back();
        }
        catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===========================================================
    | Delete the specified job -- soft delete
    |===========================================================
    */
    public function destroy($id)
    {
        try {
            $user_id = $request->user_id;

            $response = $this->users_service->soft_delete_user($user_id);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status'  => 200,
                    'message' => $response['message'],
                ]);

                return back();
            }

            Session::flash('Alert', [
                'status' => 100,
                'message' => $response['message'],
            ]);

            return back();
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



}
