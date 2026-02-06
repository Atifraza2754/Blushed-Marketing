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
trait Base64FilesHandler
{
	/*
    |================================================================
    | Upload Files in Storage Or Public Directory --
    |================================================================
    */
    public static function uploadBase64File(
        string $base64_file,
        string $disk = "public",
        string $dir_path,
        bool $image_resize = false
    ){
        if ($base64_file) {

            // IF FILE IS BASE-64 URI
            if (gettype($base64_file) == "string") {
                
                $file_size = self::getBase64FileSize($base64_file);
                $file_extension = self::getBase64FileExtention($base64_file);

                $file_name = time() . '_'. rand(11111,99999) . $file_extension;
                $file_path = public_path($dir_path) . $file_name;
    
                $image = Image::make($base64_file);

                // SET STREAM TYPE
                if ($file_extension = '.png') {
                    $stream = 'png';
                }
                else{
                    $stream = 'jpg';
                }

                // STORE IMAGE IN STORAGE
                $toimg = (string) $image->stream($stream);
                Storage::disk($disk)->put($dir_path . "lg/" . $file_name, $toimg);
                $file_path = 'storage/'.$dir_path;
                
                // RESIZE IMAGES
                if ($image_resize) {

                    // SAVE MEDIUM IMAGE -- (md folder)
                    $image->resize(500 , 500 ,function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $toimg = (string) $image->stream($stream);
                    Storage::disk($disk)->put($dir_path . "md/" . $file_name, $toimg);

                    // SAVE SMALL IMAGE -- (sm folder)
                    $image->resize(150 , 150 ,function ($constraint) {
                        // $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $toimg = (string) $image->stream($stream);
                    Storage::disk($disk)->put($dir_path . "sm/" . $file_name, $toimg);
                }
                
                return $file = [
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_path' => $file_path,
                ];


            }

            return "<File> type is not Base64 !!!";

        }
     
        return "<File> Not Found !!!";
        
       
    }




    /*
    |================================================================
    | Get Base64 File Size In KB,MB,GB,TB --
    |================================================================
    */
    public static function getBase64FileSize($base64_file, $precision = 2)
    {   
        if ($base64_file) {

            if (gettype($base64_file) == "string") {

                $size_in_bytes = (int) (strlen(rtrim($base64_file, '=')) * 3 / 4);

                if ( $size_in_bytes > 0 ) {

                    $size = (int) $size_in_bytes;
                    $base = log($size) / log(1024);
                    $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
                    $size = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

                    return $size;
                }

                return $size_in_bytes;
            }
            
            return "<File> Type is not Base64 !!!";
            
        }
  
        return "<File> Not Found !!!";
        
    }



    /*
    |================================================================
    | Get Base64 File Extention --
    |================================================================
    */
    public static function getBase64FileExtention($base64_file)
    {   
        if ($base64_file) {

            if (gettype($base64_file) == "string") {

                $extension = "." . explode('/', mime_content_type($base64_file))[1];

                return $extension;
            }
            
            return "<File> Type is not Base64 !!!";
            
        }
  
        return "<File> Not Found !!!";
        
    }

}