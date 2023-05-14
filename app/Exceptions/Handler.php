<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use App\Exceptions\ItemDoesNotExit;
use App\Exceptions\InvalidForeignKey;
use App\Exceptions\ForeignKeyConstraintException;
use App\Exceptions\InvalidDateException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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

        $this->renderable(function (ItemDoesNotExit $e, Request $request) {
            return response()->json([
                'status' => 404,
                'message' => 'The item does not exist'
            ], 404);
        });

        $this->renderable(function (InvalidForeignKey $e, Request $request) {
            return response()->json([
                'status' => 404,
                'message' => 'The foreign key is invalid'
            ], 404);
        });

        $this->renderable(function (ForeignKeyConstraintException $e, Request $request) {
            return response()->json([
                'status' => 404,
                'message' => 'Cannot delete this resource because it is being used in another resource as a foreign key.'
            ], 404);
        });
    
        $this->renderable(function (InvalidDateFormatException $e, Request $request) {
            return response()->json([
                'status' => 422,
                'message' => 'Invalid date format'
            ], 404);
        });
    }
}
