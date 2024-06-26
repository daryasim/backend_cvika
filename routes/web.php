<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', [TestController::class, 'test']);
Route::get('/home', [TestController::class, 'showHome'])->name('home');
Route::get('/form', [TestController::class, 'showForm'])->name('form');
Route::get('/delete-user/{id}', [TestController::class, 'deleteUserFromWeb'])->name('delete');
Route::post('/create-user', [TestController::class, 'createUser'])->name('create');

