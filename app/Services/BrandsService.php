<?php
namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Str;
use App\Traits\FilesHandler;
use App\Traits\Base64FilesHandler;
use Illuminate\Http\Request;

class BrandsService extends BaseService
{
    use FilesHandler;
    use Base64FilesHandler;
    
    /*
    |=========================================================
    | Get listing of all brands
    |=========================================================
    */
    public function get_all_brands($filter)
    {
        $brands = Brand::orderBy('id','ASC');
        // dd($brands);

        // apply filters
        if ($filter == 'active') {
            $brands = $brands->where('status', true);
        }
        if ($filter == 'inactive') {
            $brands = $brands->where('status', false);
        }

        $brands = $brands->get();

        return [
            'status' => 200, 
            'brands' => $brands
        ];
    }



    /*
    |=========================================================
    | Get listing of all active brands
    |=========================================================
    */
    public function get_active_brands()
    {
        $brands = Brand::where('status', TRUE)->get();
        // dd($brands);

        if ($brands) {
            return [
                'status' => 200, 
                'brands' => $brands
            ];
        }
                                    
        return [
            'status' => 100, 
            'message'=> "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Store new brand in storage
    |=========================================================
    */
    public function add_new_brand($data)
    {
        if ($data) {

            $formData = [
                'title'      => $data['title'],
                'slug'       => Str::slug($data['title']),
                'description'=> $data['description'] ?? null,
                'status'     => $data['status'],
                'featured'   => $data['featured'] ?? false
            ];

            if (isset($data['image'])) {
                $image_file = $data['image'];
                $base64_file = $this->file64($image_file);
                
                // SAVE BASE64 IMAGE IN STORAGE
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/brands/", true);

                $formData['image'] = $saved_image->file_name;  
            }

            Brand::create($formData);

            return [
                'status' => 200, 
                'message'=> 'New brand is added successfully'
            ];
        }

        return [
            'status' => 100, 
            'message'=> 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Get specific brand details
    |=========================================================
    */
    public function get_brand_detail($id)
    {
        if ($id) {
            $brand = Brand::where('id', $id)->first();
            // dd($brand);

            if ($brand) {
                return [
                    'status' => 200, 
                    'brand'  => $brand
                ];
            }
        }
                                    
        return [
            'status'  => 100, 
            'message' => "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Update brand information in storage
    |=========================================================
    */
    public function update_brand($data, $id)
    {
        if ($data) {

            $formData = [
                'title'      => $data['title'],
                'slug'       => Str::slug($data['title']),
                'description'=> $data['description'] ?? null,
                'is_info_uploaded' => isset($data['is_info_uploaded']) && $data['is_info_uploaded'] == 'on' ? true : false,
                'is_training_uploaded' => isset($data['is_training_uploaded']) && $data['is_training_uploaded'] == 'on' ? true : false,
                'is_quiz_uploaded' => isset($data['is_quiz_uploaded']) && $data['is_quiz_uploaded'] == 'on' ? true : false,
                'is_recap_uploaded' => isset($data['is_recap_uploaded']) && $data['is_recap_uploaded'] == 'on' ? true : false,
                'status'     => $data['status'],
                'featured'   => $data['featured'] ?? false
            ];

            if (isset($data['image'])) {
                $image_file = $data['image'];
                $base64_file = $this->file64($image_file);
                
                // SAVE BASE64 IMAGE IN STORAGE
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/brands/", true);

                $formData['image'] = $saved_image->file_name;  
            }

            Brand::where('id', $id)->update($formData);

            return [
                'status' => 200, 
                'message'=> 'Brand details are updated successfully'
            ];
        }

        return [
            'status' => 100, 
            'message'=> 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Soft delete specific brand -- by id
    |=========================================================
    */
    public function soft_delete_brand($id)
    {
        if ($id) {

            $is_deleted = Brand::where('id', $id)->delete();
            if ($is_deleted) {
                return [
                    'status' => 200, 
                    'message'=> 'Success, Brand is archieved'
                ];
            }
        }
                                    
        return [
            'status' => 100, 
            'message'=> 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Hard delete specific brand -- by id
    |=========================================================
    */
    public function permanently_delete_brand($id)
    {
        if ($id) {

            $is_deleted = Brand::where('id', $id)->forceDelete();
            if ($is_deleted) {
                return [
                    'status' => 200, 
                    'message'=> 'Success, Brand is deleted permanently'
                ];
            }
        }
                                    
        return [
            'status' => 100, 
            'message'=> 'Sorry, something went wrong'
        ];
    }
    
}