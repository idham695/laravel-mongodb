<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::group(['middleware' => ['jwt.verify']], function () {
    // Route::post('refresh', [UserController::class, 'refresh']);
    // Route::post('logout', [UserController::class, 'logout']);
    Route::prefix('barang')->group(function() {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/store', [BarangController::class, 'store']);
    });
});
