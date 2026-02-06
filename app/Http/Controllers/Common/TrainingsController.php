<?php

namespace App\Http\Controllers\Common;

use App\Models\Brand;
use App\Models\JobMember;
use App\Models\Training;
use App\Services\NotificationsService;
use Illuminate\Http\Request;
use App\Services\BrandsService;

use App\Services\TrainingsService;
use App\Http\Controllers\Controller;
use App\Models\TrainingFile;
use App\Models\UserTraining;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TrainingsController extends Controller
{
    protected $trainings_service;
    protected $brands_service;
    protected $notification_service;

    public function __construct(TrainingsService $ts, BrandsService $bs, NotificationsService $ns)
    {
        $this->trainings_service = $ts;
        $this->brands_service = $bs;
        $this->notification_service = $ns;
    }


    /*
    |===========================================================
    | Get listing of all trainings
    |===========================================================
    */
    public function index(Request $request, $slug = null)
    {
        try {
            // if login account role is user
            if (Auth::user()->role_id == 5) {
                $userjob = JobMember::where('job_members.user_id' , Auth::id())
                ->join('jobs_c' ,'jobs_c.id' , 'job_members.job_id' )
                ->join('brands' , 'brands.title','jobs_c.brand' )
                ->join('trainings' , 'trainings.brand_id', 'brands.id')
                ->where('job_members.status' , 'approved')
                ->where('jobs_c.is_published' , 1)
                ->whereNull('jobs_c.deleted_at')
                ->distinct('trainings.id')
                ->pluck('trainings.id')
                ->toArray()
                ;
                // dd($userjob);
                $trainings = UserTraining::where('users_trainings.user_id', Auth::id())
                ->whereIn('users_trainings.training_id' , $userjob)
                ->join('trainings','trainings.id' ,'=' , 'users_trainings.training_id')
                ->whereNull('trainings.deleted_at')
                    ->with('training.brand', 'training.admin')
                    ->orderBy('users_trainings.due_date', 'DESC')
                    ->groupby('users_trainings.training_id')

                    ;

                // if we have filter (complete/incomplete)
                if ($slug) {
                    $status = $slug == "complete" ? "complete" : "pending";
                    $trainings = $trainings->where('trainings.status', $status);
                }

                $trainings = $trainings->select(
                    'users_trainings.*'
                )->get();

                return view('user.learning-center.trainings.index')->with([
                    'slug' => $slug,
                    'user_trainings' => $trainings,
                ]);
            }

            // for roles other than user
            $filter = $request->tab;
            $trainingsResponse = $this->trainings_service->get_all_trainings($filter);
            $brandsResponse = $this->brands_service->get_active_brands();
            // dd($trainingsResponse);

            if ($trainingsResponse['status'] == 200 && $brandsResponse['status'] == 200) {
                return view('learning-center.trainings.trainings')->with([
                    'menu' => "training",
                    'trainings' => $trainingsResponse['trainings'],
                    'brands' => $brandsResponse['brands'],
                ]);
            }

            return response()->json([
                'status' => 100,
                'message' => $response->message,
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Get listing of all user-trainings
    |===========================================================
    */
    public function userTrainings(Request $request)
    {
        try {
            $filter = $request->tab;
            $trainingsResponse = $this->trainings_service->get_user_trainings($filter);
            $brandsResponse = $this->brands_service->get_active_brands();
            // dd($trainingsResponse);

            if ($trainingsResponse['status'] == 200 && $brandsResponse['status'] == 200) {
                return view('learning-center.trainings.user-trainings')->with([
                    'menu' => "training",
                    'trainings' => $trainingsResponse['trainings'],
                    'brands' => $brandsResponse['brands'],
                ]);
            }

            return response()->json([
                'status' => 100,
                'message' => $response->message,
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Show the form for creating new training
    |===========================================================
    */
    public function create(Request $request)
    {
        try {
            $brand_id = $request->brand_id;
            $brandsResponse = $this->brands_service->get_brand_detail($brand_id);

            // dd($brandsResponse);
            if ($brandsResponse['status'] == 200) {
                return view('learning-center.trainings.create')->with([
                    'menu' => "training",
                    'brand' => $brandsResponse['brand']
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Store newly created training in storage
    |===========================================================
    */
    public function store(Request $request)
    {
        $request->validate([
            "brand_id" => "required|integer",
            "title" => "nullable|string|max:200",
            "description" => "nullable|string|max:255",
            "files" => "nullable|max:10240",
        ]);

        try {
            $data = $request->all();
            $response = $this->trainings_service->add_new_training($data);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status' => 200,
                    'message' => $response['message'],
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Training Uploaded !',
                ]);
                // return redirect('/learning-center/trainings');
            }

            Session::flash('Alert', [
                'status' => 100,
                'message' => $response['message'],
            ]);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===========================================================
    | Show the form for editing the specified training
    |===========================================================
    */
    public function edit($id)
    {

        try {
            // if login account role is user
            if (Auth::user()->role_id == 5) {

                $training = UserTraining::where('id', $id)
                    ->with('training.brand', 'training.admin')
                    ->first();

                    $trainingFile = $this->trainings_service->getTrainingFile($training->training_id);
                    


                return view('user.learning-center.trainings.detail')->with([
                    'user_training' => $training,
                'trainingFile'=>$trainingFile['files']

                ]);
            }

            $trainingResponse = $this->trainings_service->get_training_detail($id);
            // dd($trainingResponse);
            $trainingFile = $this->trainings_service->getTrainingFile($id);


            if ($trainingResponse['status'] == 200) {
                return view('learning-center.trainings.edit')->with([
                    'menu' => "training",
                    'training' => $trainingResponse['training'],
                    'trainingFile'=>$trainingFile['files']

                ]);
            }


            return response()->json([
                'status' => 100,
                'message' => $response->message,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /*
    |===========================================================
    | Update the specified training detail in storage
    |===========================================================
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            "brand_id" => "required|integer",
            "title" => "required|string|max:200",
            "description" => "nullable|string|max:255",
            "file" => "nullable|max:10240",
        ]);

        try {
            $data = $request->all();
            $response = $this->trainings_service->update_training($data, $id);



            if ($response['status'] == 200) {

                // need confirmation for trainging
                // $training = Training::where('id' , $id)->first();
                // $members = Training::where('brand_id', $training->brand_id)->get('user_id')->toArray();
                // $brand = $training->brand->title ?? '' ;
                //   foreach ($members as $m) {
                //     $str = 'The Training of '.$brand.'has Updated. Please review it.';
                //     $notification_data = [
                //         'user_id' => $m['user_id'],
                //         'title' => "Training Update",
                //         'description' => $str,
                //         'link' => null
                //     ];
                //     $this->notification_service->store_notification($notification_data);
                // }
                return response()->json([
                    'status' => 200,
                    'message' => 'Training Uploaded !',
                ]);

                Session::flash('Alert', [
                    'status' => 200,
                    'message' => $response['message'],
                ]);

                return back();
            }

            Session::flash('Alert', [
                'status' => 100,
                'message' => $response['message'],
            ]);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }

    }




    /*
    |===========================================================
    | Change user training status to complete
    |===========================================================
    */
    public function completeTraining($id)
    {
        try {
            $is_updated = UserTraining::where('id', $id)->update(['status' => 'complete']);
            // dd($is_updated);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $getbrand_id = Training::where('id' , $id)->pluck('brand_id')->toArray();
            Brand::where('id' , $getbrand_id[0])->update(['is_training_uploaded'=>0]);
             Training::where('id', $id)->delete();
            // dd($is_updated);

            return response()->json([
                'status' => 200,
                'message' => 'Training Deleted !',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function destroyFile($id)
    {
        try {
            $file = TrainingFile::where('id' , $id)->first();

            $fileName =$file->files;

            $storagePath = 'files/trainings/';

            // Check if file exists and delete it
            if (Storage::disk('public')->exists($storagePath . $fileName)) {
                Storage::disk('public')->delete($storagePath . $fileName);
            }
            $getbrand_id = TrainingFile::where('id' , $id)->delete();
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
    public function detail($id)
    {
        try {
            // if login account role is user

            $training = Training::where('id', $id)
                // ->with('training.brand', 'training.admin')
                ->first();

            // dd($training);
            $brandsResponse = $this->brands_service->get_active_brands();
            $trainingFile = $this->trainings_service->getTrainingFile($training->id);
// dd($trainingFile);
            return view('learning-center.trainings.detail')->with([
                'user_training' => $training,
                'menu' => "training",
                'brands' => $brandsResponse['brands'],
                'trainingFile'=>$trainingFile['files']

            ]);


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function approveTraining(Request $request){
        try {
            $is_updated = UserTraining::whereIn('id', $request->ids)->update(['status' => 'approved']);
            // dd($is_updated);

            return response()->json([
                'status' => 200,
                'message' => 'Training Approve !',
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
