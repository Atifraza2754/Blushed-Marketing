<?php
namespace App\Traits;

/*
|==================================================================
| Api Responser Trait
|==================================================================
| This trait will be used for any response we sent to clients.
*/
trait ApiResponser
{
	/*
	|===============================================
    | Return a success JSON response.
    |===============================================
	*/
	protected function success($data, string $message = null, int $code = 200)
	{
		return response()->json([
			'status' => 200,
			'message'=> $message,
			'data'   => $data
		], $code);
	}


	/*
	|===============================================
    | Return an error JSON response.
    |===============================================
	*/
	protected function error(string $message = null, int $code, $data = null)
	{
		return response()->json([
			'status'  => 100,
			'message' => $message,
			'data'    => $data
		], $code);
	}

}