<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
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

Route::prefix('admin')
        ->middleware(['auth'])
        ->group(function () {

    /**
     * Ledger Routes
     */
    Route::get('ledger/{id}/edit', [LedgerController::class, 'edit'])->name('ledger.edit');
    Route::put('ledger/{id}', [LedgerController::class, 'update'])->name('ledger.update');
    Route::delete('ledger/{id}', [LedgerController::class, 'destroy'])->name('ledger.destroy');
    Route::get('ledger/create', [LedgerController::class, 'create'])->name('ledger.create');
    Route::get('ledger', [LedgerController::class, 'index'])->name('ledger.index');
    Route::post('ledger', [LedgerController::class, 'store'])->name('ledger.store');

    /**
     * Categories Routes
     */
    Route::get('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');

    /**
     * Users Routes
     */
    Route::get('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

    /**
     * Plans Routes
     */
    Route::delete('plans/{id}', [PlanController::class, 'destroy'])->name('plans.destroy');
    Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::post('plans', [PlanController::class, 'store'])->name('plans.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('subscriptions/invoice/{id}', [SubscriptionController::class, 'downloadInvoice'])->name('subscriptions.invoice.download');
    Route::post('subscriptions/store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/account', [SubscriptionController::class, 'account'])->name('subscriptions.account');
    Route::get('/subscriptions/checkout', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout');

    /**
     * Dashboard Routes
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
