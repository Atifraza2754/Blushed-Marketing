<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Services\BrandsService;

class BrandsController extends Controller
{
    protected $brands_service;

    public function __construct(BrandsService $bs)
    {
        $this->brands_service = $bs;
    }


    /*
    |===========================================================
    | Get listing of all brands
    |===========================================================
    */
    public function index(Request $request)
    {
        try {
            $filter = $request->tab;
            $response = $this->brands_service->get_all_brands($filter);
            // dd($response);

            if ($response['status'] == 200) {
                return view('brands.index')->with([
                    'tab'    => $filter ?? "all",
                    'brands' => $response['brands'],
                ]);
            }

            return response()->json([
                'status' => 100,
                'message'=> $response->message,
            ]);

        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }


    
    /*
    |===========================================================
    | Show the form for creating new brand
    |===========================================================
    */
    public function create()
    {
        try {
            return view('brands.create'); 
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Store new brand in storage
    |===========================================================
    */
    public function store(Request $request)
    {
        $request->validate([
            "title"       => "required|string|max:200",
            "description" => "nullable|string|max:255",
            "image"       => "nullable|image|mimes:jpeg,png,jpg|max:2048",
        ]);

        try {
            $data = $request->all();
            $response = $this->brands_service->add_new_brand($data);
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
    | Show the form for editing the specified brand
    |===========================================================
    */
    public function edit($id)
    {
        try {
            $response = $this->brands_service->get_brand_detail($id);
            // dd($response);

            if ($response['status'] == 200) {
                return view('brands.edit')->with([
                    'brand' => $response['brand'],
                ]);
            }

            return response()->json([
                'status' => 100,
                'message'=> $response->message,
            ]);
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }
    

    /*
    |===========================================================
    | Update the specified brand detail in storage
    |===========================================================
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            "title"       => "required|string|max:200",
            "description" => "nullable|string|max:255",
            "image"       => "nullable|image|mimes:jpeg,png,jpg|max:2048",
        ]);

        try {
            $data = $request->all();
            $response = $this->brands_service->update_brand($data, $id);
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

    
}