<?php

use App\Http\Controllers\Panel\DiscountController;
use App\Http\Controllers\Panel\GrammarController;
use App\Http\Controllers\Panel\MessageController;
use App\Http\Controllers\Panel\OtherController;
use App\Http\Controllers\Panel\QuestionController;
use App\Http\Controllers\Panel\ReadingController;
use App\Http\Controllers\Panel\ReadingTestController;
use App\Http\Controllers\Panel\ServiceController;
use App\Http\Controllers\Panel\SimilarWordController;
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

Route::group(['prefix' => 'panel'],function(){
    Route::get('/',function(){
       return view('dashboard');
    });
Route::get('words',[WordController::class,'index']);
Route::get('similar-words', [SimilarWordController::class, 'index']);
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
Route::post('readings',[ReadingController::class,'store']);
Route::post('readings/{id}',[ReadingController::class,'update']);
Route::post('readings/delete/{id}',[ReadingController::class,'update']);
Route::post('questions', [QuestionController::class, 'store']);
Route::post('questions/{id}',[QuestionController::class,'update']);
Route::post('questions/delete/{id}',[QuestionController::class,'destroy']);
Route::get('grammars', [GrammarController::class, 'index']);
Route::post('grammars', [GrammarController::class, 'store']);
Route::post('grammars/{id}', [GrammarController::class, 'update']);
Route::post('grammars/delete/{id}', [GrammarController::class, 'destroy']);
Route::get('wordTestHelp', [OtherController::class, 'wordTestHelp']);
Route::post('updateWordTestHelp', [OtherController::class, 'updateWordTestHelp']);
Route::get('readingTestHelp', [OtherController::class, 'readingTestHelp']);
Route::post('updateReadingTestHelp', [OtherController::class, 'updateReadingTestHelp']);
Route::get('planning', [OtherController::class, 'planning']);
Route::post('updatePlanning', [OtherController::class, 'updatePlanning']);
Route::get('support',[OtherController::class,'support']);
Route::post('updateSupport',[OtherController::class,'updateSupport']);
Route::get('about', [OtherController::class, 'about']);
Route::post('updateAbout', [OtherController::class, 'updateAbout']);
Route::get('messages',[MessageController::class,'index']);
Route::post('messages',[MessageController::class,'store']);
Route::post('messages/{id}',[MessageController::class,'update']);
Route::post('messages/delete/{id}',[MessageController::class,'destroy']);
Route::resource('discounts',DiscountController::class);
Route::resource('services',ServiceController::class);
});
Route::get('pay',function(){
    return view('pay');
 });

 Route::get('success-pay',function(){
    return view('success-pay');
 });
 Route::get('failed-pay',function(){
    return view('failed-pay');
 });

Route::get('/',function(){
    return view('landing.home');
});
