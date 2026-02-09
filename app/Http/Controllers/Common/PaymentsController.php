<?php

namespace App\Http\Controllers\Common;

use App\Models\WorkHistory;
use Illuminate\Http\Request;
use App\Models\UserRecap;

use App\Models\UserRecapQuestion;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\UserPaymentJobHistory;
use App\Models\Brand;
use App\Services\NotificationsService;
use Illuminate\Support\Carbon;
class PaymentsController extends Controller
{
    /*
    |===========================================================
    | Get listing of all payments
    |===========================================================
    */
    public function index(Request $request, $slug = null)
    {
        try {


            /* ======================================================
        | CASE 1: LOGIN USER (role_id = 5) → SAME AS OLD
        ====================================================== */
            if (Auth::user()->role_id == 5) {

                $payments = UserRecap::where('user_id', Auth::id())
                    ->with(['recap.brand', 'user']);

                // complete / pending filter
                if ($slug) {
                    $status = $slug == 'complete' ? 'complete' : 'pending';
                    $payments->where('status', $status);
                }

                $payments = $payments->get();


                return view('user.payments.index')->with([
                    'slug'          => $slug,
                    'user_payments' => $payments,
                ]);
            }

            /* ======================================================
        | CASE 2: ADMIN / OTHER ROLES → NEW & CORRECT
        ====================================================== */

            $brandId = $request->get('brand_id');

            $payments = WorkHistory::where('is_complete', 1)
                ->with(['job.brand', 'payment', 'user']);

            // Tabs logic
            if ($slug === 'past') {
                // Paid


                $payments->whereHas('payment', function ($q) {
                    $q->where('is_paid', 1);
                });
            }

            if ($slug === 'current') {
                // Unpaid (Pay Now)

                $payments->whereHas('payment', function ($q) {
                    $q->where('is_paid',  0);
                });
            }

            // Brand filter (All / Past / Current)
            if ($brandId) {
                $payments->whereHas('job', function ($q) use ($brandId) {
                    $q->where('brand_id', $brandId);
                });
            }

            $payments = $payments->orderBy('date', 'desc')->get();

            return view('payments.index')->with([
                'slug'     => $slug,
                'payments' => $payments,
                'selected_brand' => $brandId
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function userslist(Request $request, $slug = null)


    {


        try {

            /* ======================================================
        | CASE 1: LOGIN USER (role_id = 5) → OLD LOGIC SAME
        ====================================================== */
            if (Auth::user()->role_id == 5) {


                $payments = UserRecap::where('user_id', Auth::id())
                    ->with(['recap.brand', 'user']);

                if ($slug) {
                    $status = $slug == 'complete' ? 'complete' : 'pending';
                    $payments->where('status', $status);
                }

                $payments = $payments->get();

                return view('user.payments.index')->with([
                    'slug'          => $slug,
                    'user_payments' => $payments,
                ]);
            }

            /* ======================================================
        | CASE 2: ADMIN / OTHER ROLES
        ====================================================== */

            $brandId = $request->get('brand_id');
            $brand   = null;

            if ($brandId) {
                $brand = Brand::find($brandId);
            }

            $payments = WorkHistory::where('is_complete', 1)
                ->with(['job.brand', 'payment', 'user']);

            // Tabs filter
            if ($slug === 'past') {
                $payments->whereHas('payment', function ($q) {
                    $q->where('is_paid', 1);
                });
            }

            if ($slug === 'current') {
                $payments->whereHas('payment', function ($q) {
                    $q->where('is_paid', 0);
                });
            }

            // Brand filter
            if ($brandId) {
                $payments->whereHas('job', function ($q) use ($brandId) {
                    $q->where('brand_id', $brandId);
                });
            }

            $payments = $payments->orderBy('date', 'desc')->get();



            return view('payments.users')->with([
                'slug'           => $slug,
                'payments'       => $payments,
                'selected_brand' => $brandId,
                'brand'          => $brand
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


public function paymentDetail($id)
{
    $data = WorkHistory::with('payment', 'user.userRecaps')->findOrFail($id);

    // Pending recap deduction calculation
    $recap = $data->user->userRecaps
        ->where('status', '=', null)
        ->first(); // agar multiple pending hai, sirf pehla consider

    $recapDeduction = 0;
    $hoursPending = 0;

    if ($recap) {
        $submittedAt = $recap->created_at ?? $data->job?->date ?? now();
        $hoursPending = Carbon::now()->diffInHours(Carbon::parse($submittedAt));
        $recapDeduction = floor($hoursPending / 24) * 5; // $5 per 24 hrs
    }

    return view('payments.paying-approved')->with([
        'data' => $data,
        'recapDeduction' => $recapDeduction,
        'hoursPending' => $hoursPending
    ]);
}




    public function paymentPrefencesUpdate(
        Request $request,
        $id,
        NotificationsService $notificationService
    ) {

        $data = [
            'mileage'              => $request->mileage,
            'sale_incentive'       => $request->salesIncentives,
            'out_of_pocket_expense' => $request->outOfPocket,
            'deduction'            => $request->deductions,
            'note'                 => $request->note,
            'grand_total'          => $request->subtotal,
            'is_allownce_save'     => 1,
            'total_paid'           => $request->subTotal,
            'status'               => 1,
        ];

        $workHistory = WorkHistory::with('user')
            ->findOrFail($id);

        $workHistory->update($data);

        /* =========================================
       🔔 NOTIFICATION + EMAIL TO USER
    ========================================= */

        $notificationService->notify_user([
            'user_id'     => $workHistory->user_id,
            'title'       => 'Payment Approved',
            'description' => 'Congratulations! Your payment has been approved successfully.'
        ]);

        return response()->json([
            'status'  => 200,
            'message' => 'Preferences updated & user notified successfully!',
        ]);
    }

    public function payNow(Request $request, NotificationsService $notificationService)
    {
        $id = $request->userPaymenthistory;

        $paymentHistory = UserPaymentJobHistory::with('user')
            ->findOrFail($id);

        // Update payment status
        $paymentHistory->update([
            'is_paid' => 1,
        ]);

        /* =========================================
       🔔 NOTIFICATION + EMAIL TO USER
    ========================================= */

        $notificationService->notify_user([
            'user_id'     => $paymentHistory->user_id,
            'title'       => 'Payment Paid',
            'description' => 'Your payment has been successfully paid. Thank you!'
        ]);

        return response()->json([
            'status'  => 200,
            'message' => 'Payment marked as paid & user notified successfully!',
        ]);
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
                    'menu'    => "quiz",
                    'recaps' => $recapsResponse['recaps'],
                    'brands'  => $brandsResponse['brands'],
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
    | Show the form for creating new recap
    |===========================================================
    */
    public function create(Request $request)
    {
        try {
            $brand_id = $request->brand_id;
            $brandsResponse = $this->brands_service->get_brand_detail($brand_id);

            // dd($brandsResponse);
            if ($brandsResponse['status'] == 200) {
                return view('learning-center.recaps.create')->with([
                    'menu'  => "recap",
                    'brand' => $brandsResponse['brand']
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /*
    |===========================================================
    | Store newly created recap in storage
    |===========================================================
    */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'brand_id' => 'required|integer',
            'questions.*' => 'required|string|max:255',
        ]);

        try {
            $data = $request->all();
            $response = $this->recaps_service->add_new_recap($data);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status'  => 200,
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
    | Show the form for editing the specified recap
    |===========================================================
    */
    public function edit($id)
    {
        try {
            // if login account role is user
            if (Auth::user()->role_id == 5) {

                $recap = UserRecap::where('id', $id)
                    ->with([
                        'recap.brand',
                        'recap.questions',
                        'user',

                    ])
                    ->first();

                $questions = UserRecapQuestion::where('user_recap_id', $id)->get();

                $answers = [];
                foreach ($questions as $question) {
                    $answers[$question->recap_question_id] = $question->answer;
                }

                // dd($answers);

                return view('user.recaps.detail')->with([
                    'user_recap' => $recap,
                    'answers'    => $answers,
                ]);
            }


            $recapResponse = $this->recaps_service->get_recap_detail($id);
            // dd($recapResponse);

            if ($recapResponse['status'] == 200) {
                return view('learning-center.recaps.edit')->with([
                    'menu' => "recap",
                    'recap' => $recapResponse['recap'],
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
            "brand_id"    => "required|integer",
            "title"       => "required|string|max:200",
            "description" => "nullable|string|max:255",
            "file"        => "nullable|mimes:ppt,pptx,doc,docx,csv,pdf|max:10240",
        ]);

        try {
            $data = $request->all();
            $response = $this->recaps_service->update_training($data, $id);
            // dd($response);

            if ($response['status'] == 200) {

                Session::flash('Alert', [
                    'status'  => 200,
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

            // delete previous answers for this recap
            UserRecapQuestion::where('user_recap_id', $id)->delete();

            // store new answers for this recap
            foreach ($questions as $question => $answer) {

                // if answer is an array
                if (is_array($answer)) {
                    $answer = implode(",", $answer);
                }

                UserRecapQuestion::create([
                    'user_recap_id' => $id,
                    'recap_question_id' => $question,
                    'answer' => $answer,
                ]);
            }

            Session::flash('Alert', [
                'status'  => 200,
                'message' => "Recap is submitted successfully",
            ]);

            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
