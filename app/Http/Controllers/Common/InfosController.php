<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Info;
use App\Models\InfoFile;
use App\Services\BrandsService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Services\InfoService;
use Illuminate\Support\Facades\Storage;

class InfosController extends Controller
{
    protected $info_service;
    protected $brands_service;

    public function __construct(InfoService $is, BrandsService $bs)
    {
        $this->info_service = $is;
        $this->brands_service = $bs;
    }


    /*
    |===========================================================
    | Get listing of all infos
    |===========================================================
    */
    public function index(Request $request)
    {
        try {
            $filter = $request->tab;
            $infosResponse = $this->info_service->get_all_infos($filter);
            $brandsResponse = $this->brands_service->get_active_brands();
            // dd($brandsResponse);

            if ($infosResponse['status'] == 200 && $brandsResponse['status'] == 200) {
                return view('learning-center.infos.index')->with([
                    'menu'   => 'info',
                    'infos'  => $infosResponse['infos'],
                    'brands' => $brandsResponse['brands'],

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
    | Show the form for creating new info
    |===========================================================
    */
    public function create(Request $request)
    {
        try {
            $brand_id = $request->brand_id;
            $brandsResponse = $this->brands_service->get_brand_detail($brand_id);

            // dd($brandsResponse);
            if ($brandsResponse['status'] == 200) {
                return view('learning-center.infos.create')->with([
                    'menu'   => 'info',
                    'brand' => $brandsResponse['brand']
                ]);
            }
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Store newly created info in storage
    |===========================================================
    */
    public function store(Request $request)
    {
        $request->validate([
            "brand_id"    => "required|integer",
            "title"       => "nullable|string|max:200",
            "description" => "nullable|string|max:255",
            // "file"        => "nullable|mimes:mp4,mkv",
        ]);

        try {
            $data = $request->all();
            $response = $this->info_service->add_new_info($data);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status'  => 200,
                    'message' => $response['message'],
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Info Uploaded !',
                ]);
                // return redirect('/learning-center/infos');
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
    | Show the form for editing the specified info
    |===========================================================
    */
    public function edit($id)
    {
        try {
            $infoResponse = $this->info_service->get_info_detail($id);
            $infoFiles = $this->info_service->getInfoFiles($id);
            // dd($infoResponse);

            if ($infoResponse['status'] == 200) {
                return view('learning-center.infos.edit')->with([
                    'menu' => 'info',
                    'info' => $infoResponse['info'],
                    'infoFile'=>$infoFiles['files']

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
    | Update the specified info detail in storage
    |===========================================================
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            "brand_id"    => "required|integer",
            "title"       => "required|string|max:200",
            "description" => "nullable|string|max:255",
            // "file"        => "nullable|mimes:mp4,mkv",
        ]);

        try {
            $data = $request->all();
            $response = $this->info_service->update_info($data, $id);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status'  => 200,
                    'message' => $response['message'],
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Info Uploaded !',
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

    public function destroy($id){
        try {
            $getbrand_id = Info::where('id' , $id)->pluck('brand_id')->toArray();
            Brand::where('id' , $getbrand_id[0])->update(['is_info_uploaded'=>0]);
            $recapResponse = Info::where('id' , $id)->delete();
             // dd($recapResponse);


            return response()->json([
                'status' => 200,
                'message' => 'Info Deleted !',
            ]);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroyFile($id)
    {
        try {
            $file = InfoFile::where('id' , $id)->first();

            $fileName =$file->files;

            $storagePath = 'files/trainings/';

            // Check if file exists and delete it
            if (Storage::disk('public')->exists($storagePath . $fileName)) {
                Storage::disk('public')->delete($storagePath . $fileName);
            }
            $getbrand_id = InfoFile::where('id' , $id)->delete();
            // Brand::where('id' , $getbrand_id[0])->update(['is_training_uploaded'=>0]);
            //  Training::where('id', $id)->delete();
            // dd($is_updated);

            return response()->json([
                'status' => 200,
                'message' => 'File Deleted !',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
