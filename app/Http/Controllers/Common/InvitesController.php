<?php

namespace App\Http\Controllers\Common;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\RolesService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\InvitesService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InvitesController extends Controller
{
	protected $roles_service;
	protected $invites_service;

	public function __construct(RolesService $rs, InvitesService $is)
	{
		$this->roles_service = $rs;
		$this->invites_service = $is;
	}


	/*
	|===========================================================
	| Get listing of all admin invites
	|===========================================================
	*/
	public function adminInvites(Request $request)
	{
		try {
			$filter = $request->tab;
			$invites = $this->invites_service->get_admin_invites($filter);
			// dd($invites);

			return view('invites.admin.index')->with([
				'tab' => $filter,
				'invites' => $invites,
			]);
		}
		catch (\Throwable $th) {
			throw $th;
		}
	}



	/*
	|===========================================================
	| Show the form for inviting new admins
	|===========================================================
	*/
	public function createAdminInvites()
	{
		try {
			$response = $this->roles_service->get_admin_roles();
			// dd($response);

			if ($response['status'] == 200) {

				return view('invites.admin.invite')->with([
					'roles' => $response['roles'],
				]);
			}

			Session::flash('Alert', [
				'status' => 100,
				'message'=> $response['message']
			]);

			return view('errors.500');
		}
		catch (\Throwable $th) {
			throw $th;
		}
	}



	/*
	|===========================================================
	| Store new admin invites in storage
	|===========================================================
	*/
	public function storeAdminInvites(Request $request)
	{
		$request->validate([
			"role_id" => "required|array|min:1",
			"role_id.*" => "required|integer",
			"email" => "required|array|min:1",
			"email.*" => "required|email|distinct",
		]);

		try {
			$data = $request->all();
			$response = $this->invites_service->invite_new_admins($data);
			// dd($response);

			if ($response['status'] == 200) {

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
		}
		catch (\Throwable $th) {
			throw $th;
		}

	}



	/*
	|===========================================================
	| Get listing of all user invites
	|===========================================================
	*/
	public function userInvites(Request $request)
	{
		try {
			$filter = $request->tab;
			$invites = $this->invites_service->get_user_invites($filter);
			// dd($invites);

			return view('invites.user.index')->with([
				'tab' => $filter,
				'invites' => $invites,
			]);
		}
		catch (\Throwable $th) {
			throw $th;
		}
	}



	/*
	|===========================================================
	| Show the form for inviting new users
	|===========================================================
	*/
	public function createUserInvites()
	{
		try {
			$roles = $this->roles_service->get_admin_roles();
			// dd($roles);

			return view('invites.user.invite')->with([
				'roles' => $roles,
			]);
		}
		catch (\Throwable $th) {
			throw $th;
		}
	}



	/*
	|===========================================================
	| Store new user invites in storage
	|===========================================================
	*/
	public function storeUserInvites(Request $request)
	{
		$request->validate([
			"email" => "required|array|min:1|unique:users,email",
			"email.*" => "required|email|distinct",

		]);

		try {
			$data = $request->all();
			$response = $this->invites_service->invite_new_users($data);
			// dd($response);

			if ($response['status'] == 200) {

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
		}
		catch (\Throwable $th) {
			throw $th;
		}

	}


	public function bulkUploadView(Request $request){
		return view('invites.user.upload_bulk');
	}

	public function bulkUploadStore(Request $request){
        $request->all();
		$file = $request->file('file');
		$fields=['name','email'];

		$spreadsheet = IOFactory::createReaderForFile($file);
			$spreadsheet->setReadDataOnly(true);

			$spreadsheet = $spreadsheet->load($file)->getActiveSheet()->toArray();
			if (count($spreadsheet) < 10000) {
				$header = $spreadsheet[0];
				$header = array_map(function ($header) {
					return preg_replace('/\s+/', '', $header);
				}, $header);
				if (count(array_diff($fields, $header)) === 0) {
					array_shift($spreadsheet);
					foreach ($spreadsheet as $key2 => $spreadsheet_row) {
						$row = array();
						foreach ($spreadsheet_row as $key => $value) {
							$row[$fields[$key]] = $value;
						}
						$cn[] = $row;
					}
				}
                $data = [
                    'email' => array_map(function ($value) {
                        return $value['email'];
                    }, $cn)
                ];
// dd($data);
                 try {
                    // $data = $request->all();
                    $response = $this->invites_service->invite_new_users($data);
                    // dd($response);

                    if ($response['status'] == 200) {

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
                }
                catch (\Throwable $th) {
                    throw $th;
                }

			}
	}
}
