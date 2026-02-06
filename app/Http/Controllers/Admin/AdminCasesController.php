<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\AgentCase;
use App\Models\DeviceInfo;
use App\Models\User;

class AdminCasesController extends Controller
{
    /*
    |===========================================================
    | Get listing of all cases
    |===========================================================
    */
    public function index()
    {
        try {
            if (Auth::id() == 1) {
                $cases = AgentCase::with('user:id,name,email')->get();
            } 
            else {
                $cases = AgentCase::where('user_id', Auth::id())->with('user:id,name,email')->get();
            }
            
            $active_cases   = $cases->where('status', true)->count();
            $inactive_cases = $cases->where('status', false)->count();
            // dd($cases);

            return view('admin.cases.index')->with([
                'cases' => $cases,
                'total_cases'  => $cases->count(),
                'active_cases' => $active_cases,
                'inactive_cases' => $inactive_cases,
            ]);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Show the form for creating new case
    |===========================================================
    */
    public function create()
    {
        try {
            $agents = User::where('status', true)->orderBy('name', 'ASC')->get();
            $devices = DeviceInfo::all();
            // dd($devices);

            return view('admin.cases.create')->with([
                'agents' => $agents,
                'devices' => $devices
            ]);
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
            'date_of_report' => 'required|date',
            'time_of_report' => 'required|date_format:H:i',
            'contact_person' => 'required|string|max:100',
            'contact_no' => 'required|string|max:25',
            // 'lift_no' => 'required|integer',
            // 'man_trap' => 'required|string|max:5',
            // 'fault_reported' => 'required|string|max:1000',
            // 'building_name' => 'required|string|max:255',
            // 'building_address' => 'required|string|max:255',
            // 'engineer_assigned' => 'required|string|max:255',
        ]);

        try {
            $formData = [
                'user_id'        => $request->agent_id ?? Auth::id(),
                'date_of_report' => $request->date_of_report,
                'time_of_report' => $request->time_of_report,
                'contact_person' => $request->contact_person,
                'contact_no'     => $request->contact_no,
                // 'lift_no'        => $request->lift_no,
                // 'man_trap'       => $request->man_trap,
                // 'fault_reported' => $request->fault_reported,
                // 'building_name'  => $request->building_name,
                // 'building_address' => $request->building_address,
                // 'engineer_assigned'=> $request->engineer_assigned,
                // 'status'         => $request->status,

                // device info
                'deviceId' => $request->deviceId,
                'deviceNumber' => $request->deviceNumber,
                'customer' => $request->customer,
                'siteName' => $request->siteName,
                'address'  => $request->address,
                'postcode' => $request->postcode,
                'dialerphonenumber' => $request->dialerphonenumber,
                'engineer' => $request->engineer,
            ];

            AgentCase::create($formData);

            Session::flash('Alert', [
                'status' => 200,
                'message' => 'New case is added successfully.',
            ]);

            return back();
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Show the form for editing the specified case
    |===========================================================
    */
    public function edit($id)
    {
        try {
            $case = AgentCase::where('id', $id)->with('user:id,name')->first();
            $agents = User::where('status', true)->orderBy('name', 'ASC')->get();
            $devices = DeviceInfo::all();
            // dd($case);

            return view('admin.cases.edit')->with([
                'case' => $case,
                'agents' => $agents,
                'devices'=> $devices
            ]);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |============================================================
    | Update the specific case information in storage
    |============================================================
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_of_report' => 'required|date',
            'time_of_report' => 'required',
            'contact_person' => 'required|string|max:100',
            'contact_no' => 'required|string|max:25',
            // 'lift_no' => 'required|integer',
            // 'man_trap' => 'required|string|max:5',
            // 'fault_reported' => 'required|string|max:1000',
            // 'building_name' => 'required|string|max:255',
            // 'building_address' => 'required|string|max:255',
            // 'engineer_assigned' => 'required|string|max:255',
        ]);

        try {
            $formData = [
                'user_id'        => $request->agent_id ?? Auth::id(),
                'date_of_report' => $request->date_of_report,
                'time_of_report' => $request->time_of_report,
                'contact_person' => $request->contact_person,
                'contact_no'     => $request->contact_no,
                // 'lift_no'        => $request->lift_no,
                // 'man_trap'       => $request->man_trap,
                // 'fault_reported' => $request->fault_reported,
                // 'building_name'  => $request->building_name,
                // 'building_address' => $request->building_address,
                // 'engineer_assigned'=> $request->engineer_assigned,
                // 'status'         => $request->status,

                // device info
                'deviceId' => $request->deviceId,
                'deviceNumber' => $request->deviceNumber,
                'customer' => $request->customer,
                'siteName' => $request->siteName,
                'address'  => $request->address,
                'postcode' => $request->postcode,
                'dialerphonenumber' => $request->dialerphonenumber,
                'engineer' => $request->engineer,
            ];

            // update case details
            AgentCase::where('id', $id)->update($formData);

            Session::flash('Alert', [
                'status' => 200,
                'message' => 'Case information is updated successfully.',
            ]);

            return back();
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Soft-delete the specified case in storage
    |===========================================================
    */
    public function destroy($id)
    {
        try {
            AgentCase::where('id', $id)->delete();

            Session::flash('Alert', [
                'status' => 200,
                'message' => 'Case is soft deleted successfully.',
            ]);

            return back();
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Get specific device info
    |===========================================================
    */
    public function deviceInfo($id)
    {
        try {
            $device = DeviceInfo::where('id', $id)->first();
            // dd($device);

            return response()->json([
                'status' => 200,
                'device' => $device
            ]);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

}
