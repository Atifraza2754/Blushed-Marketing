<?php
namespace App\Traits;

/*
|========================================================================
| This trait contains file/images paths in storage
|========================================================================
*/
trait FilePathsHandler
{
	/*
    |====================================================
    | All images path
    |====================================================
    */
    public static function allImagesPath()
    {
        return $path = [
            'aed_images_path' => self::aedImagesPath(),
            'user_images_path'=> self::userImagesPath(),
            'cpr_card_images_path' => self::cprCardImagesPath()
        ];
    }


    
    /*
    |====================================================
    | Aed images path
    |====================================================
    */
    public static function aedImagesPath()
    {
        return $path = [
            'sm_image' => "/storage/images/aeds/sm",
            'md_image' => "/storage/images/aeds/md",
            'lg_image' => "/storage/images/aeds/lg",
        ];
    }



    /*
    |====================================================
    | User images path
    |====================================================
    */
    public static function userImagesPath()
    {
        return $path = [
            'sm_image' => "/storage/images/users/sm",
            'md_image' => "/storage/images/users/md",
            'lg_image' => "/storage/images/users/ld",
        ];
    }



    /*
    |====================================================
    | CPR card images path
    |====================================================
    */
    public static function cprCardImagesPath()
    {
        return $path = [
            'sm_image' => "/storage/images/users/cards/sm",
            'md_image' => "/storage/images/users/cards/md",
            'lg_image' => "/storage/images/users/cards/ld",
        ];
    }


}