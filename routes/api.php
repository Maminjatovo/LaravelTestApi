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


//Route::get('/utilisateur-test',[UtilisateurController::class,'test'])->name('utilisateur.test');
//Route::apiResource('Enseignat', 'EnseignatController');
//Route::get('/Enseignat-test',[EnseignatController::class,'test'])->name('utilisateur.test');
Route::get('/enseignat', 'App\Http\Controllers\EnseignatController@index');
Route::get('/enseignat/{id}', 'App\Http\Controllers\EnseignatController@show');
Route::post('/enseignat', 'App\Http\Controllers\EnseignatController@store');
Route::put('/enseignat/{id}', 'App\Http\Controllers\EnseignatController@update');
Route::delete('/enseignat/{id}', 'App\Http\Controllers\EnseignatController@destroy');