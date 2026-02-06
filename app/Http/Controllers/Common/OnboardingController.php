<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\ictForm;
use App\Models\Notification;
use App\Models\Payroll;
use App\Models\W9Form;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Services\BrandsService;

use App\Traits\FilesHandler;
use App\Traits\Base64FilesHandler;

class OnboardingController extends Controller
{
	use FilesHandler;
	use Base64FilesHandler;

	/*
	|===========================================================
	| Get listing of all w9forms
	|===========================================================
	*/
	public function w9Forms()
	{
		try {
			$w9forms = W9Form::with('user')->get();
			// dd($w9forms);

			return view('onboarding.w9forms-list')->with([
				'w9forms' => $w9forms,
			]);

		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Show the form for editing w9form
	|===========================================================
	*/
	public function w9formDetail($id = null)
	{
		try {
			// for user role
			if (Auth::user()->role_id == 5) {

				$id = Auth::id();
				$w9form = W9Form::where('user_id', $id)
					->with('user')
					->first();

				return view('user.onboarding.w9form')->with([
					'w9form' => $w9form
				]);
			}

			// for admin roles
			$w9form = W9Form::where('id', $id)
				->with('user')
				->first();

			return view('onboarding.w9form')->with([
				'w9form' => $w9form
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update the w9form details in storage
	|===========================================================
	*/
	public function updateW9FormDetail(Request $request, $id = null)
	{
		// dd($request->all());

		$request->validate([
			"name" => "nullable|string|max:255",
			"business_name" => "nullable|string|max:255",
			"federal_tax_classification" => "nullable|string|max:255",
			"exempt_payee_code" => "nullable|string|max:255",
			"fatca_reporting_code" => "nullable|string|max:255",
			"address" => "required|string|max:255",
			"city_state_zipcode" => "required|string|max:255",
			"account_number" => "nullable|string|max:255",
			"requester_name" => "nullable|string|max:255",
			"social_security_number" => "nullable|string|max:255",
			"employer_identification_number" => "nullable|string|max:255",
			"date" => "nullable|date",
		]);

		try {

			$formData = [
				'user_id' => Auth::id(),
				'name' => $request->name,
				'business_name' => $request->business_name,
				'federal_tax_classification' => $request->federal_tax_classification,
				'exempt_payee_code' => $request->exempt_payee_code,
				'fatca_reporting_code' => $request->fatca_reporting_code,
				'address' => $request->address,
				'city_state_zipcode' => $request->city_state_zipcode,
				'account_number' => $request->account_number,
				'requester_name' => $request->requester_name,
				'social_security_number' => $request->social_security_number,
				'employer_identification_number' => $request->employer_identification_number,
				'date' => $request->date,
				'digital_signature' => $request->digital_signature,
				'status' => true,
			];

			W9Form::updateOrCreate(
				['user_id' => Auth::id()],
				$formData
			);

			// Fetch the ID of the updated record
			$updatedRecordId = W9Form::where('user_id', Auth::id())->value('id');

			Notification::create([
				'user_id' => 1,
				'title' => "W9 Form Submitted",
				'description' => "W9 Form has been submitted by " . Auth::user()->name . " " . Auth::user()->last_name,
				'link' => '/onboarding/w9form/' . $updatedRecordId
			]);

			Session::flash('Alert', [
				'status' => 200,
				'message' => "W9 form information is udpated successfully",
			]);

			return back();
		} catch (\Throwable $th) {
			throw $th;
		}

	}

	/*
	|===========================================================
	| Get listing of all payrolls
	|===========================================================
	*/
	public function payrolls()
	{
		try {
			$payrolls = Payroll::with('user')->get();
			// dd($payrolls);

			return view('onboarding.payrolls-list')->with([
				'payrolls' => $payrolls,
			]);

		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Show the form for editing payroll
	|===========================================================
	*/
	public function payrollDetail($id = null)
	{
		try {
			// for user role
			if (Auth::user()->role_id == 5) {

				$id = Auth::id();
				$payroll = Payroll::where('user_id', $id)
					->with('user')
					->first();

				return view('user.onboarding.payroll')->with([
					'payroll' => $payroll
				]);
			}

			// for admin roles
			$payroll = Payroll::where('id', $id)
				->with('user')
				->first();

			return view('onboarding.payroll')->with([
				'payroll' => $payroll
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update the payrolls details in storage
	|===========================================================
	*/
	public function updatePayrollDetail(Request $request, $id = null)
	{



		$request->validate([
			"name" => "required|string|max:255",
			"phone_no" => "required|string|max:20",
			"payment_preference" => "nullable|string|max:255",
			"email_address" => "required|email|max:50",
			"fatca_reporting_code" => "nullable|string|max:255",
			"address" => "nullable|string|max:255",
			'payrole_id' => 'nullable|exists:payrolls,id',
			"voided_check" => "nullable|file|mimes:jpeg,png,jpg",
		]);

		try {
			$formData = [
				// 'user_id' => Auth::id(),
				'name' => $request->name,
				'phone_no' => $request->phone_no,
				'payment_preference' => $request->payment_preference,
				'email_address' => $request->email_address,
				'fatca_reporting_code' => $request->fatca_reporting_code,
				'address' => $request->address,
				'status' => true,
			];

			if ($request->voided_check) {
				$image_file = $request->voided_check;
				$base64_file = $this->file64($image_file);

				// SAVE BASE64 IMAGE IN STORAGE
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/payrolls/", true);

				$formData['voided_check'] = $saved_image->file_name;
			}

			Payroll::updateOrCreate(
				// ['user_id' => Auth::id()],
				['id' => $request->payrole_id],
				$formData
			);

			// Fetch the ID of the updated record
			// $updatedRecordId = Payroll::where('user_id', )->value('id');
			$updatedRecordId = Payroll::with('user')->find($request->payrole_id);
			// dd($updatedRecordId->user->id);


			Notification::create([
				'user_id' => $updatedRecordId->user->id,
				'title' => "Payroll Form Submitted",
				'description' => "Payroll Form has been submitted by " . Auth::user()->name . " " . Auth::user()->last_name,
				'link' => '/onboarding/payroll/' . $updatedRecordId
			]);

			Session::flash('Alert', [
				'status' => 200,
				'message' => "Payroll information is updated successfully",
			]);

			return back();
		} catch (\Throwable $th) {
			throw $th;
		}

	}

	public function ICTForms()
	{
		try {
			$ICforms = ictForm::with('user')->get();
			// dd($w9forms);

			return view('onboarding.ic_form-list')->with([
				'ICforms' => $ICforms,
			]);

		} catch (\Throwable $th) {
			throw $th;
		}
	}
	public function ICTformDetail($id = null)
	{





		try {
			// for user role
			if (Auth::user()->role_id == 5) {

				$id = Auth::id();
				$ictForm = ictForm::where('user_id', $id)
					->with('user')
					->first();

				// dd('F');
				return view('user.onboarding.ict_form')->with([
					'ict_form' => $ictForm
				]);
			}



			// for admin roles
			$ictForm = ictForm::where('id', $id)
				->with('user')
				->first();



			return view('onboarding.ict_form')->with([
				'ict_form' => $ictForm
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	

	// public function updateictFormDetail(Request $request, $id = null)
	// {
	// 	dd($request->all());

	// 	$request->validate([
	// 		"name" => "nullable|string|max:255",
	// 		"business_name" => "nullable|string|max:255",
	// 		"federal_tax_classification" => "nullable|string|max:255",
	// 		"exempt_payee_code" => "nullable|string|max:255",
	// 		"fatca_reporting_code" => "nullable|string|max:255",
	// 		"address" => "required|string|max:255",
	// 		"city_state_zipcode" => "required|string|max:255",
	// 		"account_number" => "nullable|string|max:255",
	// 		"requester_name" => "nullable|string|max:255",
	// 		"social_security_number" => "nullable|string|max:255",
	// 		"employer_identification_number" => "nullable|string|max:255",
	// 		"date" => "nullable|date",
	// 	]);

	// 	try {

	// 		$formData = [
	// 			'user_id' => Auth::id(),
	// 			'name' => $request->name,
	// 			'business_name' => $request->business_name,
	// 			'federal_tax_classification' => $request->federal_tax_classification,
	// 			'exempt_payee_code' => $request->exempt_payee_code,
	// 			'fatca_reporting_code' => $request->fatca_reporting_code,
	// 			'address' => $request->address,
	// 			'city_state_zipcode' => $request->city_state_zipcode,
	// 			'account_number' => $request->account_number,
	// 			'requester_name' => $request->requester_name,
	// 			'social_security_number' => $request->social_security_number,
	// 			'employer_identification_number' => $request->employer_identification_number,
	// 			'date' => $request->date,
	// 			'digital_signature' => $request->digital_signature,
	// 			'status' => true,
	// 		];

	// 		ictForm::updateOrCreate(
	// 			['user_id' => Auth::id()],
	// 			$formData
	// 		);

	// 		// Fetch the ID of the updated record
	// 		$updatedRecordId = ictForm::where('user_id', Auth::id())->value('id');

	// 		Notification::create([
	// 			'user_id' => 1,
	// 			'title' => "IC Aggrement Form Submitted",
	// 			'description' => "IC Aggrement Form has been submitted by " . Auth::user()->name . " " . Auth::user()->last_name,
	// 			'link' => '/onboarding/ic-aggrement/' . $updatedRecordId
	// 		]);

	// 		Session::flash('Alert', [
	// 			'status' => 200,
	// 			'message' => "IC Aggrement form information is udpated successfully",
	// 		]);

	// 		return back();
	// 	} catch (\Throwable $th) {
	// 		throw $th;
	// 	}

	// }

	public function updateictFormDetail(Request $request, $id = null)
{
    // ✅ Validation (image wali fields)
    $request->validate([
        'name'              => 'required|string|max:255',
        'email'             => 'required|email|max:255',
        'date'              => 'required|date',
        'digital_signature' => 'required|boolean',
    ]);

    try {

        $formData = [
            'user_id'           => Auth::id(),
            'name'              => $request->name,
            'email'             => $request->email,
            'date'              => $request->date,
            'digital_signature' => $request->digital_signature,
            'status'            => true,
        ];

        // ✅ Create or Update
        $ictForm = ictForm::updateOrCreate(
            ['user_id' => Auth::id()],
            $formData
        );

        // ✅ Admin Notification
        Notification::create([
            'user_id'     => 1,
            'title'       => 'IC Agreement Form Submitted',
            'description' => 'IC Agreement Form has been submitted by '
                . Auth::user()->name . ' ' . Auth::user()->last_name,
            'link'        => '/onboarding/ic-aggrement/' . $ictForm->id,
        ]);

        Session::flash('Alert', [
            'status'  => 200,
            'message' => 'IC Agreement form submitted successfully',
        ]);

        return back();

    } catch (\Throwable $th) {
        throw $th;
    }
}


}
