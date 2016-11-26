<?php

namespace PickupApi\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use PickupApi\Http\RestResponse;
use PickupApi\Utils\UrlUtil;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport
        = [
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Auth\Access\AuthorizationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Session\TokenMismatchException::class,
            \Illuminate\Validation\ValidationException::class,
        ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        if ($exception instanceof PickupApiException) {
            return response()->json($exception);
        } elseif ($exception instanceof ValidationException) {
            return response()->json(RestResponse::error(422, ['validation_errors' => $exception->validator->getMessageBag()]));
        } elseif ($exception instanceof ModelNotFoundException) {
            return response()->json(RestResponse::error(404, $exception->getMessage()));
        } elseif ($exception instanceof NotFoundHttpException) {
            return response()->json(RestResponse::exception());
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            $methods = implode(', ',UrlUtil::getAllSupportedMethods());

            return response()->json(RestResponse::exception(405, "人家不支持这个方法啦，要不试试${methods}中的其他方法，喵？"));
        }

        /*return json only*/

//        return response()->json(RestResponse::exception(400, get_class($exception).' : '.$exception->getMessage()));
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
