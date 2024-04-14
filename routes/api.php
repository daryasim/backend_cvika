<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test-post', [TestController::class, 'testPost']);

Route::prefix("upload")->group(function () {
    Route::post('/test-upload', [TestController::class, 'testUpload']);
});

Route::get('/get-user/{id}', [TestController::class, 'findUserById']);
Route::get('/get-user-address/{email}', [TestController::class, 'getUserAddress']);
Route::post('/get-user-by-phone', [TestController::class, 'findUserByPhone']);
Route::post('/save-user', [TestController::class, 'saveUser']);
Route::post('/save-user-address/{id}', [TestController::class, 'saveUserAddress']);
Route::delete('/delete-phone', [TestController::class, 'deletePhoneNumber']);
Route::patch('/update-phone/{userId}', [TestController::class, 'updatePhoneNumber']);
