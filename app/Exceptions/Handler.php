<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\PostTooLargeException;

class Handler extends ExceptionHandler
{
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

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
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
    public function render($request, Exception $exception)
    {
        if($request->expectsJson() || $request->ajax() || $request->wantsJson())
        {
            if($exception instanceof NotFoundHttpException)
                return response()->json(['error' => '404 Not Found'], 404);
            

            if($exception instanceof ValidationException)
            {
                return apiFormatResponse(
                    $this->getFirstValidationMessage($exception->errors()),
                    null,
                    null,
                    false,
                    400
                );
            }
            
            if($exception instanceof HttpException)
                return $this->httpExceptionApiResponse($exception);

            if($exception instanceof AuthenticationException)
                return response()->json(['error'=>'Unauthenticated'], 401);

            return response()->json(['error'=>'Something went wrong'], 500); 
        }
        
        // if($exception instanceof PostTooLargeException)
        //     return redirect()->back()->withError('Request post size overflow.');

        return parent::render($request, $exception);
    }

    private function getFirstValidationMessage($errors)
    {
        foreach ($errors as $error) 
            return $error[0];
        return 'Validation failed';
    }

    private function httpExceptionApiResponse(HttpException $e)
    {
        $httpStatus = $e->getStatusCode();
        if($httpStatus == 405)
            return response()->json(['error' => '404 Not Found'], 404);
            
        $msg = $e->getMessage();
        return apiFormatResponse(
            $msg,
            null,
            null,
            false,
            $e->getStatusCode()
        );
        
    }
}
