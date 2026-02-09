<?php

namespace App\Http\Controllers\Common;

use App\Models\Job;
use App\Models\JobMember;
use App\Models\Quiz;
use App\Models\Brand;
use App\Models\Recap;
use App\Imports\JobsImport;
use App\Models\Training;
use App\Models\UserPaymentJobHistory;
use App\Models\WorkHistory;
use App\Services\NotificationsService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\RolesService;
use App\Services\UsersService;
use App\Services\ShiftsService;
use App\Services\InvitesService;
use App\Http\Controllers\Controller;
use App\Models\JobCoverageOffer;
use App\Models\JobCoverageRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use PDO;
use Route;
use App\Models\UserRecap;

class ShiftsController extends Controller
{
    protected $shifts_service;
    protected $users_service;
    protected $notification_service;

    public function __construct(ShiftsService $ss, UsersService $us, NotificationsService $ns)
    {
        $this->shifts_service = $ss;
        $this->users_service = $us;
        $this->notification_service = $ns;
    }

    /*
|===========================================================
| Get listing of all shifts
|===========================================================
*/
    public function index(Request $request)
    {

        try {
            $tab = $request->tab ?? "all";
            $date = $request->date;
            $filter = null;

            if ($tab == 'published') {
                $filter['is_published'] = 1;
            } elseif ($tab == 'unpublished') {
                $filter['is_published'] = 0;
            }

            if (Auth::user()->role_id == 5) {

                $response = $this->shifts_service->get_user_shifts($filter);

                return view('job.user_index')->with([
                    'tab' => $tab,
                    'shifts' => $response['shifts'],
                ]);
            }
            if ($date != '') {
                $filter['date'] = $date;
            }

            $response = $this->shifts_service->get_all_shifts($filter);
            $avalable_user = $this->shifts_service->get_available_user();

            if ($response['status'] == 200) {

                return view('job.index')->with([
                    'tab' => $tab,
                    'shifts' => $response['shifts'],
                    'avalable_user' => $avalable_user
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
|===========================================================
| show the form for importing shifts schedule
|===========================================================
*/
    public function showImportForm()
    {
        try {
            return view('job.import');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
|===========================================================
| Store newly created shifts in storage
|===========================================================
*/
    public function importShifts(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
            'shifts' => 'required|mimes:xls,xlsx,csv'
        ]);
        try {
            $shifts_file = $request->file('shifts');
            // Initialize counters for success and failure
            $successCount = 0;
            $failureCount = 0;

            // Import jobs in database
            Excel::import(new JobsImport($successCount, $failureCount), $shifts_file);

            // Sync brands from jobs
            $brands = Job::whereNotNull('brand')
                ->distinct()
                ->pluck('brand')
                ->toArray();
            foreach ($brands as $brand) {
                // Check if the brand already exists
                $brandData = Brand::where('title', $brand);

                $brandExists = $brandData->exists();

                // If the brand does not exist, insert it
                if (!$brandExists) {
                    $brand_save = Brand::create([
                        'title' => $brand,
                        'slug' => Str::slug($brand),
                        'description' => NULL,
                        'status' => TRUE,
                    ]);
                    // dd($brand);

                    Job::where('brand', $brand)
                        ->whereNull('brand_id')
                        ->update(
                            [
                                'brand_id' => $brand_save->id
                            ]
                        );
                } else {
                    Job::where('brand', $brand)
                        ->whereNull('brand_id')
                        ->update(
                            [
                                'brand_id' => $brandData->first()->id
                            ]
                        );
                }
            }

            // Send flash message with the success and failure count
            Session::flash('Alert', [
                'status' => 200,
                'message' => "$successCount Records are imported successfully, $failureCount Records failed to import.",
            ]);

            return back();
        } catch (\Throwable $th) {
            // Handle any exceptions that occur during the import
            Session::flash('Alert', [
                'status' => 500,
                'message' => "An error occurred during the import. Please try again.",
            ]);
            return back();
        }
    }

    /*
|===========================================================
| Show the form for editing the specified job
|===========================================================
*/
    public function editJob($id)
    {
        try {
            $response = $this->shifts_service->get_shift_detail($id);
            $jobMemeber = JobMember::where("job_id", $id)->where('user_id', Auth::user()->id)->first();
            if (Auth::user()->role_id == 5) {
                return view('job.user_accept')->with([
                    'shift' => $response['shift'],
                    'jobMembers' => $jobMemeber
                ]);
            }

            // dd($response);

            if ($response['status'] == 200) {
                return view('job.edit')->with([
                    'shift' => $response['shift'],
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

    public function UserJobDetail(Request $request, $id)
    {
        try {


            if ($request->coverage === 'true') {
                // dd('d');
                $response = $this->shifts_service->coverage_request_on_detail($id);
				$response = json_decode(json_encode($response), true);

                // dd($response);
                $check_coverage = JobCoverageOffer::where('user_id', auth::user()->id)
                    ->join('job_coverage_requests as jcr', 'jcr.id', '=', 'job_coverage_offers.coverage_request_id')
                    ->pluck('job_id')
                    ->toArray();

                $jobMemeber = JobMember::where("job_id", $id)->where('user_id', Auth::user()->id)->first();
                if (Auth::user()->role_id == 5) {
                    return view('job.user_accept_detail')->with([
                        'shift' => $response['shifts'],
                        'jobMembers' => $jobMemeber
                    ]);
                }

            } else {

                $response = $this->shifts_service->get_shift_detail($id);
                $jobMemeber = JobMember::where("job_id", $id)->where('user_id', Auth::user()->id)->first();
                if (Auth::user()->role_id == 5) {
                    return view('job.user_accept_detail')->with([
                        'shift' => $response['shift'],
                        'jobMembers' => $jobMemeber
                    ]);
                }
            }


            // dd($response);
            $response = $this->shifts_service->get_shift_detail($id);

            if ($response['status'] == 200) {
                return view('job.edit')->with([
                    'shift' => $response['shift'],
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
| Update the specified job details in storage
|===========================================================
*/
    public function updateJob(Request $request, $id)
    {
        try {
            $request->validate([
                "account" => "required|string|max:255",
                "brand" => "required|string|max:255",
                "contact" => "nullable|string|max:100",
                "phone" => "nullable|string|max:50",
                "email" => "nullable|email|max:50",
                "method_of_communication" => "nullable|string|max:100",
                "address" => "nullable|string|max:255",
                "date" => "nullable|date",
                "timezone" => "nullable|string|max:5",
                "scheduled_time" => "nullable|string|max:255",
                "skus" => "nullable|string|max:255",

            ]);

            $data = $request->all();
            $response = $this->shifts_service->update_job_detail($data, $id);
            // dd($response);

            if ($response['status'] == 200) {

                $members = JobMember::where('job_id', $id)->get('user_id')->toArray();
                foreach ($members as $m) {
                    // $j_id = $m['id'];
                    $nlink = URL::to("user/shift/" . $id . "/detail");
                    ;

                    $notification_data = [
                        'user_id' => $m['user_id'],
                        'title' => "Shift Update",
                        'description' => "The Shift has Just Updated. Please review it.",
                        'link' => $nlink
                    ];
                    $this->notification_service->store_notification($notification_data);
                }
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
| Publish multiple jobs simultaneouly
|===========================================================
*/
    public function publishJobs(Request $request)
    {

        try {
            $request->validate([
                "job_ids" => "required|array",
            ]);

            $job_ids = $request->job_ids;

            // allow publishing the jobs only if the jobs shift brand has quizzes and recaps created
            foreach ($job_ids as $key => $job_id) {

                $job = Job::where('id', $job_id)->first();

                if ($job) {
                    $brand = $job->brand;
                    $brand = Brand::where('title', $brand)->first();

                    if ($brand) {

                        // validate quiz for this brand
                        $quiz_exists = Quiz::where('brand_id', $brand->id)->first();

                        if (!$quiz_exists) {

                            if (request()->ajax()) {
                                // If the request is an AJAX request, return a JSON response
                                return response()->json([
                                    'status' => 100,
                                    'message' => "You first need to create a quiz for this brand to publish this job (JOB ID - " . $job_id . ')',
                                ]);
                            } else {
                                // If it's a regular HTTP request, use session flash and redirect back
                                Session::flash('Alert', [
                                    'status' => 100,
                                    'message' => "You first need to create a quiz for this brand to publish this job (JOB ID - " . $job_id . ')',
                                ]);
                                return back();
                            }
                        }
                        // validate recaps for this brand
                        $recap_exists = Recap::where('brand_id', $brand->id)->first();
                        // dd($recap_exists);
                        if (!$recap_exists) {
                            if (request()->ajax()) {
                                // If the request is an AJAX request, return a JSON response
                                return response()->json([
                                    'status' => 100,
                                    'message' => "You first need to create a recap for this brand to publish this job (JOB ID - " . $job_id . ')',
                                ]);
                            } else {
                                // If it's a regular HTTP request, use session flash and redirect back
                                Session::flash('Alert', [
                                    'status' => 100,
                                    'message' => "You first need to create a recap for this brand to publish this job (JOB ID - " . $job_id . ')',
                                ]);
                                return back();
                            }
                        }
                        // validate recaps for this brand
                        $training_exist = Training::where('brand_id', $brand->id)->first();
                        // dd($recap_exists);
                        if (!$training_exist) {
                            if (request()->ajax()) {
                                // If the request is an AJAX request, return a JSON response
                                return response()->json([
                                    'status' => 100,
                                    'message' => "You first need to create a training for this brand to publish this job (JOB ID - " . $job_id . ')',
                                ]);
                            } else {
                                // If it's a regular HTTP request, use session flash and redirect back
                                Session::flash('Alert', [
                                    'status' => 100,
                                    'message' => "You first need to create a training for this brand to publish this job (JOB ID - " . $job_id . ')',
                                ]);
                                return back();
                            }
                        }
                    }
                }
            }

            $response = $this->shifts_service->publish_multiple_jobs($job_ids);
            if ($response['status'] == 200) {

                if (request()->ajax()) {
                    // If the request is an AJAX request, return a JSON response
                    return response()->json([
                        'status' => 200,
                        'message' => "Published",
                    ]);
                } else {
                    // If it's a regular HTTP request, use session flash and redirect back
                    Session::flash('Alert', [
                        'status' => 200,
                        'message' => "Published",
                    ]);
                    return back();
                }

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
| Get listing of all job members
|===========================================================
*/
    public function jobMembers($job_id)
    {

        try {

            if (Auth::user()->role_id == 5) {
                return redirect()->to(URL::to("user/shift/$job_id/detail?coverage=true"));
            } else {
                $users = $this->users_service->get_all_users('available');
                $jobResponse = $this->shifts_service->get_shift_detail($job_id);
                $membersResponse = $this->shifts_service->get_job_members($job_id);

                // $this->shiftUpdate($jobResponse['shift']);
                $flatRate = app('flatRate');
                if ($jobResponse['status'] == 200 && $membersResponse['status'] == 200) {
                    return view('job.members')->with([
                        'users' => $users,
                        'job' => $jobResponse['shift'],
                        'members' => $membersResponse['members'],
                    ]);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function jobMemeberDetail(Request $request, $job_id)
    {
        try {
            $user_id = $request->user;
            // $users = $this->users_service->get_all_users('available');
            // $jobResponse = $this->shifts_service->get_shift_detail($job_id);
            $membersResponse = $this->shifts_service->get_single_job_members($job_id, $user_id);
            // dd($users);

            if ($membersResponse['status'] == 200 && $membersResponse['status'] == 200) {
                return view('job.members_detail')->with([
                    'users' => $membersResponse['user'],
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
| Add Members in Job
|===========================================================
*/
    public function addMembers(Request $request, $job_id)
    {
        try {
            $request->validate([
                "email" => "required|array",
            ]);

            $emails = $request->email;
            $flat_rates = $request->flat_rate;

            $response = $this->shifts_service->add_job_members($emails, $flat_rates, $job_id);

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
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
|===========================================================
| Add Members in Job
|===========================================================
*/
    public function removeMember(Request $request)
    {
        try {
            $request->validate([
                "job_id" => "required|integer",
                "member_id" => "required|integer",
            ]);

            $job_id = $request->job_id;
            $member_id = $request->member_id;
            $response = $this->shifts_service->remove_job_member($job_id, $member_id);
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
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
|===========================================================
| Delete the specified job -- soft delete
|===========================================================
*/
    public function deleteJob($id)
    {
        try {
            $shift_id = $id;
            $response = $this->shifts_service->soft_delete_job($shift_id);

            if ($response['status'] == 200) {

                return response()->json([
                    'status' => 200,
                    'message' => 'Shift Deleted !',
                ]);
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

    public function updateJobStatusForUser(Request $request, $id = null)
    {




        try {

            if (Route::is('user.accept')) {
                $status = 'approved';
                $shift_id = $id;
                $job_id_for_learning_cenre = ['job_ids' => $shift_id];
                // dd($job_id);
                $this->shifts_service->publish_single_job_user($job_id_for_learning_cenre, Auth::user()->id);
            } else if (Route::is('user.decline')) {
                $status = 'reject';
                $shift_id = $id;
            } else {
                $status = $request->status;
                $shift_id = $request->JobId;
            }
            $response = $this->shifts_service->update_job_status_for_user($status, $shift_id);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status' => 200,
                    'message' => $response['message'],
                ]);

                return $response;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addNote(Request $request)
    {
        try {
            $note = $request->note;
            $shift_id = $request->jobId;
            $response = $this->shifts_service->add_note($note, $shift_id);

            if ($response['status'] == 200) {
                Session::flash('Alert', [
                    'status' => 200,
                    'message' => $response['message'],
                ]);
            } else {
                Session::flash('Alert', [
                    'status' => 100,
                    'message' => $response['message'],
                ]);
            }

            return back();
        } catch (\Throwable $th) {
            Session::flash('Alert', [
                'status' => 500,
                'message' => 'Error adding note: ' . $th->getMessage(),
            ]);
            return back();
        }
    }

    public function shiftUpdate($job)
    {
        $userTimezone = 'America/New_York';
        $shiftTime = $job->scheduled_time ?? false;
        if ($shiftTime) {

            list($startHour, $endHour) = explode("-", $shiftTime);
            $startHour = trim($startHour);
            $endHour = trim($endHour);

            if (preg_match('/\b(am|pm)\b/i', $endHour, $matches)) {
                $period = strtolower($matches[0]);
                if (!preg_match('/\b(am|pm)\b/i', $startHour)) {
                    // $startHour .= " $period";
                }
            } else {
                // Default to "pm" if no period is provided at all
                $startHour .= ' pm';
                // $endHour .= ' pm';
            }

            $endTimeUtc = Carbon::createFromFormat('g a', $endHour, 'UTC');

            $endTimeInUserTimezone = $endTimeUtc->setTimezone($userTimezone)->format("Y-m-d H:i:s a");

            $currentTimeInUserTimezone = Carbon::now()->format("Y-m-d H:i:s a");
            if ($currentTimeInUserTimezone > $endTimeInUserTimezone) {
                $currentDateEpoch = Carbon::now()->startOfDay()->timestamp; // Converts current date to epoch (midnight)

                $jobMembers = JobMember::where('job_id', $job->id)->select('user_id', 'flat_rate')->get();
                foreach ($jobMembers as $jb) {

                    $check = UserPaymentJobHistory::where('job_id', $job->id)
                        ->where('user_id', $jb->user_id)
                        ->where('date', $currentDateEpoch)
                        ->exists();

                    if (!$check) {
                        UserPaymentJobHistory::create([
                            'job_id' => $job->id,
                            'user_id' => $jb->user_id,
                            'date' => $currentDateEpoch,
                            'is_payable' => 1,
                            'is_paid' => 0,
                            'flat_rate' => $jb->flat_rate
                        ]);
                    }
                }
            }
        }
    }

    public function requestCoverage(Request $request)
    {

        $job = JobMember::where('job_id', $request->shift_id)
        ->where('user_id' , Auth::user()->id)
            ->update([
                'status' => $request->type
            ]);
        $data_for_coverage_requst = [
            'job_id' => $request->shift_id,
            'requestor_id' => auth::user()->id,
            'type' => $request->type,
            'status' => 'pending',
        ];
        $post = JobCoverageRequest::create($data_for_coverage_requst);

        $jobAdmin = Job::where('id', $request->shift_id)->value('user_id');

        if ($request->type === 'unable') {
            $notification_data = [
                'user_id' => $jobAdmin,
                'title' => "Shift Update",
                'description' => "The Job " . $request->shift_id . " Needs Coverage the user is Unable",
                'link' => URL::to("/shift/$request->shift_id/members")
            ];

            $this->notification_service->store_notification($notification_data);

            $users = User::where('role_id', 5)->where('status', 1)->get();
            // dd($users);
            foreach ($users as $u) {
                if (!$u->checkAvailibity()) {
                    $notification_data = [
                        'user_id' => $u->id,
                        'title' => "Shift Update",
                        'description' => "The Job " . $request->shift_id . " Needs Coverage the user is Unable",
                        'link' => URL::to("/shift/$request->shift_id/members")
                    ];

                    $this->notification_service->store_notification($notification_data);

                }

            }
            return response()->json([
                'status' => 200,
                'message' => 'You’ve been removed from the shift. Others in your market have been notified.',
            ]);
        } else if ($request->type == 'can_if_needed') {

            $notification_data = [
                'user_id' => $jobAdmin,
                'title' => "Shift Update",
                'description' => "The Job " . $request->shift_id . " Needs Coverage",
                'link' => URL::to("/shift/$request->shift_id/members")
            ];

            $avaialble_user = User::leftJoin('job_members', 'job_members.user_id', '=', 'users.id')
                ->where('users.role_id', 5)
                ->whereNull('job_members.user_id')
                ->pluck('users.id')
                ->toArray();
            $this->notification_service->store_notification_schedule($notification_data, $avaialble_user);
            $this->notification_service->store_notification($notification_data);

            return response()->json([
                'status' => 200,
                'message' => 'Shift coverage request submitted. You are still assigned unless someone else is approved.',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Shift coverage request submitted. You are still assigned unless someone else is approved.',
            ]);
        }
    }

    public function coverageJobs(Request $request)
    {

        try {
            $tab = $request->tab ?? "all";
            $date = $request->date;
            $filter = null;

            if ($tab == 'published') {
                $filter['is_published'] = 1;
            } elseif ($tab == 'unpublished') {
                $filter['is_published'] = 0;
            }
            if (Auth::user()->role_id == 5) {

                $response = $this->shifts_service->get_user_shifts_coverage_market($filter);
                $check_coverage = JobCoverageOffer::where('user_id', auth::user()->id)
                    ->join('job_coverage_requests as jcr', 'jcr.id', '=', 'job_coverage_offers.coverage_request_id')
                    ->pluck('job_id')
                    ->toArray();

                return view('job.user_coverage_offers')->with([
                    'tab' => $tab,
                    'shifts' => $response['shifts'],
                    'check_coverage' => $check_coverage
                ]);
            }
            if ($date != '') {
                $filter['date'] = $date;
            }

            $response = $this->shifts_service->get_user_shifts_coverage($filter);
            $avalable_user = $this->shifts_service->get_available_user();

            if ($response['status'] == 200) {
                return view('job.coverage_index')->with([
                    'tab' => $tab,
                    'jobs' => $response['shifts'],
                    'avalable_user' => $avalable_user
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function coverageJobsAccept($id)
    {
        $user = Auth::user();

        // Check if the coverage request exists
        $coverageRequest = JobCoverageRequest::find($id);

        if (!$coverageRequest) {
            return response()->json([
                'status' => 404,
                'message' => 'Coverage request not found.'
            ]);
        }

        // Check if user has already offered to cover this shift
        $existingOffer = JobCoverageOffer::where('coverage_request_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingOffer) {
            return response()->json([
                'status' => 409,
                'message' => 'You have already offered to cover this shift.'
            ]);
        }

        // Create new coverage offer
        JobCoverageOffer::create([
            'coverage_request_id' => $id,
            'user_id' => $user->id,
            'status' => 'pending', // default until admin approves
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Your offer to cover this shift has been submitted.'
        ]);
    }

    public function RequestorsList($id)
    {
        $response = $this->shifts_service->get_requestors($id);

        if ($response['status'] == 200) {
            return view('job.coverage_request_users')->with([
                'groupedJobs' => $response['shifts'],
            ]);
        }
    }
    public function RequestorsListSubmit(Request $request)
    {
        try {

            $emails = $request->email;
            $flat_rates = $request->flat_rate;

            $response = $this->shifts_service->add_job_members($emails, $flat_rates, $request->job_id);
            $invite_link = URL::to('user/shift/' . $request->job_id . '/detail');

            $notification_data = [
                'user_id' => $emails[0],
                'title' => "Your Request For Coverage is accepted !",
                'description' => "You Have Been Added To a Job. Please review it.",
                'link' => $invite_link
            ];
            $Useremail = User::find($emails[0]);
            $this->notification_service->store_notification($notification_data);
            // dd($response);
            $user = User::whereIn("id", $emails)->first();

            $jobcoveragerequest = JobCoverageRequest::where('id', $request->job_coverage_requests)->update([
                'coverage_user_id' => $user->id
            ]);
            $jobcoverageoffer = JobCoverageOffer::where('coverage_request_id', $request->job_coverage_offer_id)->update([
                'status' => 'approved'
            ]);
            // dd('s');
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
        } catch (\Throwable $th) {
            throw $th;
        }
    }



public function autoCleanupCompletedShifts (NotificationsService $notificationService)
{
    $now = Carbon::now();

    $stats = [
        'jobs_processed'   => 0,
        'users_fixed'      => 0,
        'recaps_notified'  => 0,
    ];

    /* =====================================================
        PART 1️⃣ : AUTO CLEANUP COMPLETED SHIFTS
    ===================================================== */

    $completedJobs = Job::where('shift_end', '<', $now->format('H:i:s'))
        ->where('date', '<=', $now->format('Y-m-d'))
        ->get();

    $stats['jobs_processed'] = $completedJobs->count();

    foreach ($completedJobs as $job) {

        $activeWorkHistories = WorkHistory::where('job_id', $job->id)
            ->where('is_active_shift', 1)
            ->get();

        foreach ($activeWorkHistories as $work) {

            $checkIn  = new \DateTime($work->check_in);
            $checkOut = new \DateTime($job->shift_end);
            $interval = $checkIn->diff($checkOut);

            $work->update([
                'user_working_hour' => $interval->format('%H:%I:%S'),
                'check_out'         => $job->shift_end,
                'is_active_shift'   => 0,
                'is_complete'       => 1,
            ]);

            // 🔔 Shift completed notification
            $notificationService->notify_user([
                'user_id'     => $work->user_id,
                'title'       => 'Shift Completed',
                'description' => 'Your shift has been completed successfully.'
            ]);

            $stats['users_fixed']++;
        }
    }

    /* =====================================================
        PART 2️⃣ : CHECK UNSUBMITTED RECAPS (24h → $5 warning)
    ===================================================== */

    $pendingRecaps = UserRecap::where(function ($q) {
            $q->where('status', null)
              ->orWhereNull('status');
        })
        ->with('job')
        ->get();

    foreach ($pendingRecaps as $recap) {

        if (!$recap->job) {
            continue;
        }

        $shiftEnd = Carbon::parse(
            $recap->job->date . ' ' . $recap->job->shift_end
        );

        $hoursPassed = $shiftEnd->diffInHours($now);

        if ($hoursPassed < 24) {
            continue;
        }

        $penaltyAmount = floor($hoursPassed / 24) * 5;

        // 🚨 Penalty warning notification
        $notificationService->notify_user([
            'user_id' => $recap->user_id,
            'title'   => '⚠️ Recap Pending – Penalty Warning',
            'description' =>
                "Your shift recap is still pending.\n" .
                "Penalty applies at $5 per 24 hours.\n" .
                "Current penalty: \${$penaltyAmount}"
        ]);

        $stats['recaps_notified']++;
    }

    return $stats;
}

}
