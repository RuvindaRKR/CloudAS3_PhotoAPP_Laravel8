<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageSubscriptionController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\CommentsController;

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
    Route::get('/search', [DashboardController::class, 'searchPhotos'])->name('search');
    Route::get('/sortbyrank', [DashboardController::class, 'sortByRank'])->name('sortbyrank');
    Route::get('/subscription', ManageSubscriptionController::class)->name('subscription');
});

Route::middleware(['auth:sanctum', 'verified', 'billing'])->group(function() {
    Route::resource('/photos', PhotosController::class);
    Route::get('/billing-portal', [ManageSubscriptionController::class, 'getPortal'])->name('billing-portal');
});

// Route::post('/stripe/webhook', WebhookController::class)->name('cashier.webhook');


