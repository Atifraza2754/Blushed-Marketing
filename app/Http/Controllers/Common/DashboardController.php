<?php

namespace App\Http\Controllers\Common;

use App\Models\Job;
use App\Models\JobMember;
use App\Models\User;
use App\Models\AgentCase;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\UserQuiz;
use App\Models\UserRecap;
use App\Models\UserTraining;
use App\Models\W9Form;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
    |===========================================================
    | Get content for admin panel dashboard
    |===========================================================
    */
    public function index()
    {
        try {

            // if login account role is user
            if (Auth::user()->role_id == 5) {
                $id = Auth::user()->id;
                $endTime = [];
                $nextShift = [];
                $open_shifts = JobMember::join('jobs_c', 'jobs_c.id', '=', 'job_members.job_id')
                    ->where('job_members.user_id', Auth::user()->id)
                    ->where('jobs_c.is_published', 1)
                    ->select('jobs_c.scheduled_time')
                    ->whereNull('jobs_c.deleted_at')
                    ->take(5)
                    ->select('jobs_c.account', 'jobs_c.date', 'job_members.status')
                    ->get();

                $userRecaps = UserRecap::join('recaps', 'recaps.id', 'user_recaps.recap_id')
                    ->where('user_recaps.user_id', $id)
                    ->select('title', 'due_date', 'user_recaps.status')
                    ->orderBy('user_recaps.id', 'DESC')
                    ->take(value: 5)
                    ->get();

                $jobs_c =
                    JobMember::join('jobs_c', 'jobs_c.id', '=', 'job_members.job_id')
                        ->where('job_members.user_id', Auth::user()->id)
                        ->whereNotNull('scheduled_time')
                        ->where('is_published', 1)
                        ->select(
                            'jobs_c.id',
                            'jobs_c.date',
                            'jobs_c.brand as name',
                            'jobs_c.scheduled_time as type'
                        )->get()->toArray();
                $upcoming = JobMember::join('jobs_c', 'jobs_c.id', '=', 'job_members.job_id')
                    ->where('job_members.user_id', Auth::user()->id)
                    ->whereNotNull('scheduled_time')
                    ->get(['scheduled_time', 'jobs_c.id', 'job_members.flat_rate'])->toArray();
                $userTimezone = 'America/New_York';
                foreach ($upcoming as $u) {
                    $shiftTime = $u['scheduled_time'];
                    list($startHour, $endHour) = explode("-", $shiftTime);
                    $startHour = (int) trim($startHour);
                    $endHour = trim($endHour);
                    $endHourInNum = (int) substr($endHour, 0, '-2');

                    $diff = $endHourInNum - $startHour;

                    if (preg_match('/\b(am|pm)\b/i', $endHour, $matches)) {
                        $period = strtolower($matches[0]);
                        if (!preg_match('/\b(am|pm)\b/i', $startHour)) {
                            // dd($period);
                            // $startHour .= " $period";
                        }
                    } else {
                        // Default to "pm" if no period is provided at all
                        $startHour .= ' pm';
                        // $endHour .= ' pm';
                    }

                    $endTime[] = [
                        'time' => Carbon::createFromFormat('G a', $endHour, 'UTC')
                            ->setTimezone($userTimezone)
                            ->format('Y-m-d H:i:s'),
                        'id' => $u['id'],
                        'flat_rate' => $u['flat_rate'],
                        'diff' => $diff ?? 0
                    ];

                }
                if (!empty($endTime)) {

                    $nextShift = $this->closestTime($endTime);
                }

                return view('user.dashboard.index')
                    ->with([
                        'userRecaps' => $userRecaps,
                        'open_shifts' => $open_shifts,
                        'jobs_c' => $jobs_c,
                        'nextShift' => $nextShift
                    ]);
            }

            $messages = Message::select('user_id', 'message')
                ->distinct()
                // ->orderBy('id','DESC')
                ->take(2)
                ->with('user:id,name,profile_image')
                ->get();

            $due_on_voting = W9Form::join('users', 'users.id', '=', 'w9forms.user_id')
                ->leftjoin('job_members', 'job_members.user_id', '=', 'users.id')
                ->latest()
                ->take(3)
                ->whereNull('job_members.deleted_at')
                ->select(
                    'users.name',
                    'users.created_at',
                    'job_members.status'
                )
                ->get();

            $userTimezone = 'America/New_York';

            $completedShifts = Job::whereNotNull('scheduled_time')
                ->get()
                ->filter(function ($job) use ($userTimezone) {
                    $shiftTime = $job->scheduled_time;

                    list($startHour, $endHour) = explode("-", $shiftTime);
                    $startHour = trim($startHour);
                    $endHour = trim($endHour);

                    if (preg_match('/\b(am|pm)\b/i', $endHour, $matches)) {
                        $period = strtolower($matches[0]);
                        if (!preg_match('/\b(am|pm)\b/i', $startHour)) {
                            // dd($period);
                            // $startHour .= " $period";
                        }
                    } else {
                        // Default to "pm" if no period is provided at all
                        $startHour .= ' pm';
                        // $endHour .= ' pm';
                    }
                    //

                    try {
                        $endTime = Carbon::createFromFormat('g a', $endHour, 'UTC')
                            ->setTimezone($userTimezone)
                            ->format('Y-m-d H:i:s');
                    } catch (\Exception $e) {
                        \Log::error("Invalid time format for job ID {$job->id}: {$endHour}");
                        return false;
                    }
                    return Carbon::now($userTimezone)->gt(Carbon::parse($endTime));
                })
                ->sortByDesc(function ($job) use ($userTimezone) {
                    // Sort by the end time in the user's timezone
                    list(, $endHour) = explode("-", $job->scheduled_time);
                    $endHour = trim($endHour);
                    $endHour = preg_replace('/\s+/', ' ', $endHour); // Remove any extra spaces

                    try {
                        $endTime = Carbon::createFromFormat('g a', $endHour, 'UTC')
                            ->setTimezone($userTimezone)
                            ->format('Y-m-d H:i:s');
                    } catch (\Exception $e) {
                        // Log error if the format is incorrect
                        \Log::error("Invalid time format for job ID {$job->id}: {$endHour}");
                        return null;
                    }

                    return $endTime;
                })
                ->take(5);
            // dd($messages);

            $jobs_c = Job::whereNotNull('scheduled_time')
                ->where('is_published', 1)
                ->select(
                    'id',
                    'date',
                    'brand as name',
                    'scheduled_time as type'
                )->get()->toArray();
            // dd($jobs_c);
            return view('dashboard.index')->with([
                'messages' => $messages,
                'due_on_voting' => $due_on_voting,
                'job' => $jobs_c,
                'completedShifts' => $completedShifts
                // 'total_cases'  => $total_cases,
                // 'recent_cases' => $recent_cases,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function publishedShifts(Request $request)
    {
        $time = $request->value ?? 1;

        $end = Carbon::now()->format("Y-m-d");
        if ($time == 1) {
            $start = Carbon::now()->subDays(6)->format("Y-m-d");
        }
        if ($time == 2) {
            $start = Carbon::now()->subMonth()->format("Y-m-d");
        }
        if ($time == 3) {
            $start = Carbon::now()->subYear()->format("Y-m-d");
        }
        $start = $start . ' 00:00:00'; // End of start day
        $end = $end . ' 23:59:59';     // Start of end day

        // Fetch jobs_c between the date range
        $countJob = Job::where('is_published', 1)
            ->whereBetween('created_at', [$start, $end]) // Use whereBetween
            ->whereNull('deleted_at') // Optional, in case soft deletes are used
            ->count();

        return response()->json([
            'status' => 200,
            'message' => 'Total job Count',
            'count' => $countJob ?? 0
        ]);
    }
    public function importedShifts(Request $request)
    {
        $time = $request->value ?? 1;

        $end = Carbon::now()->format("Y-m-d");
        if ($time == 1) {
            $start = Carbon::now()->subDays(6)->format("Y-m-d");
        }
        if ($time == 2) {
            $start = Carbon::now()->subMonth()->format("Y-m-d");
        }
        if ($time == 3) {
            $start = Carbon::now()->subYear()->format("Y-m-d");
        }
        $start = $start . ' 00:00:00'; // End of start day
        $end = $end . ' 23:59:59';     // Start of end day

        // Fetch jobs_c between the date range
        $countJob = Job::whereBetween('created_at', [$start, $end]) // Use whereBetween
            ->whereNull('deleted_at') // Optional, in case soft deletes are used
            ->count();

        return response()->json([
            'status' => 200,
            'message' => 'Total job Count',
            'count' => $countJob ?? 0
        ]);
    }
    public function userTraining(Request $request)
    {
        $time = $request->value ?? 1;
        $end = Carbon::now()->format("Y-m-d");
        if ($time == 1) {
            $start = Carbon::now()->subDays(6)->format("Y-m-d");
        }
        if ($time == 2) {
            $start = Carbon::now()->subMonth()->format("Y-m-d");
        }
        if ($time == 3) {
            $start = Carbon::now()->subYear()->format("Y-m-d");
        }
        $start = $start . ' 00:00:00'; // End of start day
        $end = $end . ' 23:59:59';     // Start of end day
        // Fetch jobs_c between the date range
        $countTraining = UserTraining::whereBetween('created_at', [$start, $end]) // Use whereBetween
            ->where('user_id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->where('status', 'pending')
            ->count();

        return response()->json([
            'status' => 200,
            'message' => 'Total training Count',
            'count' => $countTraining ?? 0
        ]);
    }

    public function userRecap(Request $request)
    {
        $time = $request->value ?? 1;
        $end = Carbon::now()->format("Y-m-d");
        if ($time == 1) {
            $start = Carbon::now()->subDays(6)->format("Y-m-d");
        }
        if ($time == 2) {
            $start = Carbon::now()->subMonth()->format("Y-m-d");
        }
        if ($time == 3) {
            $start = Carbon::now()->subYear()->format("Y-m-d");
        }
        $start = $start . ' 00:00:00'; // End of start day
        $end = $end . ' 23:59:59';     // Start of end day
        $countRecap = UserRecap::whereBetween('created_at', [$start, $end]); // Use whereBetween

        if (Auth::user()->role_id == 5) {
            $countRecap->where('user_id', Auth::user()->id);
        }
        $countRecap= $countRecap->whereNull('deleted_at')
            ->whereIn('status', ['pending', null])
            ->get()
            ->count();
// dd($countRecap);
        return response()->json([
            'status' => 200,
            'message' => 'Total training Count',
            'count' => $countRecap ?? 0
        ]);
    }

    public function openShiftUser()
    {
        $time = $request->value ?? 1;
        $end = Carbon::now()->format("Y-m-d");
        if ($time == 1) {
            $start = Carbon::now()->subDays(6)->format("Y-m-d");
        }
        if ($time == 2) {
            $start = Carbon::now()->subMonth()->format("Y-m-d");
        }
        if ($time == 3) {
            $start = Carbon::now()->subYear()->format("Y-m-d");
        }
        $start = $start . ' 00:00:00'; // End of start day
        $end = $end . ' 23:59:59';     // Start of end day

        // dd($start,$end);
        $data = JobMember::join('jobs_c as j', 'j.id', '=', 'job_members.job_id')
            ->join('users as u', 'u.id', '=', 'job_members.user_id')
            ->whereBetween('j.date', [$start, $end]) // Use whereBetween
            // ->where('user_id', Auth::user()->id)
            ->where('j.is_published', 1)
            ->whereNull('j.deleted_at')
            // ->whereIn('job_members.status', ['pending', null])
            ->select(
                'u.name',
                'j.account'
            )
            ->get()
            ->toArray()
        ;

        return response()->json([
            'status' => 200,
            'message' => 'Total Job Count',
            'data' => $data ?? []
        ]);
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
                $currentDateEpoch = Carbon::now()->startOfDay()->timestamp;  // Converts current date to epoch (midnight)

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
    public function closestTime($times)
    {
        $currentTime = Carbon::now();
        $closestTime = null;
        $closestTimeDiff = null;

        foreach ($times as $timeString) {
            $time = Carbon::parse($timeString['time']);

            $diff = $currentTime->diffInMinutes($time, false);
            if ($closestTimeDiff === null || abs($diff) < abs($closestTimeDiff)) {
                $closestTimeDiff = $diff;
                $closestTime = $time;
                $data = [
                    'time' => $closestTime->format('Y-m-d H:i:s'),
                    'id' => $timeString['id'],
                    'flat_rate' => $timeString['flat_rate'],
                    'diff' => $timeString['diff']
                ];
            }
        }

        return $data;
    }


    public function userquiz(Request $request)
    {
        $time = $request->value ?? 1;
        $end = Carbon::now()->format("Y-m-d");
        if ($time == 1) {
            $start = Carbon::now()->subDays(6)->format("Y-m-d");
        }
        if ($time == 2) {
            $start = Carbon::now()->subMonth()->format("Y-m-d");
        }
        if ($time == 3) {
            $start = Carbon::now()->subYear()->format("Y-m-d");
        }
        $start = $start . ' 00:00:00'; // End of start day
        $end = $end . ' 23:59:59';     // Start of end day
        $countRecap = UserQuiz::whereBetween('created_at', [$start, $end]); // Use whereBetween

        if (Auth::user()->role_id == 5) {
            $countRecap->where('user_id', Auth::user()->id);
        }
        $countRecap= $countRecap->whereNull('deleted_at')
            ->whereIn('status', ['pending', null])
            ->get()
            ->count();
// dd($countRecap);
        return response()->json([
            'status' => 200,
            'message' => 'Total training Count',
            'count' => $countRecap ?? 0
        ]);
    }

}
