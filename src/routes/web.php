<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;

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

/*
Route::middleware('auth')->group(function () {
     Route::get('/', [AuthController::class, 'index']);
 });
*/

/*
Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'store');
    });
  });
*/
Route::view('/login', 'auth.login');
Route::view('/register', 'auth.register');
Route::post('/register', [AuthController::class,'postRegister']);

 Route::post('/login', [AuthController::class,'postLogin']);

 /* Route::get('/mypage', [AuthController::class,'index']); */
 /* Route::get('/', [shopController::class,'index']); */
 Route::controller(ShopController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/search', 'search')->name('search');
    Route::get('/detail/{shop_id}', 'detail');
});



    Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'destroy');
        Route::get('/mypage', 'index');
    });

    // Favorites
    Route::controller(FavoriteController::class)->group(function () {
        Route::post('/favorite/store/{shop}', 'store')->name('favorite');
        Route::delete('/favorite/destroy/{shop}', 'destroy')->name('unfavorite');
    });
});


/* Route::post('/login', [ShopController::class,'postLogin']); */

/* Route::post('/', [ShopController::class,'index']); */

/*
Route::get('/', function () {
    return view('welcome');
}); */