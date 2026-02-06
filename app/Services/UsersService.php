<?php
namespace App\Services;

use App\Models\JobMember;
use App\Models\User;

class UsersService extends BaseService
{
    /*
    |=========================================================
    | Get listing of all users (team)
    |=========================================================
    */
    public function get_all_users($filter)
    {
        // Base query to fetch users with role_id 5 and eager load the 'role' relationship
        $query = User::where('role_id', 5)->with('role')
        // ->whereNull('deleted_at')
        ;

        $check = JobMember::
            Join('jobs_c', 'jobs_c.id', '=', 'job_members.job_id')
            // ->where('job_members.user_id' , $this->id)
            ->whereNull('jobs_c.deleted_at')
            ->where('jobs_c.date', '>=', date('Y-m-d'))
            ->orderBy('jobs_c.date', 'ASC')
            ->pluck('job_members.user_id')->toArray();

        // Apply filter based on the provided parameter
        switch ($filter) {
            case 'unavailable':
                $query = $query->whereIn('id', $check)->withTrashed();
                break;

            case 'available':
                $query = $query->whereNotIn('id', $check)->withTrashed()
        ->whereNull('deleted_at')
                ;
                break;

            case 'terminated':
                $query = $query->withTrashed()->whereNotNull('deleted_at');
                break;

            case 'all':
            default:
                $query = $query->withTrashed();
                break;
        }

        // Paginate results
        return $query->paginate(10000);
    }




    /*
    |=========================================================
    | Store new user detail in storage
    |=========================================================
    */
    public function store_user($formData)
    {
        if ($formData) {

            $user = User::create($formData);
            return $user;
        }

        return false;
    }


    /*
    |=========================================================
    | Update specific user detail in storage
    |=========================================================
    */
    public function update_user($formData, $id)
    {
        if ($id && $formData) {

            $user = User::where('id', $id)->update($formData);
            return $user;
        }

        return false;
    }


    /*
    |=========================================================
    | Get specific user detail -- by id,email,slug
    |=========================================================
    */
    public function find_user($user_id, $columns = [])
    {
        if ($user_id) {

            if (!is_numeric($user_id)) {
                $user_id = $this->slug_to_id($user_id);
            }
            $user = User::where('id', $user_id)->first();
        }

        if (!$columns) {
            $user->select($columns);
        }

        return $user;
    }



    /*
    |=========================================================
    | Soft delete specific user -- by id
    |=========================================================
    */
    public function soft_delete_user($id)
    {
        if ($id) {

            $is_deleted = User::where('id', $id)->delete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'User is deleted'
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
    | Hard delete specific user -- by id
    |=========================================================
    */
    public function permanently_delete_user($id)
    {
        if ($id) {

            $is_deleted = User::where('id', $id)->forceDelete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Success, User is perminantly deleted'
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
    | Set flat rate for this team member
    |=========================================================
    */
    public function set_flat_rate($data, $id)
    {
        if ($id && $data) {

            $formData['flat_rate'] = $data['flat_rate'];
            $is_updated = User::where('id', $id)->update($formData);

            if ($is_updated) {
                return [
                    'status' => 200,
                    'message' => 'Success, Flat rate is set for this team member'
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
    | Set flat rate for this team member
    |=========================================================
    */
    public function get_shift_details($id)
    {
        if ($id && $data) {

            $formData['flat_rate'] = $data['flat_rate'];
            $is_updated = User::where('id', $id)->update($formData);

            if ($is_updated) {
                return [
                    'status' => 200,
                    'message' => 'Success, Flat rate is set'
                ];
            }
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];

    }

}
