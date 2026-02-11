<?php

namespace App\Services;

use App\Mail\SendJobNotificationEmail;
use App\Mail\UserNotify;
use App\Models\Training;
use App\Models\User;
use App\Models\UserTraining;
use Auth;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\Quiz;
use App\Models\Brand;
use App\Models\JobCoverageOffer;
use App\Models\JobCoverageRequest;
use App\Models\Recap;
use App\Models\UserQuiz;
use App\Models\JobMember;
use App\Models\UserRecap;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\QuizQuestion;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Models\RecapQuestion;
use App\Models\UserRecapQuestion;
use App\Traits\Base64FilesHandler;
use App\Models\RecapQuestionOption;
use Illuminate\Support\Facades\DB;
use URL;
use App\Models\WorkHistory;


class ShiftsService extends BaseService
{
    protected $notification_service;

    use FilesHandler;
    use Base64FilesHandler;

    /*
    |=========================================================
    | Get listing of all shifts
    |=========================================================
    */
    public function __construct(NotificationsService $ns)
    {

        $this->notification_service = $ns;
    }

    public function get_all_shifts($filter = null)
    {
        $shifts = Job::with('admin')
            ->orderBy('id', 'DESC');
        // dd($shifts);

        // apply filter
        if ($filter) {
            $shifts = $shifts->where($filter);
        }

        $shifts = $shifts->paginate(12);

        return [
            'status' => 200,
            'shifts' => $shifts
        ];
    }



    /*
    |=========================================================
    | Get shift details - by id
    |=========================================================
    */
    public function get_shift_detail($id)
    {
        if ($id) {
            $shift = Job::with('admin')
                ->where('id', $id)
                ->orderBy('id', 'DESC')
                ->first();

            // dd($shift);

            return [
                'status' => 200,
                'shift' => $shift
            ];
        }

        return [
            'status' => 100,
            'shift' => "sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Get listing of all active recaps
    |=========================================================
    */
    public function get_active_recaps()
    {
        $recaps = Shift::with('brand', 'admin')
            ->withCount('questions')
            ->where('status', TRUE)
            ->get();
        // dd($recaps);

        if ($recaps) {
            return [
                'status' => 200,
                'recaps' => $recaps
            ];
        }

        return [
            'status' => 100,
            'message' => "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Store new recap in storage
    |=========================================================
    */
    public function add_new_recap($data)
    {
        if ($data) {

            $formData = [
                'user_id' => Auth::id(),
                'brand_id' => $data['brand_id'],
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'no_of_questions' => $data['no_of_questions'],
                'status' => $data['status'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if ($data['image']) {
                $image_file = $data['image'];
                $base64_file = $this->file64($image_file);

                // SAVE BASE64 IMAGE IN STORAGE
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/recaps/", true);

                $formData['image'] = $saved_image->file_name;
            }

            $recap_id = Shift::insertGetId($formData);

            // add recap questions
            $questions = $data['questions'];
            if ($recap_id) {
                $this->add_recap_questions($questions, $recap_id);
            }

            return [
                'status' => 200,
                'message' => 'New recap is added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Store new recap-questions in storage
    |=========================================================
    */
    public function add_recap_questions($questions, $recap_id)
    {
        if ($questions) {

            foreach ($questions as $question) {
                $formData = [
                    'recap_id' => $recap_id,
                    'title' => $question['title'],
                    'slug' => Str::slug($question['title']),
                    'description' => $question['description'],
                    'answer' => $question['answer'],
                    'status' => $question['status'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                if ($question['image']) {
                    $image_file = $question['image'];
                    $base64_file = $this->file64($image_file);

                    // SAVE BASE64 IMAGE IN STORAGE
                    $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/questions/", true);

                    $formData['image'] = $saved_image->file_name;
                }

                $question_id = recapQuestion::insertGetId($formData);

                // add question options
                $options = $questions['options'];
                if ($question_id) {
                    $this->add_recap_question_options($options, $question_id);
                }
            }


            return [
                'status' => 200,
                'message' => 'New question is added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Store new recap question options in storage
    |=========================================================
    */
    public function add_recap_question_options($options, $question_id)
    {
        if ($options) {

            foreach ($options as $option) {

                $formData = [
                    'recap_question_id' => $question_id,
                    'option' => $option['option'],
                    'type' => $option['type'],
                    'status' => $option['status'],
                ];

                if ($option['image']) {
                    $image_file = $option['image'];
                    $base64_file = $this->file64($image_file);

                    // SAVE BASE64 IMAGE IN STORAGE
                    $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/options/", true);

                    $formData['image'] = $saved_image->file_name;
                }

                recapQuestionOption::create($formData);
            }

            return [
                'status' => 200,
                'message' => 'New question option is added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Get job members
    |=========================================================
    */
    public function get_job_members($job_id)
    {
        if ($job_id) {
            $members = JobMember::where('job_id', $job_id)->with('user', 'userPayment')->orderBy('id', 'DESC')->get();
            if ($members) {
                return [
                    'status' => 200,
                    'members' => $members
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
    | Add new job-members in storage
    |=========================================================
    */
    public function add_job_members($emails, $flat_rates, $job_id)
    {
        if ($emails && $flat_rates && $job_id) {
            for ($i = 0; $i < count($emails); $i++) {

                // check if member is already added
                $is_already_added = JobMember::where([
                    'job_id' => $job_id,
                    'user_id' => $emails[$i]
                ])->first();

                $invite_link = URL::to('user/shift/' . $job_id . '/detail');

                if (!$is_already_added) {
                    User::where('id', $emails[$i])->update([
                        'flat_rate' => $flat_rates
                    ]);

                    $data = User::where('id', $emails[$i])->first();
                    $dataformail = [
                        'link' => $invite_link,
                        'name' => $data->name,
                        'brand_name' => $data->brand_name,
                        'message' => 'Dear <b>' . $data['name'] . '</b>, your Request of coverage for <i><b>' . $data['brand_name'] . '</b></i> is Accepteed. Review it as soon as possible. <br>
                <a href="' . $invite_link . '" style="">Click here </a> to Submit',
                    ];
                    // \Mail::to($data['email'], "Dear User")->send(new UserNotify($dataformail));
                }

                $notification_data = [
                    'user_id' => $emails[$i],
                    'title' => "Added To The Job",
                    'description' => "You Have Been Added To a Job. Please review it.",
                    'link' => $invite_link
                ];

                // send email
                $details = [
                    'body' => 'join us as a valuable admin',
                    'user_id' => $emails[$i],
                    'title' => "Added To The Job",
                    'description' => "You Have Been Added To a Job. Please review it.",
                    'link' => $invite_link
                ];
                $Useremail = User::find($emails[$i]);
                $this->notification_service->store_notification($notification_data);

                JobMember::create([
                    'job_id' => $job_id,
                    'user_id' => $emails[$i],
                    'flat_rate' => $flat_rates[$i],
                ]);
            }

            return [
                'status' => 200,
                'message' => 'Job members are added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Remove job-members from storage
    |=========================================================
    */
    public function remove_job_member($job_id, $member_id)
    {
        if ($job_id && $member_id) {

            JobMember::where('job_id', $job_id)->where('id', $member_id)->delete();

            return [
                'status' => 200,
                'message' => 'Job member is removed successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }




    /*
    |=========================================================
    | Publish multiple jobs
    |=========================================================
    */

    //changes by khadim

    public function publish_multiple_jobs($job_ids)
    {
        if (!$job_ids || !is_array($job_ids)) {
            return [
                'status' => 100,
                'message' => 'Sorry, something went wrong'
            ];
        }

        foreach ($job_ids as $job_id) {

            $job = Job::find($job_id);
            if (!$job) continue;

            // 🔄 Toggle publish status
            $job->is_published = !$job->is_published;
            $job->save();

            // Agar abhi publish hua hai, tabhi assignments aur notifications karein
            if ($job->is_published) {

                $job_members = JobMember::where('job_id', $job_id)->get();
                $brand = Brand::where('title', $job->brand)->first();

                // Quiz & Recap
                $quiz = Quiz::where('brand_id', $brand->id)->first();
                $quiz_questions = QuizQuestion::where('quiz_id', $quiz->id)->get();

                $recap = Recap::where('brand_id', $brand->id)->first();
                $recap_questions = RecapQuestion::where('recap_id', $recap->id)->get();

                $training = Training::where('brand_id', $brand->id)->first();

                foreach ($job_members as $jm) {

                    // Assign Quiz
                    UserQuiz::where('user_id', $jm->user_id)
                        ->where('quiz_id', $quiz->id)
                        ->delete();

                    UserQuiz::updateOrCreate([
                        'quiz_id' => $quiz->id,
                        'user_id' => $jm->user_id,
                    ]);

                    // Assign Recap
                    UserRecap::where('user_id', $jm->user_id)
                        ->where('recap_id', $recap->id)
                        ->delete();

                    $user_recap = UserRecap::create([
                        'recap_id' => $recap->id,
                        'user_id' => $jm->user_id,
                        'shift_id' => $job_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    foreach ($recap_questions as $rc) {
                        UserRecapQuestion::create([
                            'user_recap_id' => $user_recap->id,
                            'recap_question_type' => $rc->question_type,
                            'recap_question' => $rc->title,
                            'recap_question_options' => $rc->options,
                            'recap_question_answer' => null,
                        ]);
                    }

                    // Assign Training
                    UserTraining::where('user_id', $jm->user_id)
                        ->where('training_id', $training->id)
                        ->delete();

                    UserTraining::create([
                        'user_id' => $jm->user_id,
                        'training_id' => $training->id,
                        'due_date' => $training->end_date,
                    ]);

                    // Notification
                    Notification::create([
                        'user_id' => $jm->user_id,
                        'title' => "New Job Published",
                        'description' => "View job details",
                        'link' => '/user/shift/' . $job_id . '/detail'
                    ]);
                }
            }
        }

        return [
            'status' => 200,
            'message' => count($job_ids) > 1
                ? 'Selected Jobs status toggled successfully'
                : 'Job status toggled successfully'
        ];
    }



    /*
    |=========================================================
    | Update specific job details in storage
    |=========================================================
    */
    public function update_job_detail($data, $id)
    {
        if ($data) {
            $scheduled_time = $data['scheduled_time'];
            [$start, $end] = explode('-', $scheduled_time);

            // Convert start and end times to 24-hour format
            $start_time = date("H:i", strtotime($start));
            $end_time = date("H:i", strtotime($end));

            // Return the formatted times
            $shift_start = $start_time;
            $shift_end = $end_time;

            $formData = [
                'account' => $data['account'],
                'brand' => $data['brand'],
                'contact' => $data['contact'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'method_of_communication' => $data['method_of_communication'],
                'address' => $data['address'],
                'date' => $data['date'],
                'timezone' => $data['timezone'],
                'scheduled_time' => $data['scheduled_time'],
                'shift_start' => $shift_start,
                'shift_end' => $shift_end,
                'skus' => $data['skus'],
                'samples_requested' => $data['samples_requested'],
                'reschedule' => $data['reschedule'],
                'added_to_homebase' => $data['added_to_homebase'],
                'confirmed' => $data['confirmed'],
                'attire' => $data['attire'],
                'how_to_serve' => $data['how_to_serve'],
                'supplies_needed' => $data['supplies_needed'],
                // 'is_published' => $data['is_published'],
            ];

            Job::where('id', $id)->update($formData);

            return [
                'status' => 200,
                'message' => 'Job information is updated successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Soft delete specific job -- by id
    |=========================================================
    */
    public function soft_delete_job($id)
    {
        if ($id) {

            $job = Job::where('id', $id)->first();

            if ($job->is_published) {
                return [
                    'status' => 100,
                    'message' => 'Sorry you cannot delete this job as it published'
                ];
            }

            $job->delete();

            return [
                'status' => 200,
                'message' => 'Job is deleted'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Hard delete specific job -- by id
    |=========================================================
    */
    public function permanently_delete_job($id)
    {
        if ($id) {

            $is_deleted = Job::where('id', $id)->forceDelete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Job is deleted permanently'
                ];
            }
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }


    /*
        |=========================================================
        | get job assign to user -- by user_id
        |=========================================================
        */
    public function get_user_shifts($filter = null)
    {
        $shifts = JobMember::join('jobs_c', 'job_members.job_id', '=', 'jobs_c.id')
            ->where('job_members.user_id', Auth::id())
            ->whereNull('jobs_c.deleted_at')
            ->where('jobs_c.is_published', 1)
            ->where('job_members.status', '!=', 'reject')
            ->select(
                'jobs_c.id',
                'jobs_c.is_published',
                'jobs_c.brand',
                'jobs_c.account',
                'jobs_c.contact',
                'jobs_c.date',
                'jobs_c.phone',
                'jobs_c.notes',
                'jobs_c.scheduled_time',
                'job_members.status'
            );

        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                $shifts->where('jobs_c.' . $key, $value);
            }
        }

        return [
            'status' => 200,
            'shifts' => $shifts->paginate(12)
        ];
    }


    public function update_job_status_for_user($status, $jobId)
    {
        $check = JobMember::where('job_id', $jobId)
            ->where('user_id', Auth::user()->id)
            ->first();
        
        if ($check) {
            $check->status = $status;

            $check->save(); // model events + EST respected
            $check = true;
        } else {
            $check = false;
        }
            
            
        $quiz = Job::join('brands', 'brands.title', '=', 'jobs_c.brand')
            ->join('quizzes', 'quizzes.brand_id', '=', 'brands.id')
            ->where('jobs_c.id', $jobId)
            ->get([
                DB::raw('COUNT(CASE WHEN quizzes.id IS NOT NULL THEN 1 ELSE NULL END) AS counts'),
                'quizzes.id',
                'jobs_c.brand',
                'jobs_c.account'
            ])

            ->toArray();
        $data = [];
        $data['link'] = URL::to('user/quiz/' . $quiz[0]['id']);
        $data['count'] = $quiz[0]['counts'] ?? 1;
        $data['brand'] = $quiz[0]['brand'] ?? '';
        $data['account'] = $quiz[0]['account'] ?? '';
        //$data['date'] = date('Y-m-d');
        //$data['time'] = date('H:i a');
        $nowEST = Carbon::now('America/New_York');

        $data['date'] = $nowEST->format('Y-m-d');
        $data['time'] = $nowEST->format('h:i a');
        
        if ($check) {
            return [
                'status' => 200,
                'message' => 'Job Stautus Updated',
                'data' => $data
            ];
        } else {
            return [
                'status' => 100,
                'message' => 'Sorry, something went wrong'
            ];
        }
    }
    public function get_single_job_members($job_id, $user_id = null)
    {
        if ($job_id) {
            $user = JobMember::join('users', 'users.id', '=', 'job_members.user_id')
                ->join('jobs', 'jobs_c.id', '=', 'job_members.job_id')
                ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
                ->where('jobs_c.id', $job_id)
                ->groupBy('job_members.user_id')
                ->orderBy('job_members.user_id', 'DESC')
                ->select(
                    'users.name',
                    'users.email',
                    'users.mobile_no',
                    'users.gender',
                    'users.date_of_birth',
                    'users.address',
                    DB::raw('MAX(job_members.flat_rate) as flat_rate'), // Use MAX or another aggregation function
                    DB::raw('MAX(job_members.status) as status'), // Use MAX or another aggregation function
                    DB::raw('MAX(countries.name) as country'), // Use MAX or another aggregation function

                )->first();

            return [
                'status' => 200,
                'user' => $user
            ];
        }

        return [
            'status' => 100,
            'shift' => "sorry, something went wrong"
        ];
    }

    public function add_note($note, $shift_id)
    {
        $check = Job::where('id', $shift_id)
            ->update([
                'notes' => $note
            ]);
        if ($check) {
            return [
                'status' => 200,
                'message' => 'Job Note Updated'
            ];
        } else {
            return [
                'status' => 100,
                'message' => 'Sorry, something went wrong'
            ];
        }
    }


    public function get_available_user()
    {

        $jobMember = JobMember::whereNull('deleted_at')->pluck('user_id')->toArray();

        return User::where('role_id', 5)
            ->whereNotIn('id', $jobMember)
            ->select('id', 'name', 'email', 'mobile_no', 'profile_image')
            ->get();
    }
    public function get_single_shifts($userId = null)
    {
        $shifts = Job::join('job_members', 'job_members.job_id', 'jobs_c.id')
            ->with('admin')->orderBy('id', 'ASC')
            ->where('job_members.user_id', $userId)
            ->groupBy('jobs_c.id')
            ->select(
                'jobs_c.id as id',
                'jobs_c.is_published',
                'jobs_c.brand',
                'jobs_c.account',
                'jobs_c.contact',
                'jobs_c.date',
                'jobs_c.phone',
                'jobs_c.notes',
                'jobs_c.scheduled_time'
            );

        // dd($shifts);

        // apply filter


        $shifts = $shifts->get();

        return [
            'status' => 200,
            'shifts' => $shifts
        ];
    }


    // public function publish_single_job_user($job_ids, $user_id)
    // {
    //     try {
    //         if ($job_ids) {

    //             $formData = [
    //                 'is_published' => true
    //             ];

    //             // publish jobs
    //             foreach ($job_ids as $key => $job_id) {

    //                 // find members added for this job
    //                 $job_members = JobMember::where('job_id', $job_id)->where('user_id', $user_id)->get();

    //                 $job = Job::where('id', $job_id)->first();
    //                 $brand = Brand::where('title', $job->brand)->first();

    //                 // find quizzes for this job
    //                 $quiz = Quiz::where('brand_id', $brand->id)->first();
    //                 $quiz_question = QuizQuestion::where('quiz_id', $quiz->id)->get();

    //                 // find recaps for this job
    //                 $recap = Recap::where('brand_id', $brand->id)->first();
    //                 $recap_questions = RecapQuestion::where('recap_id', $recap->id)->get();

    //                 $training = Training::where('brand_id', $brand->id)->first();

    //                 foreach ($job_members as $jm) {

    //                     // assign quiz
    //                     UserQuiz::where('user_id', $jm->user_id)->where('quiz_id', $quiz->id)->delete();
    //                     UserQuiz::updateOrCreate([
    //                         'quiz_id' => $quiz->id,
    //                         'user_id' => $jm->user_id,
    //                     ]);

    //                     // assign quiz question

    //                     $e = UserRecap::where('user_id', $jm->user_id)
    //                         ->where('recap_id', $recap->id)
    //                         ->where('shift_id', $job_id)
    //                         ->delete();
    //                     $user_recap_id = UserRecap::create([
    //                         'recap_id' => $recap->id,
    //                         'user_id' => $jm->user_id,
    //                         'shift_id' => $job_id,
    //                         'created_at' => Carbon::now(),
    //                         'updated_at' => Carbon::now(),
    //                     ]);

    //                     // assign recap question
    //                     foreach ($recap_questions as $rc) {
    //                         UserRecapQuestion::create([
    //                             'user_recap_id' => $user_recap_id->id,
    //                             'recap_question_type' => $rc->question_type,
    //                             'recap_question' => $rc->title,
    //                             'recap_question_options' => $rc->options,
    //                             'recap_question_answer' => null,
    //                         ]);
    //                     }

    //                     //user training
    //                     $e = UserTraining::where('user_id', $jm->user_id)
    //                         ->where('training_id', $training->id)
    //                         ->delete();

    //                     UserTraining::create([
    //                         'user_id' => $jm->user_id,
    //                         'training_id' => $training->id,
    //                         'due_date' => $training->end_date,
    //                     ]);

    //                     // store notification for these users
    //                     Notification::create([
    //                         'user_id' => $jm->user_id,
    //                         'title' => "New Job Published",
    //                         'description' => "view job details",
    //                         'link' => '/user/shift/' . $job_id . '/detail'
    //                     ]);
    //                 }
    //             }

    //             // Job::whereIn('id', $job_ids)->update($formData);

    //             if (count($job_ids) > 1) {
    //                 return [
    //                     'status' => 200,
    //                     'message' => 'Selected Jobs are published successfully'
    //                 ];
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 100,
    //             'message' => $e->getMessage()
    //         ];
    //     }
    //     // return [
    //     // 'status' => 100,
    //     // 'message' => 'Sorry, something went wrong'
    //     // ];
    // }

    public function publish_single_job_user($job_ids, $user_id)
{
    try {
        if ($job_ids) {

            $formData = [
                'is_published' => true
            ];

            // publish jobs
            foreach ($job_ids as $key => $job_id) {

                // find member added for this job (ONLY CHANGE HERE)
                $jm = JobMember::where('job_id', $job_id)
                    ->where('user_id', $user_id)
                    ->first();

                if (!$jm) {
                    continue;
                }

                $job = Job::where('id', $job_id)->first();
                $brand = Brand::where('title', $job->brand)->first();

                // find quizzes for this job
                $quiz = Quiz::where('brand_id', $brand->id)->first();
                $quiz_question = QuizQuestion::where('quiz_id', $quiz->id)->get();

                // find recaps for this job
                $recap = Recap::where('brand_id', $brand->id)->first();
                $recap_questions = RecapQuestion::where('recap_id', $recap->id)->get();

                $training = Training::where('brand_id', $brand->id)->first();

                // assign quiz
                UserQuiz::where('user_id', $jm->user_id)
                    ->where('quiz_id', $quiz->id)
                    ->delete();

                UserQuiz::updateOrCreate([
                    'quiz_id' => $quiz->id,
                    'user_id' => $jm->user_id,
                ]);

                // assign recap (EXACT SAME LOGIC)
                UserRecap::where('user_id', $jm->user_id)
                    ->where('recap_id', $recap->id)
                    ->where('shift_id', $job_id)
                    ->delete();

                $user_recap_id = UserRecap::create([
                    'recap_id'   => $recap->id,
                    'user_id'    => $jm->user_id,
                    'shift_id'   => $job_id,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);

                // assign recap questions
                foreach ($recap_questions as $rc) {
                    UserRecapQuestion::create([
                        'user_recap_id' => $user_recap_id->id,
                        'recap_question_type' => $rc->question_type,
                        'recap_question' => $rc->title,
                        'recap_question_options' => $rc->options,
                        'recap_question_answer' => null,
                    ]);
                }

                // user training
                UserTraining::where('user_id', $jm->user_id)
                    ->where('training_id', $training->id)
                    ->delete();

                UserTraining::create([
                    'user_id' => $jm->user_id,
                    'training_id' => $training->id,
                    'due_date' => $training->end_date,
                ]);

                // store notification for user
                Notification::create([
                    'user_id' => $jm->user_id,
                    'title' => "New Job Published",
                    'description' => "view job details",
                    'link' => '/user/shift/' . $job_id . '/detail'
                ]);
            }

            if (count($job_ids) > 1) {
                return [
                    'status' => 200,
                    'message' => 'Selected Jobs are published successfully'
                ];
            }
        }
    } catch (\Exception $e) {
        return [
            'status' => 100,
            'message' => $e->getMessage()
        ];
    }
}


    public function get_user_shifts_coverage($filter = null)
    {

        $shifts = JobCoverageRequest::join('jobs_c', 'job_coverage_requests.job_id', '=', 'jobs_c.id')
            ->join('users', 'users.id', '=', 'job_coverage_requests.requestor_id')
            // ->where('job_coverage_requests.reques' , auth::user()->id)
            ->whereNull('jobs_c.deleted_at')
            ->where('is_published', 1)
            ->where('job_coverage_requests.status', '!=', 'can_if_needed')
            ->groupBy('job_coverage_requests.job_id')
            ->select(
                'job_coverage_requests.id as id',
                'jobs_c.id as job_id',
                'jobs_c.is_published',
                'jobs_c.brand',
                'jobs_c.account',
                'jobs_c.contact',
                'jobs_c.date',
                'jobs_c.phone',
                'jobs_c.notes',
                'jobs_c.scheduled_time',
                'users.id as rejector_id',
                'users.name as assigne',
                'job_coverage_requests.type as status',

            );
        // apply filter
        if ($filter) {
            $shifts = $shifts->where($filter);
        }

        $shifts = $shifts->paginate(12);

        return [
            'status' => 200,
            'shifts' => $shifts
        ];
    }

    public function get_user_shifts_coverage_market()
    {

        $shifts = JobMember::join('jobs_c', 'job_members.job_id', '=', 'jobs_c.id')
            ->join('job_coverage_requests as jr', 'jr.job_id', '=', 'jobs_c.id')
            ->where('jr.requestor_id', '!=', auth::user()->id)
            // ->where('job_members.user_id' , Auth::user()->id)
            ->whereNull('jobs_c.deleted_at')
            ->where('is_published', 1)
            ->whereIn('job_members.status', ['unable', 'can_if_needed'])
            ->groupBy('job_members.job_id')
            ->select(
                'jobs_c.id as id',
                'jobs_c.is_published',
                'jobs_c.brand',
                'jobs_c.account',
                'jobs_c.contact',
                'jobs_c.date',
                'jobs_c.phone',
                'jobs_c.notes',
                'jobs_c.scheduled_time',
                'job_members.status',
                'jr.id as coverage_request_id'
            );
        // apply filter
        // if ($filter) {
        // $shifts = $shifts->where($filter);
        // }
        $shifts = $shifts->paginate(12);

        return [
            'status' => 200,
            'shifts' => $shifts
        ];
    }
    public function get_requestors($id)
    {

        $shifts =
            JobCoverageRequest::leftjoin('job_coverage_offers', 'job_coverage_offers.coverage_request_id', '=', 'job_coverage_requests.id')
            ->leftJoin('users as asignee', 'asignee.id', '=', 'job_coverage_requests.requestor_id')
            ->leftJoin('users as requestor', 'requestor.id', '=', 'job_coverage_offers.user_id')
            ->leftJoin('users as coverage_user_id_name', 'coverage_user_id_name.id', '=', 'job_coverage_requests.coverage_user_id')
            ->leftJoin('jobs_c', 'jobs_c.id', '=', 'job_coverage_requests.job_id')

            ->where('job_coverage_requests.id', $id)

            ->select(
                'requestor_id as assignee_id',
                'asignee.name as job_assignee_id',
                'job_coverage_offers.user_id as requestor_id',
                'requestor.name as requestor_name',
                'requestor.email as requestor_email',
                'job_coverage_requests.job_id',
                'jobs_c.is_published',
                'jobs_c.brand',
                'jobs_c.account',
                'jobs_c.contact',
                'jobs_c.date',
                'jobs_c.phone',
                'jobs_c.notes',
                'jobs_c.address',
                'jobs_c.scheduled_time',
                'job_coverage_offers.created_at as requested_date',
                'job_coverage_requests.id as job_coverage_requests',
                'job_coverage_requests.coverage_user_id',
                'coverage_user_id_name.name as coverage_user_id_name',

            );

        $shifts = $shifts->get()
            ->groupBy(function ($item) {
                return $item->job_id . '_' . $item->job_assignee_id;
            });
        return [
            'status' => 200,
            'shifts' => $shifts
        ];
    }

    public function coverage_request_on_detail($id)
    {

        $shifts = JobMember::join('jobs_c', 'job_members.job_id', '=', 'jobs_c.id')
            ->join('job_coverage_requests as jr', 'jr.job_id', '=', 'jobs_c.id')
            ->where('jobs_c.id', '=', $id)
            // ->where('job_members.user_id' , Auth::user()->id)
            ->whereNull('jobs_c.deleted_at')
            ->where('is_published', 1)
            ->whereIn('job_members.status', ['unable', 'can_if_needed'])
            ->groupBy('job_members.job_id')
            ->select(
                'jobs_c.id as id',
                'jobs_c.is_published',
                'jobs_c.brand',
                'jobs_c.account',
                'jobs_c.contact',
                'jobs_c.date',
                'jobs_c.phone',
                'jobs_c.notes',
                'jobs_c.scheduled_time',
                'job_members.status',
                'jr.id as coverage_request_id'
            );
        // apply filter
        // if ($filter) {
        // $shifts = $shifts->where($filter);
        // }
        $shifts = $shifts->paginate(12);

        return [
            'status' => 200,
            'shifts' => $shifts
        ];
    }



   
}
