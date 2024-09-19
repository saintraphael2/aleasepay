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



Auth::routes();
//Route::middleware(['auth'])->group(function () {
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/validationOtp', [App\Http\Controllers\HomeController::class, 'validationOtp'])->name('validationOtp');
Route::get('/otp', [App\Http\Controllers\HomeController::class, 'otp'])->name('otp');
Route::get('/rib', [App\Http\Controllers\CptClientController::class, 'rib'])->name('rib');
//Route::get('/attestation/{$id}', [App\Http\Controllers\CptClientController::class, 'attestation']); pregister
Route::resource('cptClients', App\Http\Controllers\CptClientController::class);
Route::get('attestation/{id}',['as'=>'attestation','uses' => 'App\Http\Controllers\CptClientController@attestation'] );
Route::resource('mouvements', App\Http\Controllers\MouvementController::class);
Route::get('checkemail',['as'=>'checkemail','uses' => 'App\Http\Controllers\CptClientController@checkemail'] );
Route::get('checkcode',['as'=>'checkcode','uses' => 'App\Http\Controllers\CptClientController@checkcode'] );
//});

