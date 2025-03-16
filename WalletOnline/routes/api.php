<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('test_data', [TestController::class, 'test_data'])->name('api.test_data');


Route::post('register', [UserAuthController::class, 'register']);
Route::post('login',[UserAuthController::class, 'login']);
Route::post('logout',[UserAuthController::class,'logout'])
  ->middleware('auth:sanctum');

Route::get('getSolde/{id}',[UserAuthController::class, 'getSolde']);
Route::post('ajouterArgent',[UserAuthController::class, 'ajouterArgent']);
Route::post('sendArgent',[TransactionController::class, 'sendArgent']);