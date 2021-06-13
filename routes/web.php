<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageSubscriptionController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\WebhookController;
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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');

// Route::middleware(['auth:sanctum', 'verified'])->get('/my_photos', function () {
//     return Inertia::render('MyPhotos');
// })->name('my_photos');


Route::middleware(['auth:sanctum', 'verified'])->group(function() {

    //Route::resource('/photos', PhotosController::class);
    Route::resource('/dashboard', DashboardController::class);
});

Route::middleware(['auth:sanctum', 'verified', 'billing'])->group(function() {
    Route::resource('/photos', PhotosController::class);
    // Route::get('/billing-portal', function (Request $request) {
    //     return $request->user()->redirectToBillingPortal()->name('billing-portal');
    // });
    Route::get('/billing-portal', [ManageSubscriptionController::class, 'getPortal'])->name('billing-portal');
});

Route::get('/subscription', ManageSubscriptionController::class)->name('subscription');
//Route::get('/subscription', ManageSubscriptionController::class)->name('subscription');
// Route::get('/billing-portal', [ManageSubscriptionController::class, 'getPortal'])->name('billing-portal');

// Route::get('/billing-portal', function (Request $request) {
//     $user = $request->user();

//     $stripe = new \Stripe\StripeClient(config('cashier.secret'));
//     $portal = $stripe->billingPortal->sessions->create([
//         'customer' => $user->stripe_id,
//         'return_url' => route('dashboard.index'),
//     ]);
//     return redirect($portal->url);
// });

