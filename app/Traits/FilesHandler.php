<?php
namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

/*
|========================================================================
| This Trait contains some fruitful methods for handling files in php
|========================================================================
*/
trait FilesHandler
{
	/*
    |================================================================
    | Upload Files in Storage Or Public Directory --
    |================================================================
    */
    public static function uploadImageFile(
        $file,
        string $disk = "public",
        string $dir_path,
        bool $rename_file = true,
        bool $image_resize = false
    ){
        if ($file) {

            $file_type = gettype($file);

            // CONVERT BASE64 URI TO FILE
            if ($file_type == "string") {
                $file = self::base64_to_file($file);
            }

            $file_name      = $rename_file ? self::generateFileName($file) : $file->getClientOriginalName();
            $file_extension = self::getFileExtension($file);
            $file_size      = self::getFileSize($file);

            // STORE IMAGES IN PUBLIC FOLDER
            if (!$disk) {
                $file->move(public_path($dir_path), $file_name);
                $file_path = $dir_path . $file_name;

                return $file = [
                    'file_name' => $file_name,
                    'file_type' => $file_extension,
                    'file_path' => $file_path,
                    'file_size' => $file_size
                ];
            }
            
            // STORE IMAGE IN STRORAGE
            Storage::disk($disk)->put($dir_path ."lg/" . $file_name, File::get($file));
            $file_path = 'storage'.$dir_path;
            
            // RESIZE IMAGES
            if ($image_resize) {
                
                $img = Image::make($file->getRealPath());

                // SAVE MEDIUM IMAGE -- (md folder)
                $img->resize(500 , 500 ,function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $toimg = (string) $img->stream('png');
                Storage::disk($disk)->put($dir_path . "md/" . $file_name, $toimg);

                // SAVE SMALL IMAGE -- (sm folder)
                $img->resize(150 , 150 ,function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $toimg = (string) $img->stream('png');
                Storage::disk($disk)->put($dir_path . "sm/" . $file_name, $toimg);
            }

            return $file = [
                'file_name' => $file_name,
                'file_type' => $file_extension,
                'file_path' => $file_path,
                'file_size' => $file_size
            ];

        }
        else{
            return "File Not Found !!!";
        }
       
    }



    /*
    |================================================================
    | Get Images Path -- For small, medium, large Image
    |================================================================
    */
    public static function getImagePaths($dir_path, $file_name)
    {   
        if ($dir_path && $file_name) {
        
            return $image_path = [
                'small_image'    => $dir_path . "sm/" . $file_name,
                'medium_image'   => $dir_path . "md/" . $file_name,
                'origional_image'=> $dir_path . "lg/" . $file_name,
            ];
        }
        else{
            return "File Not Found !!!";

        }
       
    }



    /*
    |================================================================
    | Generate Unique Name For Uploaded File --
    |================================================================
    */
    public static function generateFileName($file)
    {   
        if ($file) {
           
            $fileName = time() . "_" .$file->getClientOriginalName();
            return $fileName;
        
        }
        else{
            return "File Not Found !!!";

        }
       
    }

    

    /*
    |================================================================
    | Get The Original Name of Uploaded File --
    |================================================================
    */
    public static function getFileName($file)
    {   
        if ($file) {
            return $file->getClientOriginalName();
        }
        else{
            return "File Not Found !!!";
        }
    }



    /*
    |================================================================
    | Get The Extension Of Uploaded File --
    |================================================================
    */
    public static function getFileExtension($file)
    {   
        if ($file) {
            return $file->getClientOriginalExtension();;
        }
        else{
            return "File Not Found !!!";
        }
    }



    /*
    |================================================================
    | Get The Size of Uploaded File In KB,MB,GB,TB --
    |================================================================
    */
    public static function getFileSize($file, $precision = 2)
    {   
        if ($file) {
            $size = $file->getSize();
    
            if ( $size > 0 ) {
                $size = (int) $size;
                $base = log($size) / log(1024);
                $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
                return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
            }
    
            return $size;
        }
        else{
            return "File Not Found !!!";
        }
    }




    /*
    |================================================================
    | Convert The Uploaded File (png,jpg,pdf,etc) To Base64 (DATA-URL)
    |================================================================
    */
    public static function file64($file)
    {
        if ($file) {
            $path     = $file->getRealPath();
            $mimeType = $file->getMimeType();
            $data     = file_get_contents($path);

            // MAKE DATA-URL
            $base64 = "data:$mimeType". ';base64,' . base64_encode($data);

            return $base64;
        }
        else{
            return "File Not Found !!!";
        }
    }



    /*
    |======================================================================
    | This Function Converts Base64 (DATA-URI) to File
    |======================================================================
    | 1-Here in this function we are taking a base64 string and convert into a file.
    | 2-This function takes a base64 object and returns us an array consisting of
    | file and file-name;
    */
    public static function base64_to_file($image_64)
    {
        $base64 = $image_64; 
        $new_path = public_path('/images/');
        $width = 100; 
        $height = 100;

        $image = str_replace('data:image/png;base64,', '', $base64);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '_'. rand(11111,99999) . '.png';
        $new_path = $new_path . $imageName;
        $input = File::put($new_path, base64_decode($image));
        $image = Image::make($new_path)->resize($width, $height);
        $result = $image->save($new_path);

        return $result;
    }


}