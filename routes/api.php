<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\GrammarController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\OtherController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReadingTestController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SimilarWordController;
use App\Http\Controllers\Api\WordController;
use App\Http\Controllers\Api\WordTestController;
use App\Http\Controllers\User\ProfileController;
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
Route::group(['middleware' => ['auth:api'],'prefix' => 'account'],function(){
  Route::post('profile/update',[ProfileController::class,'update']);
  Route::get('profile',[ProfileController::class,'show']);
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
Route::get('reading-tests', [ReadingTestController::class, 'index']);
Route::get('messages',[MessageController::class,'index']);
Route::get('grammars',[GrammarController::class,'index']);
Route::get('app/words',)
Route::get('word-test-tutorial',[OtherController::class,'wordTestTutorial']);
Route::get('passage-test-tutorial',[OtherController::class,'readingTestTutorial']);
Route::get('support',[OtherController::class,'support']);
Route::get('about',[OtherController::class,'about']);
// payment routes

Route::get('payment',[PaymentController::class,'pay']);
Route::get('verifyPayment/{id}',[PaymentController::class,'verify']);
Route::get('services/amount',[ServiceController::class,'getAmount']);
Route::get('services/order',function(){

});

Route::get('order',function(Request $request){
    dd($request);
});

//discount

Route::post('check-discount-code',[DiscountController::class,'checkCode']);

