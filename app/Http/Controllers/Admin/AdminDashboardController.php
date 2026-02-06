<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\AgentCase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /*
    |===========================================================
    | Get content for admin panel dashboard
    |===========================================================
    */
    public function index()
    {
        try {
            $total_agents = User::where('role_id', '!=', 1)->count();
            $total_cases  = AgentCase::count();

            if (Auth::id() == 1) {
                $recent_cases = AgentCase::with('user:id,name')->latest()->take(10)->get();
            }
            else{
                $recent_cases = AgentCase::where('user_id', Auth::id())->with('user:id,name')->latest()->take(10)->get();
            }
            // dd($recent_cases);

            return view('admin.dashboard.index')->with([
                'total_agents' => $total_agents,
                'total_cases'  => $total_cases,
                'recent_cases' => $recent_cases,
            ]);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    
}