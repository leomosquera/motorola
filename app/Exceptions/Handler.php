<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }

    public function handleException($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException && $request->isJson()) {
        return $this->errorResponse('The specified method for the request is invalid', 405);
        }

        if ($exception instanceof NotFoundHttpException && $request->isJson()) {
        return $this->errorResponse('The specified URL cannot be found', 404);
        }

        if ($exception instanceof HttpException && $request->isJson()) {
            switch ($exception->getStatusCode()) {
                case 429:
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Muchas conexiones a la vez. Intentar en un minutos.'
                    ], 429);
                    break;
                case 500:
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error en Servidor. Contactar con el admin.'
                    ], 500);
                    break;

                default:
                    return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
                    break;
            }
        }else if($exception instanceof HttpException){
            switch ($exception->getStatusCode()) {
                case 404:
                    return redirect()->route('404');
                    break;
                case 419:
                    return redirect()->route('419');
                    break;
            }
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
