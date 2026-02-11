<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobMember;
use App\Models\UserPaymentJobHistory;
use App\Models\WorkHistory;
use App\Services\NotificationsService;
use App\Services\ShiftsService;
use App\Services\UserService;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Session;

class ClockTImeController extends Controller
{
    protected $shifts_service;
    protected $users_service;
    protected $notification_service;

    public function __construct(ShiftsService $ss, UserService $us, NotificationsService $ns)
    {
        $this->shifts_service = $ss;
        $this->users_service = $us;
        $this->notification_service = $ns;
    }

    public function index()
    {

        // dd('tes');

        $endTime = [];
        $nextShift = [];
        $startHour = '';
        $endHour = '';
        $upcoming = JobMember::
            join('jobs_c', 'job_members.job_id', '=', 'jobs_c.id')
            // ->join('work_history as wh' , 'wh.job_id' , '=', 'jobs_c.id')
            ->where('job_members.user_id', Auth::user()->id)
            ->whereNull('jobs_c.deleted_at')
            ->where('is_published', 1)
            ->where('job_members.status', '=', 'approved')
            // ->where('jobs_c.date', '>', date('Y-m-d'))
            ->groupBy('job_members.job_id')->get([
                    'scheduled_time',
                    'jobs_c.id',
                    'job_members.flat_rate',
                    'jobs_c.account',
                    'jobs_c.date',
                    'jobs_c.scheduled_time',
                    'address',
                    'jobs_c.timezone',
                    'jobs_c.contact',
                    'jobs_c.phone',
                    'jobs_c.brand',
                    'jobs_c.email',
                    'jobs_c.method_of_communication',
                    'jobs_c.skus',
                    'jobs_c.shift_start',
                    'jobs_c.shift_end',
                    'job_members.status',
                ])->toArray();
        // dd($upcoming);
        $userTimezone = 'America/New_York';
        $endTime = [];
        foreach ($upcoming as $u) {
            $shiftTime = $u['scheduled_time'];
            $startHour = $u['date'] . ' ' . $u['shift_start'];
            $endHour = $u['date'] . ' ' . $u['shift_end'];
            $diff = $this->calculateTotalHours($u['shift_start'], $u['shift_end']);
            $endTime[] = [
                'time' => $u['shift_end'],
                'id' => $u['id'],
                'flat_rate' => $u['flat_rate'],
                'diff' => $diff ?? 0,
                'account' => $u['account'],
                'scheduled_time' => $u['scheduled_time'],
                'address' => $u['address'],
                'date' => $u['date'],
                'timezone' => $u['timezone'],
                'method_of_communication' => $u['method_of_communication'],
                'email' => $u['email'],
                'phone' => $u['phone'],
                'contact' => $u['contact'],
                'skus' => $u['skus'],
                'brand' => $u['brand'],
                'status' => $u['status'],
                'startHour' => $startHour,
                // 'endHour' => $endHour

            ];

        }
        if (!empty($endTime)) {
            $nextShift = $this->closestTime($endTime);
        }
        $nextShiftid = $nextShift['id'] ?? '';

        $membersResponse = $this->shifts_service->get_job_members($nextShiftid);
        $membersResponse = $membersResponse['members'] ?? [];
        $workHistory = WorkHistory::where('job_id', $nextShiftid)
            ->where('user_id', Auth::user()->id)
            ->first();
        $time_off_list = WorkHistory::where('work_history.user_id', Auth::user()->id)
            ->join('jobs_c', 'jobs_c.id', '=', 'work_history.job_id')
            // ->where('is_complete' , 1)
            ->whereNotNull('work_history.check_in')
            ->whereNotNull('work_history.check_out');
        $totalHour = $time_off_list->pluck('work_history.user_working_hour')->toArray();

        $totalSeconds = array_reduce($totalHour, function ($carry, $time) {
            [$hours, $minutes, $seconds] = explode(':', $time);
            $carry += ($hours * 3600) + ($minutes * 60) + $seconds;
            return $carry;
        }, 0);

        // Convert total seconds back to hours, minutes, and seconds
        $totalHours = floor($totalSeconds / 3600);
        $totalMinutes = floor(($totalSeconds % 3600) / 60);
        $totalSeconds = $totalSeconds % 60;

        $totalTime = sprintf('%02d:%02d', $totalHours, $totalMinutes);

        $time_off_list = $time_off_list->get(['work_history.*']);

        return view('user.clock_time.clock-time')
            ->with([
                'nextShift' => $nextShift,
                'members' => $membersResponse,
                'workHistory' => $workHistory,
                'time_off_list' => $time_off_list,
                'totalTime' => $totalTime,
                'startHour' => $startHour,
                'endHour' => $endHour
            ])
        ;
    }


    public function closestTime($times)
    {
        $currentTime = Carbon::now();
        $closestTime = null;
        $closestTimeDiff = null;

        foreach ($times as $timeString) {
            $time = Carbon::parse($timeString['startHour']);

            $diff = $currentTime->diffInMinutes($time, false);
            if ($closestTimeDiff === null || abs($diff) < abs($closestTimeDiff)) {
                $closestTimeDiff = $diff;
                $closestTime = $time;
                $data = [
                    'time' => $closestTime->format('Y-m-d H:i:s'),
                    'id' => $timeString['id'],
                    'flat_rate' => $timeString['flat_rate'],
                    'diff' => $timeString['diff'],
                    'account' => $timeString['account'],
                    'scheduled_time' => $timeString['scheduled_time'],
                    'address' => $timeString['address'],
                    'date' => $timeString['date'],
                    'timezone' => $timeString['timezone'],
                    'method_of_communication' => $timeString['method_of_communication'],
                    'email' => $timeString['email'],
                    'phone' => $timeString['phone'],
                    'contact' => $timeString['contact'],
                    'skus' => $timeString['skus'],
                    'brand' => $timeString['brand'],
                    'status' => $timeString['status'],
                ];
            }
        }
        return $data;
    }

    public function confirmShift(Request $request, $id)
    {

        // dd( $request->all());
        try {
            $shift_hour = $request->shift_hour;
            $flat_rate = $request->flat_rate;
            $job = Job::where('id', $id)
                ->whereNull('deleted_at')
                ->where('is_published', 1)
                ->first();

            $arr = [
                'job_id' => $job->id,
                'user_id' => Auth::user()->id,
                //'date' => date('Y-m-d H:i:s'),
                'date' => Carbon::now('America/New_York')->format('Y-m-d H:i:s'),
                'shift_hours' => $shift_hour,
                'falt_rate' => $flat_rate,
                'is_confirm' => 1,
                'image' => 0,
                'user_working_hour' => 0,
                'check_in' => null,
                'check_out' => null,
                'lat' => 0,
                'lon' => 0,
                'is_active_shift' => 0,
            ];
            WorkHistory::create($arr);
            return response()->json([
                'status' => 100,
                'message' => 'Job Confirmed !',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }


   

//     public function submit(Request $request)
// {
//     $clock_type = $request->check_type;

//     $work_history = WorkHistory::where('id', $request->work_history_id)
//         ->where('user_id', auth()->id())
//         ->firstOrFail();

//     try {

//         /*============================
//         | CHECK-IN
//         ============================*/
//         if ($clock_type === 'check-in') {

//             // ❌ Agar already active shift hai
//             if (WorkHistory::where('user_id', auth()->id())
//                 ->where('is_active_shift', 1)
//                 ->exists()) {

//                 Session::flash('Alert', [
//                     'status' => 400,
//                     'message' => "You already have an active shift",
//                 ]);
//                 return back();
//             }

//             $arr = [
//                 'is_confirm' => 1,
//                 'image' => $request->image,
//                 'user_working_hour' => 0,
//                 'check_in' => $request->check_time,
//                 'check_out' => null,
//                 'lat' => $request->lat ?? '',
//                 'lon' => $request->lon ?? '',
//                 'is_active_shift' => 1, // 🔴 USER BUSY
//             ];
//         }

//         /*============================
//         | CHECK-OUT
//         ============================*/
//         elseif ($clock_type === 'check-out') {

//             if (!$work_history->is_active_shift) {
//                 Session::flash('Alert', [
//                     'status' => 400,
//                     'message' => "Shift already completed",
//                 ]);
//                 return back();
//             }

//             $checkIn = new DateTime($work_history->check_in);
//             $checkOut = new DateTime($request->check_time);

//             $interval = $checkIn->diff($checkOut);
//             $timePassed = $interval->format('%H:%I:%S');

//             $arr = [
//                 'user_working_hour' => $timePassed,
//                 'check_out' => $request->check_time,
//                 'is_active_shift' => 0, // ✅ USER AVAILABLE AGAIN
//                 'is_complete' => 1,
//             ];

//             UserPaymentJobHistory::create([
//                 'job_id' => $work_history->job_id,
//                 'user_id' => $work_history->user_id,
//                 'date' => $work_history->date,
//                 'is_payable' => 1,
//                 'is_paid' => 0,
//                 'flat_rate' => $work_history->falt_rate,
//                 'work_history_id' => $work_history->id
//             ]);
//         }

//         else {
//             Session::flash('Alert', [
//                 'status' => 400,
//                 'message' => "Invalid check type",
//             ]);
//             return back();
//         }

//         $work_history->update($arr);

//         Session::flash('Alert', [
//             'status' => 200,
//             'message' => ucfirst($clock_type)." marked successfully!",
//         ]);

//         return back();

//     } catch (\Throwable $th) {
//         throw $th;
//     }
// }


//new est time based
public function submit(Request $request)
{
    $clock_type = $request->check_type;

    $work_history = WorkHistory::where('id', $request->work_history_id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    try {

        /*============================
        | CHECK-IN
        ============================*/
        if ($clock_type === 'check-in') {

            // ❌ Agar already active shift hai
            if (WorkHistory::where('user_id', auth()->id())
                ->where('is_active_shift', 1)
                ->exists()) {

                Session::flash('Alert', [
                    'status' => 400,
                    'message' => "You already have an active shift",
                ]);
                return back();
            }

            $arr = [
                'is_confirm' => 1,
                'image' => $request->image,
                'user_working_hour' => 0,
                // Convert provided check_time to EST or use now EST
                'check_in' => $request->check_time 
                                ? Carbon::parse($request->check_time)->setTimezone('America/New_York')->format('Y-m-d H:i:s')
                                : Carbon::now('America/New_York')->format('Y-m-d H:i:s'),
                'check_out' => null,
                'lat' => $request->lat ?? '',
                'lon' => $request->lon ?? '',
                'is_active_shift' => 1, // 🔴 USER BUSY
            ];
        }

        /*============================
        | CHECK-OUT
        ============================*/
        elseif ($clock_type === 'check-out') {

            if (!$work_history->is_active_shift) {
                Session::flash('Alert', [
                    'status' => 400,
                    'message' => "Shift already completed",
                ]);
                return back();
            }

            // EST-based parsing
            $checkIn = Carbon::parse($work_history->check_in)->setTimezone('America/New_York');
            $checkOut = $request->check_time 
                            ? Carbon::parse($request->check_time)->setTimezone('America/New_York')
                            : Carbon::now('America/New_York');

            $timePassed = $checkIn->diff($checkOut)->format('%H:%I:%S');

            $arr = [
                'user_working_hour' => $timePassed,
                'check_out' => $checkOut->format('Y-m-d H:i:s'),
                'is_active_shift' => 0, // ✅ USER AVAILABLE AGAIN
                'is_complete' => 1,
            ];

            UserPaymentJobHistory::create([
                'job_id' => $work_history->job_id,
                'user_id' => $work_history->user_id,
                'date' => Carbon::parse($work_history->date)->setTimezone('America/New_York')->format('Y-m-d H:i:s'),
                'is_payable' => 1,
                'is_paid' => 0,
                'flat_rate' => $work_history->falt_rate,
                'work_history_id' => $work_history->id
            ]);
        }

        else {
            Session::flash('Alert', [
                'status' => 400,
                'message' => "Invalid check type",
            ]);
            return back();
        }

        // Update with EST-aware values
        $work_history->update($arr);

        Session::flash('Alert', [
            'status' => 200,
            'message' => ucfirst($clock_type)." marked successfully!",
        ]);

        return back();

    } catch (\Throwable $th) {
        throw $th;
    }
}

    // function calculateTotalHours($shift_start = null, $shift_end = null)
    // {
    //     // If no values are provided, fetch from the current model instance
    //     if ($shift_start === null || $shift_end === null) {
    //         $shift_start = $this->shift_start ?? "00:00:00"; // Default to midnight if no value
    //         $shift_end = $this->shift_end ?? "00:00:00";
    //     }

    //     // Create Carbon instances
    //     $start_time = Carbon::createFromFormat('H:i:s', $shift_start);
    //     $end_time = Carbon::createFromFormat('H:i:s', $shift_end);

    //     // Calculate total minutes
    //     $totalMinutes = $start_time->diffInMinutes($end_time);

    //     // Convert to hours and minutes
    //     $hours = floor($totalMinutes / 60);
    //     $minutes = $totalMinutes % 60;

    //     // Return in a meaningful format
    //     if ($hours > 0 && $minutes > 0) {
    //         if ($hours > 1 && $minutes > 1) {

    //             return "$hours hrs $minutes mins";
    //         } else {
    //             return "$hours hr $minutes min";
    //         }
    //     } elseif ($hours > 0) {
    //         return "$hours hr";
    //     } else {
    //         return "$minutes mins";
    //     }

    // }
    
    function calculateTotalHours($shift_start = null, $shift_end = null)
{
    // If no values are provided, fetch from the current model instance
    if ($shift_start === null || $shift_end === null) {
        $shift_start = $this->shift_start ?? "00:00:00"; // Default to midnight if no value
        $shift_end = $this->shift_end ?? "00:00:00";
    }

    // Create Carbon instances in EST timezone
    // ✅ Existing logic preserved
    $start_time = Carbon::parse($shift_start)->setTimezone('America/New_York');
    $end_time = Carbon::parse($shift_end)->setTimezone('America/New_York');

    // Calculate total minutes
    $totalMinutes = $start_time->diffInMinutes($end_time);

    // Convert to hours and minutes
    $hours = floor($totalMinutes / 60);
    $minutes = $totalMinutes % 60;

    // Return in a meaningful format (existing logic fully preserved)
    if ($hours > 0 && $minutes > 0) {
        if ($hours > 1 && $minutes > 1) {
            return "$hours hrs $minutes mins";
        } else {
            return "$hours hr $minutes min";
        }
    } elseif ($hours > 0) {
        return "$hours hr";
    } else {
        return "$minutes mins";
    }
}

    
}
