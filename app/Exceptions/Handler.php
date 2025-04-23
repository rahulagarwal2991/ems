<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;

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
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof AttendeeNotFoundException) {
            return response()->json([
                'error' => $exception->getMessage() ?? 'Attendee not found.'
            ], 404);
        }

        if ($exception instanceof AttendeeOperationException) {
            return response()->json([
                'error' => $exception->getMessage() ?? 'Failed to process attendee operation.'
            ], 400);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'error' => 'Validation failed.',
                'messages' => $exception->errors()
            ], 422);
        }

        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found.'
            ], 404);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'error' => 'Route not found.'
            ], 404);
        }

        // Default fallback for other exceptions
        return response()->json([
            'error' => 'An unexpected error occurred.',
            'message' => config('app.debug') ? $exception->getMessage() : null,
        ], 500);
    }
}
