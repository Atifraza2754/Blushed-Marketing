<?php
namespace App\Services;

use App\Models\Country;

class AddressService extends BaseService
{
    
    /*
    |=========================================================
    | Get listing of all countries -- paginated
    |=========================================================
    */
    public function get_all_countries($pagination = false, $conditions = [], $columns = [])
    {
        $countries = Country::where('status', true)
                            ->orWhere('status',false);

        
        if ($conditions) {
            $countries->where($conditions);
        }

        if ($columns) {
            $countries->select($columns);
        }

        if ($pagination) {
            return $countries->paginate(10);
        }
                                    
        return $countries->get();
    }
    
}