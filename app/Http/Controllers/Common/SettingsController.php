<?php

namespace App\Http\Controllers\Common;

use App\Models\defaultRates;
use App\Models\DefaultSetting;
use App\Models\User;
use App\Models\SiteSetting;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// MODELS
use App\Traits\Base64FilesHandler;
use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Support\Facades\Auth;

// TRAITS
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
	use FilesHandler;
	use Base64FilesHandler;

	/*
	|===========================================================
	| Get admin-user profile details for editing
	|===========================================================
	*/
	public function settings()
	{
		try {
			if (Auth::user()->role_id == 5) {
				$user = User::where('id', Auth::id())->with('role', 'country')->first();
				// dd($user);

				return view('user.settings.index')->with([
					'tab' => "settings",
					'user' => $user,
				]);
			}

			$user = User::where('id', Auth::id())->with('role', 'country')->first();
			// dd($user);

			return view('settings.index')->with([
				'tab' => "settings",
				'user' => $user,
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update admin-user profile details in storage
	|===========================================================
	*/
	public function updateProfile(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:100',
			'last_name' => 'nullable|string|max:100',
			// 'email' => ['required', 'string', 'max:100', Rule::unique('users', 'email')->ignore(Auth::id())],
			'mobile_no' => ['required', 'string', 'max:15'],
			'address' => 'nullable|string|max:255',
			'gender' => 'nullable|string|max:15',
			'date_of_birth' => 'nullable|date',
			'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
		]);

		try {
			$formData = [
				'name' => $request->name,
				'last_name' => $request->last_name,
				// 'email' => $request->email,
				'mobile_no' => $request->mobile_no,
				'country_id' => $request->country_id,
				'state' => $request->state,
				'city' => $request->city,
				'zipcode' => $request->zipcode,
				'address' => $request->address,
				'gender' => $request->gender,
				'bio' => $request->bio,
				'date_of_birth' => $request->date_of_birth,
			];

			if ($request->profile_image) {
				$image_file = $request->profile_image;
				$base64_file = $this->file64($image_file);

				// SAVE BASE64 IMAGE IN STORAGE
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/", true);

				$formData['profile_image'] = $saved_image->file_name;
			}

			User::find($request->user_id)->update($formData);

			Session::flash('Alert', [
				'status' => 200,
				'message' => 'Profile information is updated successfully.'
			]);

			return back();

		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update user profile documents in storage
	|===========================================================
	*/
	public function updateDocuments(Request $request)
	{
		$request->validate([
			'image_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'image_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'image_4' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'resume' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'certificate' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'expiry_date' => 'nullable|date',
		]);

		try {
			$formData = [];
			if ($request->expiry_date) {
				$formData['expiry_date'] = $request->expiry_date;
			}

			if ($request->image_1) {
				$image_file = $request->image_1;
				$base64_file = $this->file64($image_file);
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/docs/", true);
				$formData['image_1'] = $saved_image->file_name;
			}

			if ($request->image_2) {
				$image_file = $request->image_2;
				$base64_file = $this->file64($image_file);
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/docs/", true);
				$formData['image_2'] = $saved_image->file_name;
			}

			if ($request->image_3) {
				$image_file = $request->image_3;
				$base64_file = $this->file64($image_file);
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/docs/", true);
				$formData['image_3'] = $saved_image->file_name;
			}

			if ($request->image_4) {
				$image_file = $request->image_4;
				$base64_file = $this->file64($image_file);
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/docs/", true);
				$formData['image_4'] = $saved_image->file_name;
			}

			if ($request->resume) {
				$image_file = $request->resume;
				$base64_file = $this->file64($image_file);
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/docs/", true);
				$formData['resume'] = $saved_image->file_name;
			}

			if ($request->certificate) {
				$image_file = $request->certificate;
				$base64_file = $this->file64($image_file);
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/users/docs/", true);
				$formData['certificate'] = $saved_image->file_name;
			}

			User::find($request->user_id)->update($formData);

			Session::flash('Alert', [
				'status' => 200,
				'message' => 'User documents are updated successfully.'
			]);

			return back();

		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Go to admin-user old password edit page
	|===========================================================
	*/
	public function editPassword(Request $request)
	{
		try {
			return view('admin.settings.password')->with([
				'tab' => "password",
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update admin-user old password
	|===========================================================
	*/
	public function updatePassword(Request $request)
	{
		$request->validate([
			'old_password' => 'required|min:8|max:20',
			'password' => 'required|min:8|max:20|confirmed'
		]);

		try {
			$old_password = $request->old_password;
			$new_password = $request->password;

			// validate old password
			if (!(Hash::check($old_password, Auth::user()->password))) {

				Session::flash('Alert', [
					'status' => 100,
					'message' => "The old password is incorrect"
				]);

				return back();
			}

			// setup new password
			User::where('id', $request->user_id)
				->update(['password' => Hash::make($new_password)]);

			Session::flash('Alert', [
				'status' => 200,
				'message' => "You have updated your password successfully"
			]);

			return back();
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Get site basic settings for editing
	|===========================================================
	*/
	public function editWebsiteSettings()
	{
		try {
			$website = SiteSetting::first();
			// dd($website);

			return view('admin.settings.site')->with([
				'tab' => "website",
				'website' => $website
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update website basic settings in storage
	|===========================================================
	*/
	public function UpdateWebsiteSettings(Request $request)
	{
		$request->validate([
			'site_name' => 'nullable|string|max:255',
			'site_publisher' => 'nullable|string|max:255',
			'about' => 'nullable|string|max:500',
			'mobile_no' => 'nullable|string|max:20',
			'phone_no' => 'nullable|string|max:20',
			'whatsapp_no' => 'nullable|string|max:20',
			'email' => 'nullable|email|max:50',
			'address' => 'nullable|string|max:255',
			'facebook' => 'nullable|string|max:255',
			'instagram' => 'nullable|string|max:255',
			'twitter' => 'nullable|string|max:255',
			'snapchat' => 'nullable|string|max:255',
			'linkedin' => 'nullable|string|max:255',
			'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
			'favicon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
		]);

		try {
			$formData = [
				'site_name' => $request->site_name,
				'site_publisher' => $request->site_publisher,
				'about' => $request->about,
				'mobile_no' => $request->mobile_no,
				'phone_no' => $request->phone_no,
				'whatsapp_no' => $request->whatsapp_no,
				'email' => $request->email,
				'address' => $request->address,
				'primary_color' => $request->primary_color,
				'secondary_color' => $request->secondary_color,
				'footer_1_color' => $request->footer_1_color,
				'footer_2_color' => $request->footer_2_color,
				'wistia_player_mode' => $request->wistia_player_mode,
				'facebook' => $request->facebook,
				'instagram' => $request->instagram,
				'twitter' => $request->twitter,
				'snapchat' => $request->snapchat,
				'linkedin' => $request->linkedin
			];

			// SAVE LOGO IMAGE
			if ($request->logo) {
				$image_file = $request->logo;
				$base64_file = $this->file64($image_file);

				// SAVE BASE64 IMAGE IN STORAGE
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/site/logo/", true);

				$formData['logo'] = $saved_image->file_name;
			}

			// SAVE FAVICON
			if ($request->favicon) {
				$image_file = $request->favicon;
				$base64_file = $this->file64($image_file);

				// SAVE BASE64 IMAGE IN STORAGE
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/site/favicon/", true);

				$formData['favicon'] = $saved_image->file_name;
			}

			SiteSetting::find(Auth::id())->update($formData);

			Session::flash('Alert', [
				'status' => 200,
				'message' => 'Site settings are updated successfully.'
			]);

			return back();

		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| View website homepage video
	|===========================================================
	*/
	public function viewHomepageVideo()
	{
		try {
			$video = SiteSetting::first();
			// dd($video);

			return view('admin.settings.home-video')->with([
				'tab' => "video",
				'video' => $video
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update website basic settings in storage
	|===========================================================
	*/
	public function updateHomepageVideo(Request $request)
	{
		$request->validate([
			'homepage_video' => 'nullable|file|mimetypes:video/mp4',
			'homepage_video_title' => 'nullable|string|max:200',
			'homepage_video_description' => 'nullable|string|max:500',
		]);

		try {

			$formData = [
				'homepage_video_title' => $request->homepage_video_title,
				'homepage_video_description' => $request->homepage_video_description,
			];

			if ($request->homepage_video) {

				$fileName = $request->homepage_video->getClientOriginalName();
				$filePath = 'videos/site/' . time() . '_' . $fileName;

				$isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->homepage_video));
				$formData['homepage_video'] = $filePath;
			}

			SiteSetting::find(Auth::id())->update($formData);

			Session::flash('Alert', [
				'status' => 200,
				'message' => 'Homepage video data is updated successfully.'
			]);

			return back();

		} catch (\Throwable $th) {
			throw $th;
		}

	}

	/*
	|===========================================================
	| Show website about us page information
	|===========================================================
	*/
	public function editAboutUsData()
	{
		try {
			$about = AboutPage::first();
			// dd($about);

			return view('admin.settings.about-us')->with([
				'tab' => "about",
				'about' => $about
			]);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/*
	|===========================================================
	| Update website basic settings in storage
	|===========================================================
	*/
	public function updateAboutUsData(Request $request)
	{
		$request->validate([
			'title' => 'required|string|max:255',
			'video_title' => 'nullable|string|max:500',
			'about' => 'nullable|string|max:500',
			'team' => 'nullable|string|max:500',
		]);

		try {

			$formData = [
				'title' => $request->title,
				'description' => $request->description,
				'video_title' => $request->video_title,
				'video_description' => $request->video_description,
				// 'video' => $request->video,
				'about' => $request->about,
				'about_title' => $request->about_title,
				'about_description' => $request->about_description,
				'team' => $request->team,
				'team_title' => $request->team_title,
				'team_description' => $request->team_description,
				'cofounder_1_name' => $request->cofounder_1_name,
				'cofounder_1_designation' => $request->cofounder_1_designation,
				'cofounder_1_details' => $request->cofounder_1_details,
				'cofounder_2_name' => $request->cofounder_2_name,
				'cofounder_2_designation' => $request->cofounder_2_designation,
				'cofounder_2_details' => $request->cofounder_2_details,
			];

			// STORE VIDEO
			// if ($request->homepage_video) {

			// $fileName = $request->homepage_video->getClientOriginalName();
			// $filePath = 'videos/site/' . time() . '_' . $fileName;

			// $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->homepage_video));
			// $formData['homepage_video'] = $filePath;
			// }

			// co-founder-1 image
			if ($request->cofounder_1_image) {
				$image_file = $request->cofounder_1_image;
				$base64_file = $this->file64($image_file);

				// SAVE BASE64 IMAGE IN STORAGE
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/founders/", true);
				$formData['cofounder_1_image'] = $saved_image->file_name;
			}

			// co-founder-2 image
			if ($request->cofounder_2_image) {
				$image_file = $request->cofounder_2_image;
				$base64_file = $this->file64($image_file);

				// SAVE BASE64 IMAGE IN STORAGE
				$saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/founders/", true);
				$formData['cofounder_2_image'] = $saved_image->file_name;
			}

			AboutPage::where('id', 1)->update($formData);

			Session::flash('Alert', [
				'status' => 200,
				'message' => 'About us page content is updated successfully.'
			]);

			return back();

		} catch (\Throwable $th) {
			throw $th;
		}

	}

	public function siteSettings()
	{
		$flatRate = app('flatRate');

		return view('settings.site_settings')
			->with([
				'tab' => "settings",
				'flatRate' => $flatRate,
			]);
		;
	}

	public function siteSettingsStore(Request $request)
	{
		$rate = $request->flat_rate ?? 0;

		defaultRates::where('is_active', 1)
			->update([
				'is_active' => 0
			]);
		defaultRates::create(['flat_rate' => $rate]);
		Session::flash('Alert', [
			'status' => 200,
			'message' => 'Rate updated successfully.'
		]);

		return back();
	}

	public function userSettings($id)
	{
		try {
			$user = User::where('id', $id)->with('role', 'country')->first();
			// dd($user);

			return view('user.settings.user-setting')->with([
				'tab' => "settings",
				'user' => $user,
			]);


		} catch (\Throwable $th) {
			throw $th;
		}
}
}
