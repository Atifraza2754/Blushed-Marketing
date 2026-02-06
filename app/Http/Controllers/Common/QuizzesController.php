<?php

namespace App\Http\Controllers\Common;

use App\Models\Brand;
use App\Models\JobMember;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\UserQuiz;
use App\Models\userQuizReattempt;
use App\Services\NotificationsService;
use Illuminate\Http\Request;
use App\Services\BrandsService;

use App\Services\QuizzesService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use URL;

class QuizzesController extends Controller
{
    protected $quizzes_service;
    protected $brands_service;
    protected $notification_service;

    public function __construct(QuizzesService $qs, BrandsService $bs, NotificationsService $ns)
    {
        $this->quizzes_service = $qs;
        $this->brands_service = $bs;
        $this->notification_service = $ns;
    }


    /*
    |===========================================================
    | Get listing of all quizzes
    |===========================================================
    */
    public function index(Request $request, $slug = null)
    {
        try {
            // if login account role is user
            if (Auth::user()->role_id == 5) {

                $userjob = JobMember::where('job_members.user_id' , Auth::id())
                ->join('jobs_c' ,'jobs_c.id' , 'job_members.job_id' )
                ->join('brands' , 'brands.title','jobs_c.brand' )
                ->join('quizzes' , 'quizzes.brand_id', 'brands.id')
                ->where('job_members.status' , 'approved')
                ->where('jobs_c.is_published' , 1)
                ->whereNull('jobs_c.deleted_at')
                ->distinct('quizzes.id')
                ->pluck('quizzes.id')
                ->toArray()
                ;
                // dd($userjob);
                 $quizzes = UserQuiz::join('quizzes', 'user_quizzes.quiz_id','=','quizzes.id')->
                whereIn('user_quizzes.quiz_id' , $userjob)
                    ->whereNull('user_quizzes.deleted_at')
                    ->whereNull('quizzes.deleted_at')

                    ->where('user_quizzes.user_id', Auth::id())
                    // ->with('quiz', 'user')
                    ->groupBy('user_quizzes.quiz_id')
                    ->orderBy('user_quizzes.id','DESC')
                    // ->select('user_quizzes.id')
                    ;
                    // dd($quizzes->get());

                // if we have filter (complete/incomplete)
                if ($slug) {
                     $slug == "completed" ? "completed" : "resubmit";
                    if ($slug == 'completed'){
                        $status = 'submitted';
                    }else{
                        $status = 'pending';
                    }
                    $quizzes = $quizzes->where('user_quizzes.status', $status);
                }

                $quizzes = $quizzes->get();
                 return view('user.quizzes.index')->with([
                    'slug' => $slug,
                    'user_quizzes' => $quizzes,
                ]);
            }

            $filter = $request->tab;
            $quizzesResponse = $this->quizzes_service->get_all_quizzes($filter);
            $brandsResponse = $this->brands_service->get_active_brands();
            // dd($quizzesResponse);

            if ($quizzesResponse['status'] == 200 && $brandsResponse['status'] == 200) {
                return view('learning-center.quizzes.quizzes')->with([
                    'menu' => "quiz",
                    'quizzes' => $quizzesResponse['quizzes'],
                    'brands' => $brandsResponse['brands'],
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
    | Store user submitted quiz detail in storage
    |===========================================================
    */
    public function submitQuiz(Request $request, $id)
    {
        $user_answers = $request->questions ?? [];
        if (count($user_answers) == 0) {
            return back();

        }
        try {
            $original_answers = $request->answers;

            $quiz = Quiz::where('id', $id)->first();
            // calculate right and wrong answers
            $right_answers = 0;
            $wrong_answers = 0;
            foreach ($original_answers as $question => $answer) {

                if (isset($user_answers[$question])) {
                    $user_answer = $user_answers[$question];
                    if ($user_answer === $answer) {
                        $right_answers++;
                    } else {
                        $wrong_answers++;
                    }
                }
            }
            $percentage = ($right_answers/$quiz->no_of_questions)*100;
            $formData = [
                'quiz_id' => $id,
                'user_id' => Auth::id(),
                'submit_date' => Carbon::now(),
                'shift_date' => Carbon::now(),
                'total_questions' => $quiz->no_of_questions,
                'all_answers' => json_encode($user_answers),
                'attempted_questions' => count($user_answers) ?? 0,
                'right_answers' => $right_answers,
                'wrong_answers' => $wrong_answers,
                'percentage'=>$percentage,
                'feedback' => null,
                'status' => "submitted",
            ];
            // delete previously attempted quiz record
            $r = UserQuiz::where('quiz_id', $id)->where('user_id', Auth::id())->update(
                $formData
            );

            // store newly attempted quiz in storage
            // UserQuiz::create($formData);
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Get listing of all user-quizzes
    |===========================================================
    */
    public function userQuizzes(Request $request)
    {
        try {
            $filter = $request->tab;
            $quizzesResponse = $this->quizzes_service->get_user_quizzes($filter);
            $brandsResponse = $this->brands_service->get_active_brands();
            if ($quizzesResponse['status'] == 200 && $brandsResponse['status'] == 200) {
                return view('learning-center.quizzes.user-quizzes')->with([
                    'menu' => "quiz",
                    'quizzes' => $quizzesResponse['quizzes'],
                    'brands' => $brandsResponse['brands'],
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
    | Show the form for creating new quiz
    |===========================================================
    */
    public function create(Request $request)
    {
        try {
            $brand_id = $request->brand_id;
            $brandsResponse = $this->brands_service->get_brand_detail($brand_id);

            // dd($brandsResponse);
            if ($brandsResponse['status'] == 200) {
                return view('learning-center.quizzes.add-quiz')->with([
                    'menu' => "quiz",
                    'brand' => $brandsResponse['brand']
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Store newly created quiz in storage
    |===========================================================
    */
    public function store(Request $request)
    {
        $request->validate([
            "brand_id" => "required|integer",
            "title" => "nullable|string|max:200",
            "description" => "nullable|string|max:255",
            "file" => "nullable|mimes:ppt,pptx,doc,docx,csv,pdf|max:10240",
        ]);

        try {
            $data = $request->all();
            $response = $this->quizzes_service->add_new_quiz($data);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status' => 200,
                    'message' => $response['message'],
                ]);

                return redirect('/learning-center/quiz/' . $response['quiz_id'] . '/questions');
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
    | Get listing of all questions for this quiz
    |===========================================================
    */
    public function questions($id)
    {
        try {
            $quizResponse = $this->quizzes_service->get_quiz_detail($id);
            $questionsResponse = $this->quizzes_service->get_all_questions($id);

            if ($quizResponse['status'] == 200 && $questionsResponse['status'] == 200) {
                return view('learning-center.quizzes.add-question')->with([
                    'menu' => "quiz",
                    'quiz' => $quizResponse['quiz'],
                    'questions' => $questionsResponse['questions'],
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===========================================================
    | Add/update questions for this quiz
    |===========================================================
    */
    public function addQuestions(Request $request, $id)
    {
        $questions = $request->questions;

         if (is_array($questions) && $questions != null && !empty($questions)) {
            $data = [
                "title" => $request->title,
                "brand_id" => $request->brand_id,
                "status" => $request->status,
                "description" => $request->description,
                "image" => $request->image,
                "no_of_questions" => is_array($request->questions) ? count($request->questions) : 0,
            ];
            $this->quizzes_service->update_quiz($data, $id);

            $this->updateQuestions($questions, $id);

            $quiz = Quiz::where('id', $id)->first();
            $members = UserQuiz::where('quiz_id', $id)->get('user_id')->toArray();
            $brand = $quiz->brand->title ?? '';
            foreach ($members as $m) {
                $str = 'The Quiz of ' . $brand . 'has Updated. Please review it.';
                $notification_data = [
                    'user_id' => $m['user_id'],
                    'title' => "Quiz Update",
                    'description' => $str,
                    'link' => URL::to("/user/quiz/$id")
                ];
                $this->notification_service->store_notification($notification_data);
            }

            Session::flash('Alert', [
                'status' => 200,
                'message' => "Questions information is updated successfully",
            ]);



            return redirect('/learning-center/quiz/' . $id . '/questions');
        }

        try {
            $request->validate([
                "question" => "required|string|max:200",
                "answer" => "nullable|string|max:200",
                "options" => "required|array|min:2",
                "options.*" => "required|string|max:255",
            ]);

            $response = $this->quizzes_service->add_quiz_questions($request->all(), $id);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status' => 200,
                    'message' => $response['message'],
                ]);

                return redirect('/learning-center/quiz/' . $id . '/questions');
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }



    /*
    |===========================================================
    | Show the form for editing the specified quiz
    |===========================================================
    */
    public function edit($id)
    {
        try {
            // if login account role is user
            if (Auth::user()->role_id == 5) {

                $quiz = Quiz::with([
                    'admin',
                    'brand',
                    'questions.options'
                ])
                    ->where('id', $id)
                    ->whereNull('deleted_at')
                    ->first();
                $user_quiz = UserQuiz::where('quiz_id', $id)->whereNull('deleted_at')->orderBy('id','DESC')->first();
                return view('user.quizzes.quiz')->with([
                    'quiz' => $quiz,
                    'user_quiz' => $user_quiz,
                ]);
            }


            $quizResponse = $this->quizzes_service->get_quiz_detail($id);
            // dd($quizResponse);

            if ($quizResponse['status'] == 200) {
                return view('learning-center.quizs.edit')->with([
                    'menu' => "quiz",
                    'quiz' => $quizResponse['quiz'],
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
    | Update the specified quiz detail in storage
    |===========================================================
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            "brand_id" => "required|integer",
            "title" => "required|string|max:200",
            "description" => "nullable|string|max:255",
            "file" => "nullable|mimes:ppt,pptx,doc,docx,csv,pdf|max:10240",
        ]);

        try {
            $data = $request->all();
            $response = $this->quizzes_service->update_training($data, $id);
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
    | Update questions
    |===========================================================
    */
    public function updateQuestions($data, $quiz_id)
    {
        try {

            $response = $this->quizzes_service->update_questions($data, $quiz_id);
            // dd($response);

            if ($response['status'] == 200) {

                return $response;
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
    | Delete the specified quiz from storage
    |===========================================================
    */
    public function destroyQuiz($id)
    {
        try {
            $response = $this->quizzes_service->soft_delete_quiz($id);
            // dd($response);

            if ($response['status'] == 200) {
                return response()->json([
                    'status' => $response['status'],
                    'message' => $response['message']
                ]);
            }

            return response()->json([
                'status' => $response['status'],
                'message' => $response['message']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Delete the specified quiz-question from storage
    |===========================================================
    */
    public function destroyQuestion($id)
    {
        try {
            $response = $this->quizzes_service->soft_delete_question($id);
            // dd($response);

            if ($response['status'] == 200) {
                return response()->json([
                    'status' => $response['status'],
                    'message' => $response['message']
                ]);
            }

            return response()->json([
                'status' => $response['status'],
                'message' => $response['message']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Delete the specified question-option from storage
    |===========================================================
    */
    public function destroyOption($id)
    {
        try {
            $response = $this->quizzes_service->soft_delete_option($id);
            // dd($response);

            if ($response['status'] == 200) {
                return response()->json([
                    'status' => $response['status'],
                    'message' => $response['message']
                ]);
            }

            return response()->json([
                'status' => $response['status'],
                'message' => $response['message']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function destroy($id)
    {
        try {
            $getbrand_id = Quiz::where('id' , $id)->pluck('brand_id')->toArray();
            Brand::where('id' , $getbrand_id[0])->update(['is_quiz_uploaded'=>0]);
            Quiz::where('id', $id)->delete();
            QuizQuestion::where('quiz_id', $id)->delete();
            // dd($is_updated);

            return response()->json([
                'status' => 200,
                'message' => 'Quiz Deleted !',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function reviewQuiz(Request $request)
    {
        $quiz_id = $request->quiz_id;
        $user_id = $request->user_id;
        $quiz = Quiz::with([
            'admin',
            'brand',
            'questions.options'
        ])
            ->where('id', $quiz_id)
            ->whereNull('deleted_at')
            ->first();
        $user_quiz = UserQuiz::where('quiz_id', $quiz_id)->where('user_id', $user_id)->first();
        return view('learning-center.quizzes.quiz-detail')->with([
            'quiz' => $quiz,
            'user_quiz' => $user_quiz,
        ]);
    }

    public function userQuizReattempt(Request $request){

        $old_user_quiz = UserQuiz::where('id', $request->quiz_id)->first();

        if ($old_user_quiz) {
            // Map all fields from UserQuiz but map `id` to `user_quiz_id`
            $update = userQuizReattempt::create([
                'user_quiz_id' => $old_user_quiz->id, // Map id as `user_quiz_id`
                'quiz_id' => $old_user_quiz->quiz_id,
                'user_id' => $old_user_quiz->user_id,
                'submit_date' => $old_user_quiz->submit_date,
                'shift_date' => $old_user_quiz->shift_date,
                'total_questions' => $old_user_quiz->total_questions,
                'all_answers' => $old_user_quiz->all_answers,
                'attempted_questions' => $old_user_quiz->attempted_questions,
                'right_answers' => $old_user_quiz->right_answers,
                'wrong_answers' => $old_user_quiz->wrong_answers,
                'feedback' => $request->description ?? '',
                'status' => $old_user_quiz->status
            ]);
        }
        $old_user_quiz = UserQuiz::where('id', $request->quiz_id)->update([
            'submit_date' => $old_user_quiz->submit_date,
                'shift_date' => $old_user_quiz->shift_date,
                'total_questions' => $old_user_quiz->total_questions,
                'all_answers' => $old_user_quiz->all_answers,
                'attempted_questions' => $old_user_quiz->attempted_questions,
                'right_answers' => $old_user_quiz->right_answers,
                'wrong_answers' => $old_user_quiz->wrong_answers,
                'feedback' => $request->description ?? '',
                'status' => 'pending'

        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Re-attempt created!',
        ]);

    }
    public function approved(Request $request){


        $old_user_quiz = UserQuiz::where('id', $request->quiz_id)->update([
                'feedback' => $request->a_description ?? '',
                'status' => 'approved'

        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Quiz Apprvoed!',
        ]);

    }

}
