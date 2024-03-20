<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthController::class, 'login'])->name('login.blade.php');
Route::post('login', [AuthController::class, 'doLogin'])->name('doLogin');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [MessageController::class, 'chat'])->name('chat');
    Route::post('message', [MessageController::class, 'store'])->name('message.send-message');
});
