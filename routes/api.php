<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::post('/auth/login', [AuthController::class, 'login']);



Route::group(['middleware' => ['auth:sanctum']], function () {


    // Admin routes
    Route::middleware('role:Admin')->group(function () {
        // Routes accessible only to the "Admin" role

    });

    Route::apiResources([
        '/items' => ItemController::class,
        '/category' => CategoryController::class,
        '/user' => UserController::class,
        '/request' => RequestController::class,
        '/order' => OrderController::class,

    ]);

    Route::post('/request-filtered', [RequestController::class, 'requestFiltered']);
    Route::post('/order-filtered', [OrderController::class, 'requestFiltered']);


});
