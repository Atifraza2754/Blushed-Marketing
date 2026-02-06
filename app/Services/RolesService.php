<?php
namespace App\Services;

use App\Models\Role;

class RolesService extends BaseService
{
    
    /*
    |=========================================================
    | Get listing of all roles
    |=========================================================
    */
    public function get_all_roles()
    {
        $roles = Role::all();

        if ($roles) {
            return [
                'status' => 200, 
                'roles'  => $roles
            ];
        }
                                    
        return [
            'status' => 100, 
            'invite' => "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Get listing of all ative roles
    |=========================================================
    */
    public function get_active_roles()
    {
        $roles = Role::where('status', TRUE)->get();

        if ($roles) {
            return [
                'status' => 200, 
                'roles'  => $roles
            ];
        }
                                    
        return [
            'status' => 100, 
            'invite' => "Sorry, something went wrong"
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
                                 
        if ($roles) {
            return [
                'status' => 200, 
                'roles'  => $roles
            ];
        }
                                    
        return [
            'status' => 100, 
            'invite' => "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Get specific role details
    |=========================================================
    */
    public function get_role_detail($id)
    {
        if ($id) {
            $role = Role::where('id', $id)->first();

            if ($role) {
                return [
                    'status' => 200, 
                    'role'   => $role
                ];
            }
        }
                                    
        return [
            'status' => 100, 
            'invite' => "Sorry, something went wrong"
        ];
    }
    
}