<?php
namespace App\Services;

use App\Models\Brand;
use App\Models\Training;
use App\Models\TrainingFile;
use Illuminate\Support\Str;
use App\Models\UserTraining;
use Illuminate\Http\Request;
use App\Traits\FilesHandler;
use App\Traits\Base64FilesHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainingsService extends BaseService
{
	use FilesHandler;
	use Base64FilesHandler;

	/*
	|=========================================================
	| Get listing of all trainings
	|=========================================================
	*/
	public function get_all_trainings($filter)
	{
		$trainings = Training::with('brand','admin')->orderBy('id','ASC');
		// dd($trainings);

		// apply filters
		if ($filter == 'active') {
			$trainings = $trainings->where('status', true);
		}
		if ($filter == 'inactive') {
			$trainings = $trainings->where('status', false);
		}

		$trainings = $trainings->get();

		return [
			'status' => 200,
			'trainings' => $trainings
		];
	}



	/*
	|=========================================================
	| Get listing of all user-trainings
	|=========================================================
	*/
	public function get_user_trainings($filter)
	{
		$trainings = UserTraining::with('user','training.brand')->orderBy('id','ASC');
		// dd($trainings);

		// apply filters
		if ($filter == 'pending') {
			$trainings = $trainings->where('status', 'pending');
		}
		if ($filter == 'completed') {
			$trainings = $trainings->where('status', 'completed');
		}

		$trainings = $trainings->get();

		return [
			'status' => 200,
			'trainings' => $trainings
		];
	}



	/*
	|=========================================================
	| Get listing of all active trainings
	|=========================================================
	*/
	public function get_active_trainings()
	{
		$trainings = Training::where('status', TRUE)->get();
		// dd($trainings);

		if ($trainings) {
			return [
				'status' => 200,
				'trainings' => $trainings
			];
		}

		return [
			'status' => 100,
			'message'=> "Sorry, something went wrong"
		];
	}



	/*
	|=========================================================
	| Store new training in storage
	|=========================================================
	*/
	public function add_new_training($data)
	{
		if ($data) {

			DB::beginTransaction();

			$brand_id = $data['brand_id'];

			$formData = [
				'user_id' => Auth::id(),
				'brand_id' => $brand_id,
				'title' => $data['title'],
				'slug' => Str::slug($data['title']),
				'description'=> $data['description'],
				'start_date' => date('Y-m-d'),
				'end_date' => date("Y-m-d"),
				'status' => true,
			];


			$tr = Training::create($formData);
			if(isset($data['files']) && !empty($data['files'])){
				$files = $data['files'];
				foreach($files as $file){


			if (isset($file) && $file->isValid()) {
				// $file = $data['file'];
				$fileName = "training_" . $tr->id . '_' . $file->getClientOriginalName();

                $storagePath = 'files/trainings/';

                // Check if file exists and delete it
                if (Storage::disk('public')->exists($storagePath . $fileName)) {
                    Storage::disk('public')->delete($storagePath . $fileName);
                }
                $file->storeAs('files/trainings', $fileName, 'public');
				$formData2['files'] = $fileName;
				$formData2['name'] = $file->getClientOriginalName();
				$formData2['training_id'] = $tr->id;
				$formData2['brand_id'] = $brand_id;
				TrainingFile::create($formData2);
			}
		}

        }
			// update brand training upload status
			Brand::where('id', $brand_id)->update(['is_training_uploaded' => true]);

			DB::commit();

			return [
				'status' => 200,
				'message'=> 'New training is added successfully'
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
	| Store new user-training in storage
	|=========================================================
	*/
	public function add_user_training($data)
	{
		if ($data) {

			$formData = [
				'user_id' => $data['user_id'],
				'training_id'=> $data['training_id'],
				'due_date' => $data['due_date'],
				'status' => $data['status'],
			];

			UserTraining::create($formData);

			return [
				'status' => 200,
				'message'=> 'User training is added successfully'
			];
		}

		return [
			'status' => 100,
			'message'=> 'Sorry, something went wrong'
		];
	}



	/*
	|=========================================================
	| Get specific training details
	|=========================================================
	*/
	public function get_training_detail($id)
	{
		if ($id) {
			$training = Training::with('brand','admin')->where('id', $id)->first();
			// dd($training);

			if ($training) {
				return [
					'status' => 200,
					'training' => $training
				];
			}
		}

		return [
			'status' => 100,
			'message' => "Sorry, something went wrong"
		];
	}



	/*
	|=========================================================
	| Update training details in storage
	|=========================================================
	*/
	public function update_training($data, $id)
	{
		if ($data) {

            $brand_id = $data['brand_id'];

			$formData = [
				'user_id' => Auth::id(),
				'brand_id' => $data['brand_id'],
				'title' => $data['title'],
				'slug' => Str::slug($data['title']),
				'description'=> $data['description'] ?? date("Y-m-d"),
				'start_date' => date("Y-m-d"),
				'end_date' => date("Y-m-d"),
				'status' => true,
			];

            // $tr = Training::create($formData);
			Training::where('id', $id)->update($formData);

			if(isset($data['files']) && !empty($data['files'])){
				$files = $data['files'];
				foreach($files as $file){


			if (isset($file) && $file->isValid()) {
				// $file = $data['file'];
				$fileName = "training_" . $id . '_' . $file->getClientOriginalName();

                $storagePath = 'files/trainings/';
                TrainingFile::where('files' , $fileName)->delete();
                // Check if file exists and delete it
                if (Storage::disk('public')->exists($storagePath . $fileName)) {
                    Storage::disk('public')->delete($storagePath . $fileName);
                }

                $file->storeAs('files/trainings', $fileName, 'public');
				$formData2['files'] = $fileName;
				$formData2['name'] = $file->getClientOriginalName();
				$formData2['training_id'] = $id;
				$formData2['brand_id'] = $brand_id;
				TrainingFile::create($formData2);
			}
		 }

        }
			// dd($id);


			return [
				'status' => 200,
				'message'=> 'Training details are updated successfully'
			];
		}

		return [
			'status' => 100,
			'message'=> 'Sorry, something went wrong'
		];
	}



	/*
	|=========================================================
	| Soft delete specific training -- by id
	|=========================================================
	*/
	public function soft_delete_training($id)
	{
		if ($id) {

			$is_deleted = Training::where('id', $id)->delete();
			if ($is_deleted) {
				return [
					'status' => 200,
					'message'=> 'Success, training is archieved'
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
	| Hard delete specific training -- by id
	|=========================================================
	*/
	public function permanently_delete_training($id)
	{
		if ($id) {

			$is_deleted = Training::where('id', $id)->forceDelete();
			if ($is_deleted) {
				return [
					'status' => 200,
					'message'=> 'Success, training is deleted permanently'
				];
			}
		}

		return [
			'status' => 100,
			'message'=> 'Sorry, something went wrong'
		];
	}

    public function getTrainingFile($id){
        if ($id) {
            $files = TrainingFile::where('training_id', $id)->where('is_deleted' , 0)->get();
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
