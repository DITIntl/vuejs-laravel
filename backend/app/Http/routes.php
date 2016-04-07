<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
  return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::options('{slug}', function () {
  $response = new \Illuminate\Http\Response();
  if (env('APP_ENV') !== 'live') {
    $response->headers->add([
      'Access-Control-Allow-Origin' => \Request::header('Origin')
    ]);
  }
  \Log::info(json_encode($response));
  return $response;
})->where('slug', '([A-z\d-\/_.]+)?');

Route::group(['middleware' => ['web']], function () {
  //
  Route::post('auth/register', 'Auth\AuthController@postRegister');
  Route::get('current_user', 'HomeController@getCurrentUser');
  Route::post('current_user', 'HomeController@postCurrentUser');
  Route::delete('current_user', 'HomeController@deleteCurrentUser');
});