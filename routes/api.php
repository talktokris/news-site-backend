<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\NewsController;

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


Route::controller(AuthApiController::class)->group(function(){
    Route::post('client-register', 'userRegister');
    Route::post('client-login', 'userLogin');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {

  //  print_r($_REQUEST);
   // print_r($_SERVER);
    Route::post('/profile-info', [ProfileController::class,'profile'])->name('profile');
    Route::post('/user-account', [ProfileController::class,'userSettings'])->name('user.settings');
    Route::post('/user-setting-save', [ProfileController::class,'saveUserSetting'])->name('save.set_settings');
    Route::post('/user-setting-delete', [ProfileController::class,'deleteUserSetting'])->name('delete.set_settings');
    Route::post('/user-setting-news', [NewsController::class,'newsByUserSetting'])->name('news.user_settings');
     
    
   
    
});


Route::get('/home-page', [NewsController::class,'homePage'])->name('api-home-page');
Route::get('/news-search/{string}', [NewsController::class,'search'])->name('api-news-search');


// Route::middleware('auth:sanctum')->group( function () {
//     Route::resource('blogs', BlogController::class);
// });