<?php

use App\Exceptions\ApiException;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        // Change your raw 'api:' configuration line to this closure format:
        then: function () {
            Route::middleware('api')
                ->prefix('api') // This explicitly forces the 'api/' prefix!
                ->group(__DIR__ . '/../routes/api.php');
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // ... other middleware
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Custom API Exceptions
        $exceptions->render(function (ApiException $e, $request) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());

        });

        // Model Not Found
        $exceptions->render(function (ModelNotFoundException $e, $request) {

            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
            ], 404);

        });

        // Unauthorized
        $exceptions->render(function (AuthorizationException $e, $request) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action',
            ], 403);

        });

        // Authentication
        $exceptions->render(function (AuthenticationException $e, $request) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);

        });

        // Validation
        $exceptions->render(function (ValidationException $e, $request) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        });

    })
    ->create();