<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TestScapingWebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreatePdfController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scapping', function () {
    return view('scapping');
});


Route::get('/table', function () {
    return view('table');
});

Route::get('/table2', function () {
    return view('table2');
});

Route::get('/stock', function () {
    return view('stock');
});

Route::get('/logout', function () {
    \Session::flush();
    return redirect('/login');
});

Route::get('/pdf', [CreatePdfController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);
Route::post('/checkUser', [LoginController::class, 'loginWeb']);

Route::group(['middleware' => ['haslogin']], function () {

    Route::get('/scaping', [TestScapingWebController::class, 'index']);
    Route::get('scapping/genData', [TestScapingWebController::class, 'genData']);

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/search', [ProductController::class, 'searchData']);
        Route::post('/addEdit', [ProductController::class, 'addEditData']);
    });

    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::post('/search', [SupplierController::class, 'searchData']);
        Route::get('/add', [SupplierController::class, 'createSupplier'])->name('create');
        Route::post('/save', [SupplierController::class, 'addData']);
        Route::get('/edit/{id}', [SupplierController::class, 'editData']);
    });

});