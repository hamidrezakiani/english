<?php

use App\Http\Controllers\Panel\QuestionController;
use App\Http\Controllers\Panel\ReadingTestController;
use App\Http\Controllers\Panel\WordController;
use App\Http\Controllers\Panel\WordTestController;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/',function(){
    return view('dashboard');
});
Route::get('words',[WordController::class,'index']);
Route::get('word-tests',[WordTestController::class,'index']);
Route::post('word-tests', [WordTestController::class, 'store']);
Route::get('word-tests/{id}',[WordTestController::class,'edit']);
Route::post('word-tests/{id}', [WordTestController::class, 'update']);
Route::get('word-tests/delete/{id}',[WordTestController::class,'destroy']);
Route::get('reading-tests', [ReadingTestController::class, 'index']);
Route::post('reading-tests', [ReadingTestController::class, 'store']);
Route::get('reading-tests/{id}', [ReadingTestController::class, 'edit']);
Route::post('reading-tests/{id}', [ReadingTestController::class, 'update']);
Route::get('reading-tests/delete/{id}', [ReadingTestController::class, 'destroy']);
Route::post('questions', [QuestionController::class, 'store']);
Route::post('questions/{id}',[QuestionController::class,'update']);
Route::post('questions/delete/{id}',[QuestionController::class,'destroy']);
