<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageSubscriptionController;
use App\Http\Controllers\CommentsController;
use Illuminate\Http\Request;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::resource('/dashboard', DashboardController::class);
    Route::get('/search', [DashboardController::class, 'searchPhotos'])->name('search');;
});

Route::middleware(['auth:sanctum', 'verified', 'billing'])->group(function() {
    Route::resource('/photos', PhotosController::class);
    // Route::get('/billing-portal', function (Request $request) {
    //     return $request->user()->redirectToBillingPortal()->name('billing-portal');
    // });
    Route::get('/billing-portal', [ManageSubscriptionController::class, 'getPortal'])->name('billing-portal');
});

Route::get('/subscription', ManageSubscriptionController::class)->name('subscription');

