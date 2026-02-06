<?php
namespace App\Services;

use App\Models\Info;
use App\Models\Brand;
use App\Models\InfoFile;
use Illuminate\Support\Str;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Traits\Base64FilesHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InfoService extends BaseService
{
    use FilesHandler;
    use Base64FilesHandler;

    /*
    |=========================================================
    | Get listing of all infos
    |=========================================================
    */
    public function get_all_infos($filter)
    {
        $infos = Info::orderBy('id','ASC');
        // dd($infos);

        // apply filters
        if ($filter == 'active') {
            $infos = $infos->where('status', true);
        }
        if ($filter == 'inactive') {
            $infos = $infos->where('status', false);
        }

        $infos = $infos->get();

        return [
            'status' => 200,
            'infos' => $infos
        ];
    }



    /*
    |=========================================================
    | Get listing of all active infos
    |=========================================================
    */
    public function get_active_infos()
    {
        $infos = Info::where('status', TRUE)->get();
        // dd($infos);

        if ($infos) {
            return [
                'status' => 200,
                'infos' => $infos
            ];
        }

        return [
            'status' => 100,
            'message'=> "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Store new info in storage
    |=========================================================
    */
    public function add_new_info($data)
    {
        if ($data) {

            DB::beginTransaction();
            $brand_id = $data['brand_id'];

            $formData = [
                'user_id'    => Auth::id(),
                'brand_id'   => $brand_id,
                'title'      => $data['title'],
                'slug'       => Str::slug($data['title']),
                'description'=> $data['description'],
                'status'     => true,
            ];

            $tr = Info::create($formData);

            if(isset($data['files']) && !empty($data['files'])){
				$files = $data['files'];
				foreach($files as $file){


			if (isset($file) && $file->isValid()) {
				// $file = $data['file'];
				$fileName = "infos_" . $tr->id . '_' . $file->getClientOriginalName();

                $storagePath = 'files/infos/';

                // Check if file exists and delete it
                if (Storage::disk('public')->exists($storagePath . $fileName)) {
                    Storage::disk('public')->delete($storagePath . $fileName);
                }
                $file->storeAs('files/infos', $fileName, 'public');
				$formData2['files'] = $fileName;
				$formData2['name'] = $file->getClientOriginalName();
				$formData2['info_id'] = $tr->id;
				$formData2['brand_id'] = $brand_id;
				InfoFile::create($formData2);
			}
		}

        }


            // update brand info upload status
            Brand::where('id', $brand_id)->update(['is_info_uploaded' => true]);

            DB::commit();

            return [
                'status' => 200,
                'message'=> 'New info is added successfully'
            ];
        }


        DB::rollback();

        return [
            'status' => 100,
            'message'=> 'Sorry, something went wrong'
        ];
    }




    /*
    |=========================================================
    | Get specific info details
    |=========================================================
    */
    public function get_info_detail($id)
    {
        if ($id) {
            $info = Info::where('id', $id)->first();
            // dd($info);

            if ($info) {
                return [
                    'status' => 200,
                    'info'  => $info
                ];
            }
        }

        return [
            'status'  => 100,
            'message' => "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Update info details in storage
    |=========================================================
    */
    public function update_info($data, $id)
    {
        if ($data) {

            $formData = [
                'user_id'    => Auth::id(),
                'brand_id'   => $data['brand_id'],
                'title'      => $data['title'],
                'slug'       => Str::slug($data['title']),
                'description'=> $data['description'],
                'status'     => true
            ];
            $brand_id = $data['brand_id'];



			if(isset($data['files']) && !empty($data['files'])){
				$files = $data['files'];
				foreach($files as $file){


			if (isset($file) && $file->isValid()) {
				// $file = $data['file'];
				$fileName = "training_" . $id . '_' . $file->getClientOriginalName();

                $storagePath = 'files/trainings/';
                InfoFile::where('files' , $fileName)->delete();
                // Check if file exists and delete it
                if (Storage::disk('public')->exists($storagePath . $fileName)) {
                    Storage::disk('public')->delete($storagePath . $fileName);
                }

                $file->storeAs('files/trainings', $fileName, 'public');
				$formData2['files'] = $fileName;
				$formData2['name'] = $file->getClientOriginalName();
				$formData2['brand_id'] = $brand_id;
				$formData2['info_id'] = $id;
				InfoFile::create($formData2);
			}
		 }

        }

            Info::where('id', $id)->update($formData);

            return [
                'status' => 200,
                'message'=> 'Info details are updated successfully'
            ];
        }

        return [

            'status' => 100,
            'message'=> 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Soft delete specific info -- by id
    |=========================================================
    */
    public function soft_delete_info($id)
    {
        if ($id) {

            $is_deleted = Info::where('id', $id)->delete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message'=> 'Success, info is archieved'
                ];
            }
        }

        return [
            'status' => 100,
            'message'=> 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Hard delete specific info -- by id
    |=========================================================
    */
    public function permanently_delete_info($id)
    {
        if ($id) {

            $is_deleted = Info::where('id', $id)->forceDelete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message'=> 'Success, info is deleted permanently'
                ];
            }
        }

        return [
            'status' => 100,
            'message'=> 'Sorry, something went wrong'
        ];
    }

    public function getInfoFiles($id){
        if ($id) {
            $files = InfoFile::where('info_id', $id)->where('is_deleted' , 0)->get();
            // dd($files);

            if ($files) {
                return [
                    'status' => 200,
                    'files'  => $files
                ];
            }
        }

        return [
            'status'  => 100,
            'message' => "Sorry, something went wrong"
        ];
    }

    }
