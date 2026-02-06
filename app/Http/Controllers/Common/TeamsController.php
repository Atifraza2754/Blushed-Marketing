<?php

namespace App\Http\Controllers\Common;

use App\Models\JobMember;
use App\Models\UserQuiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\RolesService;
use App\Services\UsersService;
use App\Services\InvitesService;
use App\Http\Controllers\Controller;
use App\Models\LeadUser;
use App\Models\User;
use App\Services\NotificationsService;
use Google\Service\CloudRedis\UserLabels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use URL;

class TeamsController extends Controller
{
    protected $users_service;
    protected $notification_service;

    public function __construct(UsersService $us, NotificationsService $ns)
    {
        $this->users_service = $us;
        $this->notification_service = $ns;
    }


    /*
       |===========================================================
       | Get listing of users (team members)
       |===========================================================
       */
    public function getAllTeamMembers(Request $request)
    {
        try {
            $filter = $request->tab ?? "all";
            $users = $this->users_service->get_all_users($filter);
            // dd($users->get());

            return view('team.index')->with([
                'tab' => $filter,
                'users' => $users,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
       |===========================================================
       | Show details for this team member
       |===========================================================
       */
    public function showMemberDetail($id)
    {
        try {
            $user = $this->users_service->find_user($id);
            $jobList = JobMember::join('jobs_c', 'jobs_c.id', '=', 'job_members.job_id')
                ->where('job_members.user_id', $id)
                ->whereNotNull('scheduled_time')
                ->get(['scheduled_time', 'jobs_c.id', 'job_members.flat_rate', 'jobs_c.account', 'jobs_c.date', 'job_members.status'])->toArray();

            $nextShift = [];
            $endTime = [];
            $userTimezone = 'America/New_York';
            foreach ($jobList as $u) {
                $shiftTime = $u['scheduled_time'];
                list($startHour, $endHour) = explode("-", $shiftTime);
                $startHour = (int) trim($startHour);
                $endHour = trim($endHour);
                $endHourInNum = (int) substr($endHour, 0, '-2');

                $diff = $endHourInNum - $startHour;
                if (preg_match('/\b(am|pm)\b/i', $startHour, $matches)) {
                    $period = strtolower($matches[0]);
                    if (!preg_match('/\b(am|pm)\b/i', $startHour)) {
                    }
                } else {
                    $startHour .= ' pm';
                }
                if (preg_match('/\b(am|pm)\b/i', $endHour, $matches)) {
                    $period = strtolower($matches[0]);
                    if (!preg_match('/\b(am|pm)\b/i', $endHour)) {
                    }
                } else {
                    // $endHour .= ' pm';
                }
                $endTime[] = [
                    'time' => Carbon::createFromFormat('g a', $startHour, 'UTC')
                        ->setTimezone($userTimezone)
                        ->format('Y-m-d H:i:s'),
                    'id' => $u['id'],
                    'flat_rate' => $u['flat_rate'],
                    'diff' => $diff ?? 0,
                    'end_time' => Carbon::createFromFormat('g a', $endHour, 'UTC')
                        ->setTimezone($userTimezone)
                        ->format('Y-m-d H:i:s'),
                    'scheduled_time' => $u['scheduled_time'],
                    'account' => $u['account'],
                ];

            }
            if (!empty($endTime)) {

                $nextShift = $this->closestTime($endTime);
            }
            $quizzes = UserQuiz::where('user_quizzes.user_id', $id)
                ->with('user', 'quiz.brand')
                ->orderBy('id', 'ASC')->first();
            // dd($user);
            return view('team.detail')->with([
                'user' => $user,
                'nextShift' => $nextShift,
                'jobList' => $jobList,
                'endTime' => $endTime
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
       |===========================================================
       | Get shift details for this team member
       |===========================================================
       */
    public function getShiftDetails($id)
    {
        try {
            $response = $this->users_service->get_shift_details($id);

            return view('team.index')->with([
                'users' => $users,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
       |===========================================================
       | Set flat rate for this team member
       |===========================================================
       */
    public function setFlatRate(Request $request)
    {
        try {
            $data = $request->all();
            $response = $this->users_service->set_flat_rate($data, $request->user_id);
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
       | Save notification for this team member
       |===========================================================
       */
    public function notifyTeamMember(Request $request)
    {
        try {
            $data = $request->all();
            $arr = [
                'user_id' => $data['user_id'],
                'client' => $data['user_id'],
                'description' => $data['feedback'],
                'link' => '',
                'title' => 'Notification From Admin'
            ];
            $response = $this->notification_service->notify_user($arr);

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
       | Terminate this team member -- soft delete
       |===========================================================
       */
    public function terminateTeamMember(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $response = $this->users_service->soft_delete_user($user_id);
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

    public function closestTime($times)
    {
        $currentTime = Carbon::now();
        $closestTime = null;
        $closestTimeDiff = null;

        foreach ($times as $timeString) {
            $time = Carbon::parse($timeString['time']);
            $end_time = Carbon::parse($timeString['end_time']);
            $diff = $currentTime->diffInMinutes($time, false);
            if ($closestTimeDiff === null || abs($diff) < abs($closestTimeDiff)) {
                $closestTimeDiff = $diff;
                $closestTime = $time;
                $data = [
                    'time' => $closestTime->format('Y-m-d H:i:s'),
                    'end_time' => $end_time->format('Y-m-d H:i:s'),
                    'id' => $timeString['id'],
                    'flat_rate' => $timeString['flat_rate'],
                    'diff' => $timeString['diff'],
                    'scheduled_time' => $timeString['scheduled_time'],
                    'account' => $timeString['account'],
                ];
            }
        }

        return $data;
    }


    public function Onboarding($id)
    {
        try {

            $user = $this->users_service->find_user($id);

            return view('team.onboarding')->with([
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function OnboardingChangeStatus(Request $request)
    {
        try {
            $status = $request->status ?? 0;

            if ($request->form_type == 'ic') {
                User::where('id', $request->id)->update(['is_ic' => $status]);
            } elseif ($request->form_type == 'w9') {
                User::where('id', $request->id)->update(['is_w9' => $status]);
            } elseif ($request->form_type == 'pr') {
                User::where('id', $request->id)->update(['is_pr' => $status]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Form Type Updated!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function MakeTeamLead($id)
    {
        try {

            $user = $this->users_service->find_user($id);
            $userListing = User::join('lead_users', 'lead_users.user_id', '!=', 'users.id')
                ->select('users.name', 'users.id')
                ->groupBy('users.id')
                ->get()
                ->toArray()
            ;
            return view('team.make_Lead')->with([
                'user' => $user,
                'userListing' => $userListing
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getLeadUser(Request $request)
    {
        $data = array();

        if ($request->ajax) {
            $id = $request->id;
            $merchant = [];
            $data['id'] = $id;
            $data['lead_users'] = LeadUser::where('lead_user_id', $id)
                ->pluck('user_id')
                ->toArray();


            $selectMer = User::query();
            // join('lead_users','lead_users.user_id' , '!=', 'users.id');

            $data['all_users'] = $selectMer->select(DB::raw('CONCAT(name, "(" ,users.id, ")") as label'), 'users.id as id')
                // ->limit(1000)
                ->get()->toArray();
            ;

            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }

    }
    public function updateLeadUser(Request $request)
    {
        $data = $request->all();

        LeadUser::where('lead_user_id', $data['user_id'])->delete();

        if (count($data['get_lead_user_id']) > 0) {
            $leaduser = new LeadUser();
            foreach ($data['get_lead_user_id'] as $value) {
                $leaduser->create([
                    'lead_user_id' => $data['user_id'],
                    'user_id' => $value
                ]);

            }
        }

        Session::flash('Alert', [
            'status' => 200,
            'message' => 'Updated !',
        ]);

        return back();
    }

}
