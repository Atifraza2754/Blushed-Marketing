<?php
namespace App\Services;

use App\Mail\UserNotify;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\UserQuiz;
use Illuminate\Support\Str;
use App\Models\QuizQuestion;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Models\QuizQuestionOption;
use App\Traits\Base64FilesHandler;
use Illuminate\Support\Facades\Auth;
use URL;
use App\Jobs\ProcessNotificationSchedule;



class NotificationsService extends BaseService
{

    /*
    |=========================================================
    | Get listing of all notification for auth user
    |=========================================================
    */
    public function get_user_notifications()
    {
        $notification = Notification::where('user_id', Auth::id())
                                    ->with('admin')
                                    ->orderBy('created_at', 'DESC')
                                    ->get();


        return [
            'status' => 200,
            'quizzes' => $quizzes
        ];
    }



    /*
    |=========================================================
    | Store new notification
    |=========================================================
    */
    public function add_new_notification($data)
    {
        if ($data) {

            $formData = [
                'admin_id' => Auth::id(),
                'user_id'  => $data['user_id'],
                'client'   => $data['client'],
                'feedback' => $data['feedback' ],
                'status'  => true,
            ];

            Quiz::create($formData);

            return [
                'status' => 200,
                'message'=> 'New notification is added successfully',
            ];
        }

        return [
            'status' => 100,
            'message'=> 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Store new notification
    |=========================================================
    */
    public function store_notification($data)
    {
        if ($data) {

            $formData = [
                'user_id'     => $data['user_id'],
                'title'       => $data['title'],
                'description' => $data['description' ],
                'link'        => $data['link' ],
            ];
             Notification::create($formData);

            return [
                'status' => 200,
                'message'=> 'New notification is added successfully',
            ];
        }

        return [
            'status' => 100,
            'message'=> 'Sorry, something went wrong'
        ];
    }

    public function notify_user($data)
    {
        if ($data) {

            $formData = [
                'user_id'     => $data['user_id'],
                'title'       => $data['title'],
                'description' => $data['description' ],
            ];
            $n = Notification::create($formData);

            $notif_id = $n->id;
            Notification::where('id' , $notif_id)->update([
               'link' => URL::to("/user/notifications/$notif_id")
            ]);


            $details = [
                'title' => 'Notification From Blush',
                'message'  => $data['description'],
             ];
             $user = User::where('id' ,$data['user_id'])->first();
            \Mail::to($user->email, "Dear User")->send(new UserNotify($details));
            return [
                'status' => 200,
                'message'=> 'New notification is added successfully',
            ];
        }

        return [
            'status' => 100,
            'message'=> 'Sorry, something went wrong'
        ];
    }

    public function store_notification_schedule($notification_data,$available_users){
        if ($notification_data && !empty($available_users)) {
        // Dispatch the background job
        ProcessNotificationSchedule::dispatch($notification_data, $available_users);

        return [
            'status'  => 200,
            'message' => 'Notification job has been queued successfully',
        ];
    }

    return [
        'status'  => 100,
        'message' => 'Sorry, something went wrong',
    ];
    }

}

