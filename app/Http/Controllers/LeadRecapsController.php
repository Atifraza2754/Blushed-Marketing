<?php

namespace App\Http\Controllers\Common;

use App\Models\JobMember;
use App\Models\UserRecap;
use App\Services\GoogleDriveService;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Services\BrandsService;

use App\Services\RecapsService;
use App\Models\UserRecapQuestion;

use App\Traits\Base64FilesHandler;
use App\Http\Controllers\Controller;
use App\Models\Recap;
use App\Models\RecapQuestion;
use App\Services\NotificationsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LeadRecapsController extends Controller
{
    use FilesHandler;
    use Base64FilesHandler;

    protected $recaps_service;
    protected $brands_service;
    protected $notification_service;
    protected $googleDriveService;

    public function __construct(
        RecapsService $rs,
        BrandsService $bs,
        NotificationsService $ns,
        GoogleDriveService $googleDriveService
    ) {
        $this->recaps_service = $rs;
        $this->brands_service = $bs;
        $this->notification_service = $ns;
        $this->googleDriveService = $googleDriveService;

    }

    /*
           |===========================================================
           | Get listing of all users recaps (assigned to users)
           |===========================================================
           */
    public function index(Request $request, $slug = null)
    {

        try {
            if (Auth::user()->role_id == 5) {

                $userjob = JobMember::where('job_members.user_id', Auth::id())
                    ->join('jobs_c', 'jobs_c.id', 'job_members.job_id')
                    ->join('brands', 'brands.title', 'jobs_c.brand')
                    ->join('recaps', 'recaps.brand_id', 'brands.id')
                    ->where('job_members.status', 'approved')
                    ->where('jobs_c.is_published', 1)
                    ->whereNull('jobs_c.deleted_at')
                    ->distinct('recaps.id')
                    ->pluck('recaps.id')
                    ->toArray()
                ;
                $recaps = UserRecap::
                    with('recap.brand', 'user');
                $recaps = $recaps
                    ->whereIn('recap_id', $userjob)
                ;
                if ($slug) {
                    if ($slug == "due") {
                        $recaps = $recaps->where('status', "pending");
                    } elseif ($slug == "submitted") {
                        $recaps = $recaps->where('status', "submitted");
                    } elseif ($slug == "redos") {
                        $recaps = $recaps->where('status', "rejected")->orWhere('status', "rejected-with-edit");
                    } elseif ($slug == "approved") {
                        $recaps = $recaps->where('status', "approved")->orWhere('status', "approved-with-edit");
                    }
                }
                $recaps = $recaps->where('user_id', Auth::id())->get();
            } else {
                $filter = $request->tab;

                $recaps = UserRecap::
                    with('recap.brand', 'user');

                if ($slug) {
                    if ($slug == "due" || $slug == "pending") {
                        $recaps = $recaps->where('status', "pending")->orWhere('status', null);
                    } elseif ($slug == "submitted") {
                        $recaps = $recaps->where('status', "submitted");
                    } elseif ($slug == "redos") {
                        $recaps = $recaps->where('status', "rejected")->orWhere('status', "rejected-with-edit");
                    } elseif ($slug == "approved") {
                        $recaps = $recaps->where('status', "approved")->orWhere('status', "approved-with-edit");
                    }
                }

                $recaps = $recaps->orderBy('updated_at', 'DESC')->get();
            }
            return view('recaps.index')->with([
                'slug' => $slug,
                'user_recaps' => $recaps,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
           |===========================================================
           | Get listing of all user-recaps
           |===========================================================
           */
    public function userrecaps(Request $request)
    {
        try {
            $filter = $request->tab;
            $recapsResponse = $this->recaps_service->get_user_recaps($filter);
            $brandsResponse = $this->brands_service->get_active_brands();
            // dd($recapsResponse);

            if ($recapsResponse['status'] == 200 && $brandsResponse['status'] == 200) {
                return view('learning-center.recaps.user-recaps')->with([
                    'menu' => "quiz",
                    'recaps' => $recapsResponse['recaps'],
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
           | Show the form for editing the specified recap
           |===========================================================
           */
    public function edit($id)
    {
        try {
            if (Auth::user()->role_id == 5) {
                $recap = UserRecap::where('id', $id)
                    ->where('user_id', Auth::user()->id)
                    ->with([
                        'recap.brand',
                        'recap.questions',
                        'user',

                    ])->first();

                // ->pluck('recap_id')->toArray();
                // $recap_questions = RecapQuestion::whereIn('recap_id', $recap)->get();
                $questions = UserRecapQuestion::where('user_recap_id', $id)->get();

            } else {
                $recap = UserRecap::where('id', $id)
                    // ->where('user_id', Auth::user()->id)
                    ->with([
                        'recap.brand',
                        'recap.questions',
                        'user',

                    ])->first();
                // ->pluck('recap_id')->toArray();
                $questions = UserRecapQuestion::where('user_recap_id', $id)->get();
            }
            // $questions = UserRecapQuestion::where('user_recap_id', $recap->id)->delete();
            // foreach ($recap_questions as $rc) {
            // $data=[
            // 'user_recap_id' => $recap->id,
            // 'recap_question_type' => $rc->question_type,
            // 'recap_question' => $rc->title,
            // 'recap_question_options' => $rc->options,
            // 'recap_question_answer' => null,
            // ];

            // UserRecapQuestion::create($data);

            // }
            // dd($data);
            // $questions = UserRecapQuestion::where('user_recap_id', $recap->id)->delete();
            // dd($recap->id);

            return view('recaps.detail')->with([
                'user_recap' => $recap,
                'questions' => $questions,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    /*
           |===========================================================
           | Reject recap with edit
           |===========================================================
           */
    public function rejectWithEdit(Request $request, $id)
    {
        try {
            $formData = [
                'feedback' => $request->feedback,
                'status' => 'rejected-with-edit'
            ];

            UserRecap::where('id', $id)->update($formData);

            // send notification to user
            $notification_data = [
                'user_id' => $request->user_id,
                'title' => "Recap Rejected W/Edit",
                'description' => "Sorry. Your recap is rejected with edit access. Please review it.",
                'link' => null
            ];

            $this->notification_service->store_notification($notification_data);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    /*
           |===========================================================
           | Approve recap with edit
           |===========================================================
           */
    public function approveWithEdit(Request $request, $id)
    {
        try {
            $formData = [
                'feedback' => $request->feedback,
                'status' => 'approved-with-edit'
            ];

            UserRecap::where('id', $id)->update($formData);

            // send notification to user
            $notification_data = [
                'user_id' => $request->user_id,
                'title' => "Recap Approved W/Edit",
                'description' => "Your recap is approved with edit access. Please review it.",
                'link' => null
            ];

            $this->notification_service->store_notification($notification_data);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
           |===========================================================
           | Approve recap with feedback
           |===========================================================
           */
    public function approveWithFeedback(Request $request, $id)
    {
        try {
            $formData = [
                'feedback' => $request->feedback,
                'status' => 'approved-with-feedback'
            ];

            UserRecap::where('id', $id)->update($formData);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    /*
           |===========================================================
           | Approve recap with rating
           |===========================================================
           */
    public function approveWithRating(Request $request, $id)
    {
        try {

            // ->where('user_id', Auth::user()->id)
            $recap = UserRecap::where('id', $id)
                // ->where('user_id', Auth::user()->id)
                ->with([
                    'recap.brand',
                    'recap.questions',
                    'user',

                ])->first();
            $questions = UserRecapQuestion::where('user_recap_id', $id)->get();

            $this->generatePdfAndUpload($recap, $questions);
            $formData = [
                'rating' => $request->rating,
                'feedback' => $request->feedback,
                'status' => 'approved'
            ];

            UserRecap::where('id', $id)->update($formData);

            // send notification to user
            $notification_data = [
                'user_id' => $request->user_id,
                'title' => "Recap Approved",
                'description' => "Congrats. Your recap is approved",
                'link' => null
            ];

            $this->notification_service->store_notification($notification_data);

            return back();
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
            $response = $this->recaps_service->update_recap($data, $id);
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
           | Store recap answers submitted by user
           |===========================================================
           */
    public function storeRecapAnswers(Request $request, $id)
    {
        try {
            $questions = $request->questions;
            // dd($questions);

            // update user answers for this recap
            foreach ($questions as $question => $answer) {
                // if answer is an array (for checkbox question type)
                if (is_array($answer)) {
                    $answer = implode(",", $answer);
                }

                // If the answer is an image (instance of UploadedFile)
                if ($answer instanceof \Illuminate\Http\UploadedFile) {
                    // Handle the file upload
                    $image_file = $answer;
                    $base64_file = $this->file64($image_file);
                    $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/recaps/", true);
                    $answer = $saved_image->file_name; // Save the image file name
                }

                $formData['recap_question_answer'] = $answer;
                $r = UserRecapQuestion::where([
                    'user_recap_id' => $id,
                    'id' => $question
                ])
                    // ->get();
                    // dd($r);
                    ->update($formData);
            }
            UserRecap::where('id', $id)->update(['status' => 'submitted', 'submit_date' => date('Y-m-d H:i:s')]);

            Session::flash('Alert', [
                'status' => 200,
                'message' => "Recap is submitted successfully",
            ]);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function generatePdfAndUpload($data, $questions)
    {

        // Generate PDF
        // $data = ['title' => 'Laravel PDF Example', 'content' => 'This is a test PDF generated using Laravel.'];
        try {
            $user_recap = [
                'user_recap' => $data,
                'questions' => $questions
            ];
            // dd($user_recap);
            $pdf = Pdf::loadView('recaps.recap_pdf', $user_recap);

            // return $pdf->stream('recap.pdf');
            $username = $data->user ? $data->user->name : '';
            $name = date('Y-m-d') . '-' . $username;

            $name = str_replace(' ', '', $name);

            $pdfPath = storage_path('app/public/' . $name);
            Storage::put('public/' . $name, $pdf->output());

            $fileId = $this->googleDriveService->uploadFile($pdfPath, $name);
            Storage::delete('public/' . $name);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }

        // return response()->json([
        // 'message' => 'PDF uploaded successfully!',
        // 'google_drive_file_id' => $fileId
        // ]);
    }

}
