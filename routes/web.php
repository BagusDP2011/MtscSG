<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AxiController;

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

    Route::prefix('vitrox')->name('vitrox.')->group(function () {
        Route::get('/', [ProductController::class, 'vitDashboard'])->name('vitDashboard');
        Route::get('/machines', [ProductController::class, 'machines'])->name('machines');
        Route::get('/aoi', [ProductController::class, 'aoi'])->name('aoi');
        Route::get('/spi', [ProductController::class, 'spi'])->name('spi');
        Route::get('/axi', [ProductController::class, 'axi'])->name('axi');
        Route::post('/axi/add', [ProductController::class, 'addDataAxi'])->name('add.axi');
        Route::post('/axi/{id}', [ProductController::class, 'updateAxi'])->name('update.axi');
        Route::delete('/vitrox/delete/axi/{axi_id}', [ProductController::class, 'destroyAxi'])->name('delete.axi');
        Route::post('truncate-axi', [ProductController::class, 'truncateAxi'])->name('truncate.axi');
        Route::post('/import-aoi', [ProductController::class, 'importAoi'])->name('import.aoi');
        Route::post('/import-axi', [ProductController::class, 'importAxi'])->name('import.axi');
        Route::post('/axi/bulk-upload-images', [AxiController::class, 'bulkUploadImages'])
            ->name('axi.bulkUploadImages');
    });
});



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
