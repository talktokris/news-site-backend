<?php

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
/*
Route::get('/', function () {
    return "Welcome to Backend";
    //return view('welcome');
   // redirect ('/login');
});
*/

Auth::routes();
Route::get('/', [App\Http\Controllers\UsersController::class, 'redirectLogin'])->name('redirect_login');
Route::group(['middleware' => ['auth']], function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/api-settings', [App\Http\Controllers\ApiSettingController::class, 'fetchApiSettings'])->name('api_settings');
Route::get('/user-list', [App\Http\Controllers\UsersController::class, 'fetchUsers'])->name('users_list');
Route::get('/user-view/{id}', [App\Http\Controllers\UsersController::class, 'viewUser'])->name('users_view');

});
/*
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
/*
Route::get('/news', [App\Http\Controllers\TestController::class, 'index'])->name('news');
Route::get('/news/ny', [App\Http\Controllers\TestController::class, 'newYork'])->name('new-york');
Route::get('/use-api', [App\Http\Controllers\TestController::class, 'commanTest'])->name('use.api');
Route::get('/news-api', [App\Http\Controllers\Api\NewsApiController::class, 'commanTest'])->name('new.api');
Route::get('/new-api', [App\Http\Controllers\Api\NewYorkApiController::class, 'commanTest'])->name('new.api');
Route::get('/guard-api', [App\Http\Controllers\Api\GuardianApiController::class, 'commanTest'])->name('new.api');
Route::get('/api-test', [App\Http\Controllers\Api\NewsController::class, 'commanTest'])->name('new.api');
*/

/* cron job route to get news source, category, auther  */
Route::get('/cron-jobs', [App\Http\Controllers\Api\NewsController::class, 'settingsCronJobs'])->name('new.cron_jobs');