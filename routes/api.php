<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

use App\Http\Controllers\API\MultipleUploadController;

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
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
    'prefix'     => 'auth',
],function($router) {
    Route::post('login','AuthController@login');
    Route::post('register','AuthController@register');
    Route::post('logout','AuthController@logout');
    Route::get('profile','AuthController@profile');
    Route::post('refresh','AuthController@refresh'); 
    Route::post('upload','FileController@upload'); 
    Route::post('multiple-image-upload','MultipleUploadController@upload'); 
    Route::get('downloadfile', 'DownloadFileController@downloadfile');
    Route::get('sendsms', 'SmsController@sendsms');
    Route::post('sendemail', 'MailController@sendemail');
    
}
);

Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
    
],function($router) {
    Route::apiresource('todos','TodoController'); 
}
);

Route::fallback(function(){
 
return response()->json(['message' => 'Resouce Not Found Or A Given Route Does Not Exist '], 404);
 
});











