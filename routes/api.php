<?php

use Illuminate\Http\Request;
use App\Http\Controllers as C;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('health', function () {
    return "OK";
});

/**
 * Offer routes
 */
Route::prefix('offers')->group(function () {
    Route::get('/', [ C\OfferController::class, 'index' ]);
    Route::get('/{uuid}', [ C\OfferController::class, 'show' ]);
});

/**
 * Program routes
 */
Route::prefix('programs')->group(function () {
    Route::get('/', [ C\ProgramController::class, 'index' ]);
});

/**
 * Course routes
 */
Route::prefix('courses')->group(function () {
    Route::get('/', [ C\CourseController::class, 'index' ]);
    Route::post('/', [ C\CourseController::class, 'store' ]);
    Route::get('/{uuid}', [ C\CourseController::class, 'show' ]);
});

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user = $request->user();
    $user->load('permissions');

    return [
        'user' => [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
        ]
    ];
});
