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
Route::middleware(['auth'])->group(function () {
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


Route::get('/errorpage', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showErrorpage'])->name('errorpage');



//Route::get('/saisieotp', [App\Http\Controllers\HomeController::class, 'saisieotp'])->name('saisieotp');passwordUpdate


Route::resource('bordereaux', App\Http\Controllers\BordereauController::class);
Route::resource('type_bordereaus', App\Http\Controllers\Type_bordereauController::class);


Route::get('/cnss/cotisations', [App\Http\Controllers\CotisationCNSSController::class, 'index'])->name('cnss.cotisations');
Route::get('/cnss/cotisations/search', [App\Http\Controllers\CotisationCNSSController::class, 'search'])->name('cnss.cotisations.search');
Route::get('/cnss/cotisations/{reference}/form/{numero_employeur}', [App\Http\Controllers\CotisationCNSSController::class, 'showForm'])
    ->name('cnss.cotisations.form');

Route::post('/cnss/cotisations/pay', [App\Http\Controllers\CotisationCNSSController::class, 'paiement'])->name('cnss.cotisations.pay');

Route::get('/transactions/listing', [App\Http\Controllers\CotisationCNSSController::class,'listing'])->name('transactions.index');
Route::post('/transactions/search', [App\Http\Controllers\CotisationCNSSController::class,'filter'])->name('transactions.filter');
Route::get('/quittance/{transaction}', [App\Http\Controllers\CotisationCNSSController::class, 'quittance'])->name('transaction.quittance');

Route::get('/otr/etax', [App\Http\Controllers\OTREtaxController::class, 'index'])->name('otr.etax');
Route::get('/otr/etax/search', [App\Http\Controllers\OTREtaxController::class, 'search'])->name('otr.etax.search');
Route::post('/otr/etax/pay', [App\Http\Controllers\OTREtaxController::class, 'paiement'])->name('otr.etax.pay');


#Route::resource('mybordereaux', App\Http\Controllers\MyBordereauController::class);
Route::get('/bordereau/listing', [App\Http\Controllers\MyBordereauController::class,'index'])->name('commandeBordereau.index');
Route::get('/bordereau/cancel', [App\Http\Controllers\MyBordereauController::class,'cancel'])->name('commandeBordereau.cancel');

Route::get('/bordereau/showCommand', [App\Http\Controllers\MyBordereauController::class, 'command'])->name('commandeBordereau.form');
Route::post('/bordereau/command', [App\Http\Controllers\MyBordereauController::class, 'docommand'])->name('commandeBordereau.docommand');
Route::post('/bordereau/checklist', [App\Http\Controllers\MyBordereauController::class, 'filter'])->name('commandeBordereau.filter');
Route::post('/bordereau/filterfirst', [App\Http\Controllers\MyBordereauController::class, 'filterfirst'])->name('commandeBordereau.filterfirst');
Route::get('/autocomp-matricule', [App\Http\Controllers\MyBordereauController::class, 'getCompteLibelle'])->name('bordereau.getCompteLibelle');


Route::get('/pending/index', [App\Http\Controllers\TransactionPendingController::class,'listing'])->name('pending.index');
Route::post('/pending/search', [App\Http\Controllers\TransactionPendingController::class,'search'])->name('pending.search');
Route::post('/pending/searchotr', [App\Http\Controllers\TransactionPendingController::class,'searchByReferenceTaxe'])->name('pending.searchotr');
Route::post('/pending/getmontantttc', [App\Http\Controllers\TransactionPendingController::class,'getMontantTTC'])->name('pending.getmontantttc');



Route::post('/pending/filter', [App\Http\Controllers\TransactionPendingController::class,'getPendingTransactionsByDate'])->name('pending.filter');
Route::post('/pending/cancel', [App\Http\Controllers\TransactionPendingController::class,'cancelTransactionPending'])->name('pending.cancel');
Route::post('/pending/paiementcss', [App\Http\Controllers\TransactionPendingController::class,'paiement'])->name('pending.paiementcnss');
Route::post('/pending/paiementotr', [App\Http\Controllers\TransactionPendingController::class,'paiementOTR'])->name('pending.paiementotr');



Route::post('/pending/save', [App\Http\Controllers\TransactionPendingController::class,'saveTransactionPending'])->name('pending.save');
Route::post('/pending/otr/save', [App\Http\Controllers\TransactionPendingController::class,'saveTransactionPendingOTR'])->name('pending.otr.save');


});
Route::get('/reset-password-frombackoffice/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showInitPasswordForm']);
Route::post('/reset-password-frombackoffice', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPasswordBanckoffice']);
Route::post('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::get('/forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
