<?php
namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    
    /*
    |=========================================================
    | Get listing of all users -- paginated
    |=========================================================
    */
    public function get_all_users($pagination = false, $conditions = [], $columns = [],)
    {
        $users = User::where('role_id', '!=', 1);

        if ($conditions) {
            $users->where($conditions);
        }

        if ($columns) {
            $users->select($columns);
        }

        if ($pagination) {
            return $users->paginate(10);
        }
                                    
        return $users->get();
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
    | Soft delete specific user -- by id,email,slug
    |=========================================================
    */
    public function soft_delete_user($criteria)
    {
        if ($criteria) {
            $is_deleted = User::where('id', $criteria)->delete();
        }
                                    
        return $is_deleted;
    }



    /*
    |=========================================================
    | Hard delete specific user -- by id,email,slug
    |=========================================================
    */
    public function permanently_delete_user($criteria)
    {
        if ($criteria) {
            $is_deleted = User::where('id', $criteria)->forceDelete()();
        }
                                    
        return $is_deleted;
    }


    
}