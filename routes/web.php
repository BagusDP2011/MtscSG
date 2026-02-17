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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/user', [AdminController::class, 'user'])->name('user');
    Route::post('/register', [AdminController::class, 'register'])->name('register');

    Route::get('/history', [TransactionController::class, 'history'])->name('history');
    Route::get('/transaction', [TransactionController::class, 'Transaction'])->name('transaction');

    Route::prefix('transaction/axi')->name('transaction.axi.')->group(function () {
        Route::get('/', [TransactionController::class, 'AxiIndex'])->name('AxiPage');
        Route::get('/create', [TransactionController::class, 'AxiCreate'])->name('AxiCreate');
        Route::post('/store', [TransactionController::class, 'AxiStore'])->name('AxiStore');
    });

    // Route::get('/transaction/axi', [TransactionController::class, 'TransactionAxiPage'])->name('transaction.axi.page');
    // Route::get('/transaction/axi/add', [TransactionController::class, 'AddTransactionAxi'])->name('transaction.axi.add');


    Route::get('/transaction/aoi', [TransactionController::class, 'TransactionAoiPage'])->name('transaction.aoi.page');

    Route::prefix('vitrox')->name('vitrox.')->group(function () {
        Route::get('/', [ProductController::class, 'vitDashboard'])->name('vitDashboard');
        Route::get('/machines', [ProductController::class, 'machines'])->name('machines');
        Route::get('/spi', [ProductController::class, 'spi'])->name('spi');

        Route::get('/aoi', [AoiController::class, 'aoi'])->name('aoi');
        Route::post('/import-aoi', [AoiController::class, 'importAoi'])->name('import.aoi');
        Route::post('/aoi/add', [AoiController::class, 'addDataaoi'])->name('add.aoi');
        Route::post('/aoi/{id}', [AoiController::class, 'updateaoi'])->name('update.aoi');
        Route::post('/import-aoi', [AoiController::class, 'importaoi'])->name('import.aoi');
        Route::post('/truncate-aoi', [AoiController::class, 'truncateaoi'])->name('truncate.aoi');
        Route::delete('/vitrox/delete/aoi/{aoi_id}', [AoiController::class, 'destroyAoi'])->name('delete.aoi');

        Route::get('/axi', [AxiController::class, 'axi'])->name('axi');
        Route::post('/axi/add', [AxiController::class, 'addDataAxi'])->name('add.axi');
        Route::post('/axi/{id}', [AxiController::class, 'updateAxi'])->name('update.axi');
        Route::post('/import-axi', [AxiController::class, 'importAxi'])->name('import.axi');
        Route::post('/truncate-axi', [AxiController::class, 'truncateAxi'])->name('truncate.axi');
        Route::delete('/vitrox/delete/axi/{axi_id}', [AxiController::class, 'destroyAxi'])->name('delete.axi');

        Route::post('/axi/bulk-upload-images/upload', [AxiImageController::class, 'bulkUploadImages'])->name('axi.bulkUploadImages');
        Route::post('/aoi/bulk-upload-images/upload', [AoiImageController::class, 'bulkUploadImages'])->name('aoi.bulkUploadImages');
    });
});
        
        

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
