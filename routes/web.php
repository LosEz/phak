<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TestScapingWebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreatePdfController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderBuyController;
use App\Http\Controllers\OrganizationController;

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
        Route::post('/save', [SupplierController::class, 'addEditData']);
        Route::get('/edit/{id}', [SupplierController::class, 'editSupplier']);
    });

    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'index']);
        Route::post('/search', [ContactController::class, 'searchData']);
        Route::post('/addEdit', [ContactController::class, 'addEditData']);
    });

    Route::prefix('buyOrder')->group(function () {
        Route::get('/', [OrderBuyController::class, 'index']);
        Route::post('/search', [OrderBuyController::class, 'searchData']);
        Route::get('/add', [OrderBuyController::class, 'createOrderBuy'])->name('create');
        Route::post('/save', [OrderBuyController::class, 'addData']);
        Route::post('/edit', [OrderBuyController::class, 'editData']);
    });

    Route::prefix('organization')->group(function () {
        Route::get('/', [OrganizationController::class, 'index']);
        Route::get('/edit', [OrganizationController::class, 'editData']);
        Route::post('/save', [OrganizationController::class, 'saveData']);
    });
    
});