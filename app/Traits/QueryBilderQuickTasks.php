<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;

/*
|========================================================================
| Fruitful methods for quickly performing CRUD operations --
|========================================================================
*/
trait QueryBilderQuickTasks
{
	/*
    |================================================================
    | Get Listing of all records in laravel --
    |================================================================
    */
    public static function getAll($table_name)
    {
        if ($table_name) {
            return DB::table($table_name)->all();
        }
        else{
            return "<Table> Not Found !!!";
        }
       
    }



    /*
    |================================================================
    | Get Specific record in laravel --
    |================================================================
    */
    public static function getSingleRecord($table_name, $id)
    {
        if ($table_name && $id) {
            return DB::table($table_name)->find($id);
        }
        else{
            return "<Table> or <Record> Not Found !!!";
        }
       
    }



    /*
    |================================================================
    | Get Listing of all records in laravel --
    |================================================================
    */
    public static function deleteSingleRecord($table_name, $id)
    {
        if ($table_name && $id) {
            return DB::table($table_name)->find($id)->delete();
        }
        else{
            return "<Table> or <Record> Not Found !!!";
        }
       
    }


}