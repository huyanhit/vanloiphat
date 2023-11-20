<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');
Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
    
require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/san-pham', [ProductController::class, 'index'])->name('list-product.index');
Route::get('/san-pham/{name}', [ProductController::class, 'show'])->name('product.show');
Route::get('/loai-san-pham/{name}', [CategoryProductController::class, 'show'])->name('category-product.show');
Route::get('/thong-tin', [NewsController::class, 'index'])->name('news.index');
Route::get('/thong-tin/{name}', [NewsController::class, 'index'])->name('news.show');
Route::get('/dich-vu', [ServiceController::class, 'index'])->name('service.index');
Route::get('/dich-vu/{name}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/thong-tin', [NewsController::class, 'index'])->name('info.index');
Route::get('/thong-tin/{name}', [NewsController::class, 'show'])->name('info.show');
Route::get('/search',   [ProductController::class, 'search'])->name('product.search');
Route::get('/counter', [HomeController::class, 'counter'])->name('page.counter');

Route::post('/search',  [ProductController::class, 'search'])->name('product.search');
Route::post('/contact', [PageController::class, 'saveContact'])->middleware('throttle:3,10')->name('page.contact');  
Route::get('/{page}', [PageController::class, 'show'])->name('page.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

