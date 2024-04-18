<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('artisan/{command}', function ($command){
    Artisan::call($command);
    return Artisan::output();
});

Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');
Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

// ajax
Route::get('/ax-find-product', [ProductController::class, 'productCategory'])->name('ajax-find-product');
Route::get('/ax-load-comment', [CommentController::class, 'loadComment'])->name('ajax-load-comment');
Route::post('/ax-comment', [CommentController::class, 'comment'])->name('ajax-comment');

require __DIR__.'/auth.php';
Route::resource('/cart', CartController::class);
Route::get('/counter', [HomeController::class, 'counter'])->name('page.counter');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/phan-loai/{name}', [CategoryProductController::class, 'show'])->name('phan-loai');
Route::get('/san-pham/{name}', [ProductController::class, 'show'])->name('san-pham');
Route::get('/dat-hang', [CheckController::class, 'index'])->name('dat-hang');
Route::get('/tra-cuu-don-hang', [OrderController::class, 'search'])->name('tra-cuu-don-hang');
Route::get('/thanh-toan/{order}', [OrderController::class, 'show'])->name('thanh-toan');
Route::put('/thanh-toan/{order}', [OrderController::class, 'update'])->name('tat-toan');
Route::post('/mua-hang', [OrderController::class, 'store'])->name('mua-hang');
Route::get('/tim-kiem',   [ProductController::class, 'search'])->name('tim-kiem');
Route::get('/dich-vu/{service}', [ServiceController::class, 'show'])->name('dich-vu');
Route::get('/hang-san-xuat/{service}', [ProducerController::class, 'show'])->name('hang-san-xuat');
Route::get('/so-sanh/{product}/{product2?}', [ProductController::class, 'compare'])->name('so-sanh');
Route::post('/lien-he', [PageController::class, 'saveContact'])->name('lien-he');


Route::get('/thong-tin', [NewsController::class, 'index'])->name('news.index');
Route::get('/thong-tin/{name}', [NewsController::class, 'index'])->name('news.show');
Route::get('/{page}', [PageController::class, 'show'])->name('xem-trang');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

