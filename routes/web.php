<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BiddingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\UserController;

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

route::get('/', [ UserController::class,
'index'])->name('user.index');
