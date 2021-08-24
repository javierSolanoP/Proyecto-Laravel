<?php

use Illuminate\Support\Facades\Route;
use App\Mail\RecoverdPassword;
use Illuminate\Support\Facades\Mail;
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
    return view('Templates.header');
});

//Modulo de Usuario:
Route::get('/users', function () {
    return view('UserModule.signin');
});


Route::get('/users/RecoverdPassword', function(){
    
    return "Email enviado.";
});

