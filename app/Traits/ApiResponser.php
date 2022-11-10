<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser{

    protected function successResponse($data = [], $message, $code = 200)
	{
		return response([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
	}

	protected function errorResponse($message, $code = 422)
	{
		return response([
            'success' => false,
            'message' => $message,
        ], $code);
	}

}
/* Codes :
200 (OK)
201 (Created)
202 (Accepted)
204 (No Content)
301 (Moved Permanently)
302 (Found)
303 (See Other)
304 (Not Modified)
307 (Temporary Redirect)
400 (Bad Request)
401 (Unauthorized)
403 (Forbidden)
404 (Not Found)
405 (Method Not Allowed)
406 (Not Acceptable)
412 (Precondition Failed)
415 (Unsupported Media Type)
500 (Internal Server Error)
501 (Not Implemented)
*/
