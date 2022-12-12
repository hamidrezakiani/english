<?php

use App\Http\Controllers\Api\WordController;
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

Route::resource('words',WordController::class);
Route::post('word-move-up/{id}',[WordController::class,'moveUp']);
Route::post('word-move-down/{id}',[WordController::class,'moveDown']);
Route::post('word-swap', [WordController::class, 'swap']);
Route::post('word-jump', [WordController::class, 'jump']);
