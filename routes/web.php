<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

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

Route::get('/', [JobOfferController::class, 'index'])
    ->middleware('auth')
    ->name('root');

// Route::get('/', function () {
//     return view('welcome');
// // });
// })->name('welcome');
Route::get('/welcome', function () {
    return view('welcome');
})->middleware('guest')
    ->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->name('dashboard');
});

Route::get('company/register', function () {
    return view('company.register');
})->middleware('guest')
    ->name('company.register');

Route::resource('job_offers.messages', MessageController::class)
    ->only(['store', 'destroy'])
    ->middleware('auth');

Route::resource('job_offers', JobOfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('can:company');

Route::resource('job_offers', JobOfferController::class)
    ->only(['show', 'index'])
    ->middleware('auth');

Route::patch('/job_offers/{job_offer}/entries/{entry}/approval', [EntryController::class, 'approval'])
    ->name('job_offers.entries.approval')
    ->middleware('can:company');

Route::patch('/job_offers/{job_offer}/entries/{entry}/reject', [EntryController::class, 'reject'])
    ->name('job_offers.entries.reject')
    ->middleware('can:company');

Route::resource('job_offers.entries', EntryController::class)
    ->only(['store', 'destroy'])
    ->middleware('can:user');

Route::resource('entries.messages', ChatController::class)
    ->only(['index', 'store', 'destroy'])
    ->middleware('auth');
