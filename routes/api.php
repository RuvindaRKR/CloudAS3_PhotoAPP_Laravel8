<?php

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

// Route::middleware('auth:sanctum')->prefix('api')->group(function() {
//     Route::apiResource('photos','App\Http\Controllers\PhotosController');
//     Route::apiResource('comments','App\Http\Controllers\CommentsController');
// });

// Route::apiResource('photos','App\Http\Controllers\PhotosController');
// Route::apiResource('comments','App\Http\Controllers\CommentsController');

// Route::post('/photos', 'App\Http\Controllers\PhotosController@store')->middleware('auth:sanctum');

// Route::put('/photos', ['App\Http\Controllers\PhotosController', 'store'])
//             ->middleware(['auth'])
//             ->name('photo.store');
