<?php

namespace App\Http\Controllers\Common;

use App\Models\Brand;
use App\Models\Recap;
use App\Models\RecapQuestion;
use App\Models\UserRecap;
use App\Services\NotificationsService;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Services\BrandsService;

use App\Services\RecapsService;
use App\Models\UserRecapQuestion;

use App\Traits\Base64FilesHandler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use URL;

class RecapsController extends Controller
{
    use FilesHandler;
    use Base64FilesHandler;

    protected $recaps_service;
    protected $brands_service;
    protected $notification_service;

    public function __construct(RecapsService $rs, BrandsService $bs, NotificationsService $ns)
    {
        $this->recaps_service = $rs;
        $this->brands_service = $bs;
        $this->notification_service = $ns;
    }


    /*
    |===========================================================
    | Get listing of all recaps (created by admin)
    |===========================================================
    */
    public function index(Request $request, $slug = null)
    {
        try {
            $filter = $request->tab;
            $recapsResponse = $this->recaps_service->get_all_recaps($filter);
            $brandsResponse = $this->brands_service->get_active_brands();
            // dd($recapsResponse);

            if ($recapsResponse['status'] == 200 && $brandsResponse['status'] == 200) {
                return view('learning-center.recaps.recaps')->with([
                    'menu'   => "recap",
                    'recaps' => $recapsResponse['recaps'],
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
    | Show the form for creating new recap
    |===========================================================
    */
    public function create(Request $request)
    {
        try {
            $brand_id = $request->brand_id;
            $brandsResponse = $this->brands_service->get_brand_detail($brand_id);

            // dd($brandsResponse);
            if ($brandsResponse['status'] == 200) {
                return view('learning-center.recaps.create')->with([
                    'menu'  => "recap",
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
    | Store newly created recap in storage
    |===========================================================
    */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'       => 'required|string|max:255',
            'brand_id'    => 'required|integer',
            // 'event_date'  => 'required|date',
            // 'due_date'    => 'required|date',
            'questions.*' => 'required|string|max:255',
        ]);

        try {
            $data = $request->all();
            $response = $this->recaps_service->add_new_recap($data);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status'  => 200,
                    'message' => $response['message'],
                ]);

                return redirect('/learning-center/recaps');
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
    | Show the form for editing the specified recap
    |===========================================================
    */
    public function edit($id)
    {
        try {
            $recapResponse = $this->recaps_service->get_recap_detail($id);
            // dd($recapResponse);

            if ($recapResponse['status'] == 200) {
                return view('learning-center.recaps.edit')->with([
                    'menu' => "recap",
                    'recap' => $recapResponse['recap'],
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
    | Update the specified quiz detail in storage
    |===========================================================
    */
    public function update(Request $request, $id)
    {

        $request->validate([
            "brand_id"    => "required|integer",
            "title"       => "required|string|max:200",
            "description" => "nullable|string|max:255",
            'event_date'  => 'nullable|date',
            'due_date'    => 'nullable|date',
            "file"        => "nullable|mimes:ppt,pptx,doc,docx,csv,pdf|max:10240",
        ]);


        try {
            $data = $request->all();
            $response = $this->recaps_service->update_recap($data, $id);

            if ($response['status'] == 200) {

                $recap = Recap::where('id' , $id)->first();
                $members = UserRecap::where('recap_id', $recap->id)->get(['id','user_id'])->toArray();
                $brand = $recap->brand->title ?? '' ;
                foreach ($members as $m) {
                    $str = 'The Recap of '.$brand.'has Updated. Please review it.';
                    $notification_data = [
                        'user_id' => $m['user_id'],
                        'title' => "Reca[ Update",
                        'description' => $str,
                        'link' =>  URL::to("/user/recap/".$m['id'])

                    ];
                    $this->notification_service->store_notification($notification_data);
                }

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
    public function destroy($id){
        try {
            $getbrand_id = Recap::where('id' , $id)->pluck('brand_id')->toArray();
            Brand::where('id' , $getbrand_id[0])->update(['is_recap_uploaded'=>0]);
            $recapResponse = Recap::where('id' , $id)->delete();
            $recapResponse = RecapQuestion::where('recap_id', $id)->delete();
            // dd($recapResponse);


            return response()->json([
                'status' => 200,
                'message' => 'Recap Deleted !',
            ]);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

}
