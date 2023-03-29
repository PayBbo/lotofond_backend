<?php

namespace App\Exceptions;

use App\Exceptions\CustomExceptions\BaseException;
Use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use UnexpectedValueException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->renderable(function (Throwable $e, $request) {
            return $this->customHandleException($request, $e);
        });

    }

    public function customHandleException($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            $response = [];
            if ($request->wantsJson() && ($e instanceof BaseException)) {
                $response = [
                    'code' => $e->getCode(),
                    'title' => $e->getTitle(),
                    'detail' => $e->getDetail()
                ];

            }
            if ( $e instanceof UnexpectedValueException) {
                $response['code'] = $e->getCode();
                $response['title'] = 'ERR_HTTP_FAILED';
                $response['detail'] = $e->getMessage();
            }
            if ($e instanceof AuthenticationException) {
                $response['code'] = 401;
                $response['title'] = 'ERR_AUTHORIZATION_CHECK_FAILED';
                $response['detail'] = $e->getMessage();
            }
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                if($e->validator->errors()) {
                    $response['code'] = 422;
                    $response['title'] = 'ERR_VALIDATION_FAILED_' . strtoupper($e->validator->errors()->keys()[0]);
                    $response['detail'] = $e->validator->errors()->first();
                }
            }
            if ($e instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                $response['code'] = 403;
                $response['title'] = 'ERR_ROLE_EXCEPTION';
                $response['detail'] = __('validation.forbidden');
            }

            if (count($response) > 0) {
                return response()->json([
                    'code' => $response['code'],
                    'title' => $response['title'],
                    'detail' => $response['detail'],

                ], $response['code']);
            }
        }
    }
}
