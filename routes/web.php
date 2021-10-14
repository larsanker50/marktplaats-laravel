<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BiddingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationController;

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

//usercontroller
route::get('/', [ UserController::class,
'index'])->name('user.index');

route::get('user/create', [ UserController::class,
'create'])->name('user.create');

route::post('user/store', [ UserController::class,
'store'])->name('user.store');

//authenticationcontroller

route::get('authentication/login', [ AuthenticationController::class,
'login'])->name('authentication.login');

route::post('authentication/authenticate', [ AuthenticationController::class,
'authenticate'])->name('authentication.authenticate');

//advertisementcontroller

route::get('advertisement/index', [ AdvertisementController::class,
'index'])->name('advertisement.index');
