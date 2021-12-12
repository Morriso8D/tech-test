<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TransactionController;

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

Route::post('/dashboard/transaction/create', [TransactionController::class, 'create'])
->middleware(['auth'])->name('transaction.create');

Route::get('/dashboard/transaction/results', [TransactionController::class, 'results'])
->middleware(['auth'])->name('transaction.results');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::permanentRedirect('/', '/dashboard');

require __DIR__.'/auth.php';
