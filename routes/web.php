<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\SubscriberController;
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
    return view('subscribers.index');
})->middleware('mailerlite.auth');

Route::resource('subscribers', SubscriberController::class)
    ->middleware('mailerlite.auth')
    ->except('show', 'index');

Route::resource('api-keys', ApiKeyController::class)->only('create', 'store');

Route::get('ml/subscribers', [SubscriberController::class, 'getSubscribers']);