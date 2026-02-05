<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

/* Login Routes */
Route::get('/', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Route::post('/api/login', [App\Http\Controllers\Auth\AuthController::class, 'post_login']);
/* End Login Routes */


Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'admin'])->name('admin.dashboard');
Route::get('/barangay/info', [App\Http\Controllers\Admin\AdminController::class, 'barangay_info'])->name('brgy.info');
Route::get('/get-regions', [App\Http\Controllers\Admin\AdminController::class, 'index']);
Route::get('/get-provinces/{region_id}', [App\Http\Controllers\Admin\AdminController::class, 'getProvinces']);
Route::get('/get-municipalities/{province_id}',  [App\Http\Controllers\Admin\AdminController::class, 'getMunicipalities']);
Route::get('/get-barangays/{municipality_id}', [App\Http\Controllers\Admin\AdminController::class, 'getBarangays']);
Route::post('/api/store/barangay/info', [App\Http\Controllers\Admin\AdminController::class, 'store_barangay_info']);
Route::get('/api/get/data/barangay/info', [App\Http\Controllers\Admin\AdminController::class, 'getBarangayInfo']);
Route::post('/api/update/barangay/info/{id}', [App\Http\Controllers\Admin\AdminController::class, 'update_barangay_info']);
