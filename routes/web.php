<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AoiController;
use App\Http\Controllers\AxiController;
use App\Http\Controllers\AxiImageController;
use App\Http\Controllers\AoiImageController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form')->middleware('guest');
Route::post('/', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/user', [AdminController::class, 'user'])
        ->middleware(['auth', 'admin'])
        ->name('user');
    Route::post('/register', [AdminController::class, 'register'])
        ->middleware(['auth', 'admin'])
        ->name('register');
    Route::put('/user/{user_id}/edit', [AdminController::class, 'editUser'])
        ->middleware(['auth', 'admin'])
        ->name('user.edit');
    Route::delete('/user/{user_id}/delete', [AdminController::class, 'deleteUser'])
        ->middleware(['auth', 'admin'])
        ->name('user.delete');

    Route::get('/history', [TransactionController::class, 'history'])->middleware(['auth', 'admin'])->name('history');
    Route::get('/transaction', [TransactionController::class, 'Transaction'])->middleware(['auth', 'admin'])->name('transaction');

    Route::prefix('transaction/axi')->middleware(['auth', 'admin'])->name('transaction.axi.')->group(function () {
        Route::get('/', [TransactionController::class, 'AxiIndex'])->name('AxiPage');
        Route::get('/create', [TransactionController::class, 'AxiCreate'])->name('AxiCreate');
        Route::post('/store', [TransactionController::class, 'AxiStore'])->name('AxiStore');
    });

    Route::prefix('transaction/aoi')->middleware(['auth', 'admin'])->name('transaction.aoi.')->group(function () {
        Route::get('/', [TransactionController::class, 'aoiIndex'])->name('aoiPage');
        Route::get('/create', [TransactionController::class, 'aoiCreate'])->name('aoiCreate');
        Route::post('/store', [TransactionController::class, 'aoiStore'])->name('aoiStore');
    });

    // Route::get('/transaction/axi', [TransactionController::class, 'TransactionAxiPage'])->name('transaction.axi.page');
    // Route::get('/transaction/axi/add', [TransactionController::class, 'AddTransactionAxi'])->name('transaction.axi.add');


    // Route::get('/transaction/aoi', [TransactionController::class, 'TransactionAoiPage'])->name('transaction.aoi.page');

    Route::prefix('vitrox')->name('vitrox.')->group(function () {
        Route::get('/', [ProductController::class, 'vitDashboard'])->name('vitDashboard');
        Route::get('/machines', [ProductController::class, 'machines'])->name('machines');
        Route::get('/spi', [ProductController::class, 'spi'])->name('spi');

        Route::get('/aoi', [AoiController::class, 'aoi'])->name('aoi');
        Route::post('/import-aoi', [AoiController::class, 'importAoi'])->name('import.aoi');
        Route::post('/aoi/add', [AoiController::class, 'addDataaoi'])->name('add.aoi');
        Route::post('/aoi/{id}/edit', [AoiController::class, 'updateaoi'])->name('update.aoi');
        Route::post('/truncate-aoi', [AoiController::class, 'truncateaoi'])->name('truncate.aoi');
        Route::delete('/vitrox/delete/aoi/{aoi_id}', [AoiController::class, 'destroyAoi'])->name('delete.aoi');

        Route::get('/axi', [AxiController::class, 'axi'])->name('axi');
        Route::post('/axi/add', [AxiController::class, 'addDataAxi'])->name('add.axi');
        Route::post('/axi/{id}/edit', [AxiController::class, 'updateAxi'])->name('update.axi');
        Route::post('/import-axi', [AxiController::class, 'importAxi'])->name('import.axi');
        Route::post('/truncate-axi', [AxiController::class, 'truncateAxi'])->name('truncate.axi');
        Route::delete('/vitrox/delete/axi/{axi_id}', [AxiController::class, 'destroyAxi'])->name('delete.axi');

        Route::post('/axi/bulk-upload-images/upload', [AxiImageController::class, 'bulkUploadImages'])->name('axi.bulkUploadImages');
        Route::post('/aoi/bulk-upload-images/upload', [AoiImageController::class, 'bulkUploadImages'])->name('aoi.bulkUploadImages');
    });
});
        
        

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
