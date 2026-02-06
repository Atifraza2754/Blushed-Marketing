<?php
namespace App\Services;

use App\Mail\InviteAdminsEmail;
use App\Mail\InviteUsersEmail;
use App\Models\Invite;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use URL;

class InvitesService extends BaseService
{
    /*
    |=========================================================
    | Get invited (admin/user) info
    |=========================================================
    */
    public function get_invite_info($email)
    {
        if ($email) {
            $invite = Invite::where('email', $email)
                ->with([
                    'inviter',
                    'role'
                ])
                ->first();

            return [
                'status' => 200,
                'invite' => $invite
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Get listing of all admin invites
    |=========================================================
    */
    public function get_admin_invites($filter)
    {
        // get admin invites
        $invites = Invite::where('invited_by', 1)
            ->with([
                'inviter',
                'role'
            ])->groupBy('email')
            ->orderBy('id', 'DESC');

        // apply filters
        if ($filter == 'joined') {
            $invites = $invites->where('has_signup', true);
        }
        if ($filter == 'pending') {
            $invites = $invites->where('has_signup', false);
        }

        $invites = $invites->get();

        return $invites;
    }

    /*
    |=========================================================
    | Invite new admins
    |=========================================================
    */
    public function invite_new_admins($data)
    {
        if ($data) {

            $emails = $data['email'];
            $roles = $data['role_id'];

            // email configurations
            $sender_email = config('mail.from')['address'];
            $app_name = config('app.name');

            for ($i = 0; $i < count($emails); $i++) {

                // check if user is already invited and has already signup
                $already_registered = Invite::where('email', $emails[$i])
                    ->where('has_signup', 1)
                    ->first();

                $invite_link = env('APP_URL') . "invite/$emails[$i]" . "/step-1";
                // dd($invite_link);

                if (!$already_registered) {
                    Invite::create([
                        'invited_by' => Auth::id(),
                        'role_id' => $roles[$i],
                        'email' => $emails[$i],
                        'invite_link' => $invite_link,
                        'has_signup' => 0,
                        'status' => 1,
                    ]);

                    // send email
                    $details = [
                        'title' => 'Join Us',
                        'body' => 'join us as a valuable admin',
                        'link' => $invite_link
                    ];

                    \Mail::to($emails[$i], "Dear Admin")->send(new InviteAdminsEmail($details));
                }
            }

            return [
                'status' => 200,
                'message' => 'Invites are successfully sent to provided admins'
            ];
        }

        return [
            'status' => 100,
            'message' => 'sorry, something went wrong'
        ];

    }

    /*
    |=========================================================
    | Get listing of all admin roles
    |=========================================================
    */
    public function get_admin_roles()
    {
        $roles = Role::where('status', TRUE)->where('is_admin', TRUE)->get();

        return $roles;
    }

    /*
    |=========================================================
    | Get listing of all admin invites
    |=========================================================
    */
    public function get_user_invites($filter)
    {
        // get admin invites
        $invites = Invite::where('role_id', 5)
            ->with([
                'inviter',
                'role'
            ])->groupBy('email')
            ->orderBy('id', 'DESC');
        ;

        // apply filters
        if ($filter == 'joined') {
            $invites = $invites->where('has_signup', true);
        }
        if ($filter == 'pending') {
            $invites = $invites->where('has_signup', false);
        }

        $invites = $invites->get();

        return $invites;
    }

    /*
    |=========================================================
    | Invite new admins
    |=========================================================
    */
    public function invite_new_users($data)
    {
        if ($data) {

            $emails = $data['email'];
            // email configurations
            $sender_email = config('mail.from')['address'];
            $app_name = config('app.name');

            for ($i = 0; $i < count($emails); $i++) {

                // check if user is already invited and has already signup
                $already_registered = Invite::where('email', $emails[$i])
                    ->where('has_signup', 1)
                    ->first();
                $url = "invite/$emails[$i]" . "/step-1";
                $invite_link = URL::to($url);

                // config('app.url')."/invite/$emails[$i]" . "/step-1";
                if (!$already_registered) {
                    Invite::create([
                        'invited_by' => Auth::id(),
                        'role_id' => 5,
                        'email' => $emails[$i],
                        'has_signup' => 0,
                        'invite_link' => $invite_link,
                        'status' => 1,
                    ]);
                    // send email
                    $details = [
                        'title' => 'Join Us',
                        'body' => 'join us as a valuable user',
                        'link' => $invite_link
                    ];

                    \Mail::to($emails[$i], "Dear User")->send(new InviteUsersEmail($details));
                }
            }

            return [
                'status' => 200,
                'message' => 'Invites are successfully sent to provided users'
            ];
        }

        return [
            'status' => 100,
            'message' => 'sorry, something went wrong'
        ];

    }

}
