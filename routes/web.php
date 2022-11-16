<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniversityController;
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
         * Universites Routes
         */
        Route::get('universities/delete/{id}', [UniversityController::class, 'delete'])->name('universities.delete');
        Route::get('universities/{id}/edit', [UniversityController::class, 'edit'])->name('universities.edit');
        Route::put('universities/{id}', [UniversityController::class, 'update'])->name('universities.update');
        Route::delete('universities/{id}', [UniversityController::class, 'destroy'])->name('universities.destroy');
        Route::get('universities/create', [UniversityController::class, 'create'])->name('universities.create');
        Route::post('universities', [UniversityController::class, 'store'])->name('universities.store');
        Route::get('universities', [UniversityController::class, 'index'])->name('universities.index');

        /**
         * Paths Routes
         */
        Route::get('paths/delete/{id}', [PathController::class, 'delete'])->name('paths.delete');
        Route::get('paths/{id}/edit', [PathController::class, 'edit'])->name('paths.edit');
        Route::put('paths/{id}', [PathController::class, 'update'])->name('paths.update');
        Route::delete('paths/{id}', [PathController::class, 'destroy'])->name('paths.destroy');
        Route::get('paths/create', [PathController::class, 'create'])->name('paths.create');
        Route::post('paths', [PathController::class, 'store'])->name('paths.store');
        Route::get('paths', [PathController::class, 'index'])->name('paths.index');

        /**
         * Ledger Routes
         */
        Route::get('ledger/delete/{id}', [LedgerController::class, 'delete'])->name('ledger.delete');
        Route::get('ledger/{id}/edit', [LedgerController::class, 'edit'])->name('ledger.edit');
        Route::put('ledger/{id}', [LedgerController::class, 'update'])->name('ledger.update');
        Route::delete('ledger/{id}', [LedgerController::class, 'destroy'])->name('ledger.destroy');
        Route::get('ledger/create', [LedgerController::class, 'create'])->name('ledger.create');
        Route::get('ledger', [LedgerController::class, 'index'])->name('ledger.index');
        Route::post('ledger', [LedgerController::class, 'store'])->name('ledger.store');

        /**
         * Categories Routes
         */
        Route::get('categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');

        /**
         * Plans Routes
         */
        Route::get('plans/delete/{id}', [PlanController::class, 'delete'])->name('plans.delete');
        Route::get('plans/{id}/edit', [PlanController::class, 'edit'])->name('plans.edit');
        Route::put('plans/{id}', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('plans/{id}', [PlanController::class, 'destroy'])->name('plans.destroy');
        Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
        Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
        Route::post('plans', [PlanController::class, 'store'])->name('plans.store');

        /**
         * Users Routes
         */
        Route::get('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
        Route::get('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::get('users/{id}/show', [UserController::class, 'show'])->name('users.show');
        Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users', [UserController::class, 'store'])->name('users.store');

        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

        Route::get('subscriptions/delete/{id}', [InvoiceController::class, 'delete'])->name('subscriptions.delete');
        Route::get('subscriptions/{id}/edit', [InvoiceController::class, 'edit'])->name('subscriptions.edit');
        Route::put('subscriptions/{id}', [InvoiceController::class, 'update'])->name('subscriptions.update');
        Route::delete('subscriptions/{id}', [InvoiceController::class, 'destroy'])->name('subscriptions.destroy');
        Route::get('users/{id}/subscriptions/create', [InvoiceController::class, 'create'])->name('subscriptions.create');
        Route::post('users/{id}/subscriptions', [InvoiceController::class, 'store'])->name('subscriptions.store');
    });

Route::middleware(['auth'])->group(function () {
    /**
     * Profile Routes
     */
    Route::get('user/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('user/profile', [ProfileController::class, 'update'])->name('profile.update');

    /**
     * Subscription Routes
     */
    Route::get('subscriptions/invoice/{id}', [InvoiceController::class, 'downloadInvoice'])->name('subscriptions.invoice.download');
    Route::put('subscriptions/{id}', [InvoiceController::class, 'paying'])->name('subscriptions.paying');
    Route::get('subscriptions/history', [InvoiceController::class, 'history'])->name('subscriptions.history');
    Route::get('subscriptions/checkout/{id}', [InvoiceController::class, 'checkout'])->name('subscriptions.checkout');
    Route::get('subscriptions/payable', [InvoiceController::class, 'payable'])->name('subscriptions.payable');

    /**
     * Dashboard Route
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/**
 * Landing Page Route
 */
Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';
