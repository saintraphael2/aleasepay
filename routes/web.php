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
Route::post('/password/update', [App\Http\Controllers\PasswordController::class, 'update'])->name('password.update');
Route::get('/otp', [App\Http\Controllers\HomeController::class, 'otp'])->name('otp');
Route::get('/rib', [App\Http\Controllers\CptClientController::class, 'rib'])->name('rib');
//Route::get('/attestation/{$id}', [App\Http\Controllers\CptClientController::class, 'attestation']); pregister
Route::resource('cptClients', App\Http\Controllers\CptClientController::class);
Route::get('attestation/{id}',['as'=>'attestation','uses' => 'App\Http\Controllers\CptClientController@attestation'] );
Route::resource('mouvements', App\Http\Controllers\MouvementController::class);
Route::get('checkemail',['as'=>'checkemail','uses' => 'App\Http\Controllers\CptClientController@checkemail'] );
Route::get('checkcode',['as'=>'checkcode','uses' => 'App\Http\Controllers\CptClientController@checkcode'] );
Route::get('releve/{compte}/{deb}/{fin}',['as'=>'releve','uses' => 'App\Http\Controllers\MouvementController@releve'] );
Route::get('/forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');

Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 

Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::get('/errorpage', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showErrorpage'])->name('errorpage');


Route::post('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//Route::get('/saisieotp', [App\Http\Controllers\HomeController::class, 'saisieotp'])->name('saisieotp');passwordUpdate
//});


Route::resource('bordereaux', App\Http\Controllers\BordereauController::class);
Route::resource('type_bordereaus', App\Http\Controllers\Type_bordereauController::class);


Route::get('/cnss/cotisations', [App\Http\Controllers\CotisationCNSSController::class, 'index'])->name('cnss.cotisations');
Route::get('/cnss/cotisations/search', [App\Http\Controllers\CotisationCNSSController::class, 'search'])->name('cnss.cotisations.search');

//Route::resource('cnss', App\Http\Controllers\CotisationCNSSController::class);