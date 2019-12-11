<?php

use Illuminate\Http\Request;

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
/*

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/profile', function (Request $request) {
    return $request->profile();
});

*/

Route::post('/user/register','User_controller@register');
Route::post('/user/login','User_controller@login');

Route::post('/profile/createProfile','Perfil_controller@createprofile');
Route::post('/profile/getProfile','Perfil_controller@getProfile');

Route::post('/bodyData/addBodyData','BodyData_controller@addBodyData');
Route::post('/bodyData/addBodyData','BodyData_controller@addBodyData');

Route::post('/routine/getRoutine','Routine_controller@getRoutine');

