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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


Auth::routes(['verify' => true]);

//Only Login Users can view the above links
Route::group(['middleware'=>'auth'], function() {
    Route::get('/users/api', function () {
        return view('users.token');
    })->name('users.api');
    Route::get('/home', 'QrcodeController@index')->middleware('verified');
    Route::resource('qrcodes', 'QrcodeController')->except(['show']);
    Route::resource('transactions', 'TransactionController')->except(['show']);
    Route::resource('users', 'UserController');
    Route::resource('accounts', 'AccountController')->except(['show']);
    Route::get('/accounts/show/{id?}', 'AccountController@show')->name('accounts.show');
    Route::resource('accountHistories', 'AccountHistoryController');

    Route::group(['middleware'=>'checkemployee'], function() {
        Route::get('/users', 'UserController@index')->name('users.index');
    });
    //Only Admin can access this routes
    Route::resource('roles', 'RoleController')->middleware('checkadmin');
    Route::post('/accounts/apply_for_payout', 'AccountController@apply_for_payout')->name('accounts.apply_for_payout');
    Route::post('/accounts/mark_as_paid', 'AccountController@mark_as_paid')->name('accounts.mark_as_paid')->middleware('checkemployee');
    Route::get('accounts', 'AccountController@index')->name('accounts.index')->middleware('checkemployee');
    Route::get('accounts/create', 'AccountController@create')->name('accounts.create')->middleware('checkadmin');
    Route::get('accountHistories', 'AccountHistoryController@index')->name('accountHistories.index')->middleware('checkemployee');
    Route::get('accountHistories/create', 'AccountHistoryController@create')->name('accountHistories.create')->middleware('checkadmin');
});
//Routes Accessible when logged out
Route::get('/qrcodes/{id}', 'QrcodeController@show')->name('qrcodes.show');
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
Route::post('/qrcodes/show_payment_page', 'QrcodeController@show_payment_page')->name('qrcodes.show_payment_page');
Route::get('/transactions/{id}', 'TransactionController@show')->name('transactions.show');