<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OtherController;
use App\Http\Controllers\Api\SimilarWordController;
use App\Http\Controllers\Api\WordController;
use App\Http\Controllers\Api\WordTestController;
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
Route::post('verificationCode', [AuthController::class, 'verificationCode']);
Route::post('verify', [AuthController::class, 'verify']);
Route::get('excel', [AuthController::class, 'excel']);
Route::get('planning',[OtherController::class,'planning']);
Route::resource('words',WordController::class);
Route::post('word-move-up/{id}',[WordController::class,'moveUp']);
Route::post('word-move-down/{id}',[WordController::class,'moveDown']);
Route::post('word-swap', [WordController::class, 'swap']);
Route::post('word-jump', [WordController::class, 'jump']);
Route::resource('similar-words', SimilarWordController::class);
Route::post('similar-word-move-up/{id}', [SimilarWordController::class, 'moveUp']);
Route::post('similar-word-move-down/{id}', [SimilarWordController::class, 'moveDown']);
Route::post('similar-word-swap', [SimilarWordController::class, 'swap']);
Route::post('similar-word-jump', [SimilarWordController::class, 'jump']);
Route::get('word-tests',[WordTestController::class,'index']);

