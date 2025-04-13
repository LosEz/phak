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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;

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

    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::get('/scaping', [TestScapingWebController::class, 'index']);
    Route::get('scapping/genData', [TestScapingWebController::class, 'genData']);

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/search', [ProductController::class, 'searchData']);
        Route::post('/addEdit', [ProductController::class, 'addEditData']);
        Route::get('/add', [ProductController::class, 'pageAdd']);
        Route::get('/edit/{id}', [ProductController::class, 'pageEdit']);
        Route::post('/genCode', [ProductController::class, 'generateCode']);
    });

    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'index']);
        Route::get('/add', [ContactController::class, 'pageAdd']);
        Route::get('/edit/{id}', [ContactController::class, 'pageEdit']);
        Route::post('/search', [ContactController::class, 'searchData']);
        Route::post('/addEdit', [ContactController::class, 'addEditData']);
    });

    Route::prefix('organizes')->group(function () {
        Route::get('/', [OrganizationController::class, 'index']);
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/add', [RoleController::class, 'pageAdd']);
        Route::get('/edit/{id}', [RoleController::class, 'pageEdit']);
        Route::post('/saveAdd', [RoleController::class,'addData']);
        Route::post('/saveEdit', [RoleController::class,'editData']);
        route::post('/search',[RoleController::class, 'searchData']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::post('/search', [UsersController::class, 'searchData']);
        Route::get('/add', [UsersController::class, 'pageAdd']);
        Route::get('/edit/{id}', [UsersController::class, 'pageEdit']);
        Route::post('/save', [UsersController::class, 'addEditData']);
    });
});