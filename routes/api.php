<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::get('/genres', 'GenreController@index');
Route::get('/movies', 'MovieController@index');
Route::get('/movies/{movie}/images', 'MovieController@images');
Route::get('/movies/{movie}/actors', 'MovieController@actors');
Route::get('/movies/{movie}/related_movies', 'MovieController@relatedMovies');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/movies/toggle_movies', 'MovieController@toggelFav');
    Route::get('/movies/{movie}/is_favored','MovieController@isFavorite');
    Route::get('/movies/favored','MovieController@index');

    Route::post('/user', 'AuthController@user');
    Route::post('/logout', 'AuthController@logout');
});
