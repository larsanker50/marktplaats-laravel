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

route::get('authentication/logout', [ AuthenticationController::class,
'logout'])->name('authentication.logout');

route::post('authentication/authenticate', [ AuthenticationController::class,
'authenticate'])->name('authentication.authenticate');

//advertisementcontroller

route::get('advertisement/index', [ AdvertisementController::class,
'index'])->name('advertisement.index');

route::get('advertisement/personal_index', [ AdvertisementController::class,
'personal_index'])->name('advertisement.personal_index');

route::get('advertisement/show/{advertisement}', [ AdvertisementController::class,
'show'])->name('advertisement.show');

route::get('advertisement/create', [ AdvertisementController::class,
'create'])->name('advertisement.create');

route::post('advertisement/store', [ AdvertisementController::class,
'store'])->name('advertisement.store');

route::get('advertisement/edit/{advertisement}', [ AdvertisementController::class,
'edit'])->name('advertisement.edit');

route::get('advertisement/destroy/{advertisement}', [ AdvertisementController::class,
'destroy'])->name('advertisement.destroy');

route::post('advertisement/update/{advertisement}', [ AdvertisementController::class,
'update'])->name('advertisement.update');

//biddingcontroller

route::post('bidding/store/{advertisement}', [ BiddingController::class,
'store'])->name('bidding.store');

route::get('bidding/destroy/{advertisement}/{bidding}', [ BiddingController::class,
'destroy'])->name('bidding.destroy');

//messagecontroller

route::get('message/index/{user}', [ MessageController::class,
'index'])->name('message.index');

route::post('message/store/{user}', [ MessageController::class,
'store'])->name('message.store');

