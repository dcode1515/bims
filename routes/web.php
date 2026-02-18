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
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
Route::get('/profile/{id}', [App\Http\Controllers\Auth\AuthController::class, 'showProfile'])->name('profile.show');
/* End Login Routes */

/* Super Admin Routes */
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'admin'])->name('admin.dashboard');
Route::get('/barangay/info', [App\Http\Controllers\Admin\AdminController::class, 'barangay_info'])->name('brgy.info');
Route::get('/get-regions', [App\Http\Controllers\Admin\AdminController::class, 'index']);
Route::get('/get-provinces/{region_id}', [App\Http\Controllers\Admin\AdminController::class, 'getProvinces']);
Route::get('/get-municipalities/{province_id}',  [App\Http\Controllers\Admin\AdminController::class, 'getMunicipalities']);
Route::get('/get-barangays/{municipality_id}', [App\Http\Controllers\Admin\AdminController::class, 'getBarangays']);
Route::post('/api/store/barangay/info', [App\Http\Controllers\Admin\AdminController::class, 'store_barangay_info']);
Route::get('/api/get/data/barangay/info', [App\Http\Controllers\Admin\AdminController::class, 'getBarangayInfo']);
Route::post('/api/update/barangay/info/{id}', [App\Http\Controllers\Admin\AdminController::class, 'update_barangay_info']);
Route::get('/user/management', [App\Http\Controllers\Admin\AdminController::class, 'user_management'])->name('user.management');
Route::get('/api/get/data/barangay/user', [App\Http\Controllers\Admin\AdminController::class, 'getDataBarangay']);
Route::post('/api/store/barangay/user', [App\Http\Controllers\Admin\AdminController::class, 'store_barangay_user']);
Route::get('/api/get/data/active/user', [App\Http\Controllers\Admin\AdminController::class, 'getDataUserActive']);
Route::post('/api/update/barangay/user/{id}', [App\Http\Controllers\Admin\AdminController::class, 'update_barangay_user']);
/* End Super Admin Routes */


/*Admin Routes */
Route::get('/barangay/dashboard', [App\Http\Controllers\Barangay\BarangayController::class, 'dashboard_barangay'])->name('dashboard.admin');
Route::get('/purok', [App\Http\Controllers\Barangay\BarangayController::class, 'purok'])->name('purok');
Route::post('/api/store/purok', [App\Http\Controllers\Barangay\BarangayController::class, 'store_purok']);
Route::get('/api/get/data/purok', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataPurok']);
Route::post('/api/update/purok/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_purok']);
Route::delete('/api/delete/purok/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'delete_purok']);
Route::get('/barangay/official', [App\Http\Controllers\Barangay\BarangayController::class, 'barangay_official'])->name('barangay.official');

Route::get('/barangay/position', [App\Http\Controllers\Barangay\BarangayController::class, 'barangay_position'])->name('position');
Route::post('/api/store/position', [App\Http\Controllers\Barangay\BarangayController::class, 'store_position']);
Route::get('/api/get/data/position', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataPosition']);
Route::post('/api/update/position/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_position']);
Route::delete('/api/delete/position/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'delete_position']);
Route::get('/barangay/commitee', [App\Http\Controllers\Barangay\BarangayController::class, 'barangay_commitee'])->name('barangay.commitee');
Route::post('/api/store/commitee', [App\Http\Controllers\Barangay\BarangayController::class, 'store_commitee']);
Route::get('/api/get/data/commitee', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataCommitee']);
Route::post('/api/update/commitee/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_commitee']);
Route::delete('/api/delete/commitee/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'delete_commitee']);
Route::get('/api/get/data/barangay/official', [App\Http\Controllers\Barangay\BarangayController::class, 'getDatabrangayOfficial']);
Route::get('/api/get/data/commitees', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataCommiteesDropdown']);
Route::post('/api/store/official', [App\Http\Controllers\Barangay\BarangayController::class, 'store_barangay_official']);
Route::get('/api/get/data/all/barangay/official', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataBarangayOfficial']);
Route::post('/api/update/official/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_barangay_official']);
Route::get('/household', [App\Http\Controllers\Barangay\BarangayController::class, 'household'])->name('household');
Route::get('/create/member', [App\Http\Controllers\Barangay\BarangayController::class, 'create_member'])->name('create.member');
Route::post('/api/households/store', [App\Http\Controllers\Barangay\BarangayController::class, 'store_household']);
Route::get('/api/get/data/purok-per-household', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataPurokPerHousehold']);
Route::get('/api/get/data/household', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataHousehold']);
Route::get('/household/edit/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'edit_household']);
Route::put('/api/update/households/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_household']);
Route::get('/household/view/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'view_household']);
Route::get('/blotter', [App\Http\Controllers\Barangay\BarangayController::class, 'blotter'])->name('blotter');
Route::post('/api/blotter/store', [App\Http\Controllers\Barangay\BarangayController::class, 'store_blotter']);
Route::get('/api/get/data/blotter', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataBlotter']);
Route::put('/api/blotter/update/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_blotter']);
Route::get('/certification', [App\Http\Controllers\Barangay\BarangayController::class, 'certification'])->name('certification');
Route::get('/manage/barangay/clearance', [App\Http\Controllers\Barangay\BarangayController::class, 'manage_barangay_clearance']);
Route::post('/api/store/barangay/clearance', [App\Http\Controllers\Barangay\BarangayController::class, 'store_barangay_clearance']);
Route::get('/api/get/data/barangay/clearance', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataBarangayClearance']);
Route::put('/api/update/barangay/clearance/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_barangay_clearance']);
Route::get('/api/get/data/inhabitans/clearance', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataInhabitansCertification']);
Route::get('/print/barangay/clearance/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'print_barangay_clearance']);
Route::get('/manage/building/permit', [App\Http\Controllers\Barangay\BarangayController::class, 'manage_building_permit']);
Route::post('/api/store/building/permit', [App\Http\Controllers\Barangay\BarangayController::class, 'store_building_permit']);
Route::get('/api/get/data/building/permit', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataBuildingPermit']);
Route::put('/api/update/building/permit/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_buildingy_permit']);
Route::get('/print/building/permit/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'print_building_permit']);
Route::get('/manage/certificate/indigency', [App\Http\Controllers\Barangay\BarangayController::class, 'manage_certificate_indigency']);
Route::post('/api/store/certificate/indigency', [App\Http\Controllers\Barangay\BarangayController::class, 'store_certificate_indigency']);
Route::get('/api/get/data/certificate/indigency', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataIndigency']);
Route::put('/api/update/certificate/indigency/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_certificate_indigency']);
Route::get('/print/certificate/indigency/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'print_certificate_indigency']);
Route::post('/api/update/profile/{id}', [App\Http\Controllers\Auth\AuthController::class, 'update_profile']);
Route::post('/api/update/user/credential/{id}', [App\Http\Controllers\Auth\AuthController::class, 'update_user_credentials']);
Route::get('/manage/death/certificate', [App\Http\Controllers\Barangay\BarangayController::class, 'manage_death_certificate']);
Route::post('/api/store/death/certificate', [App\Http\Controllers\Barangay\BarangayController::class, 'store_death_cert']);
Route::get('/api/get/data/death/certificate', [App\Http\Controllers\Barangay\BarangayController::class, 'getDataDeathCertificate']);
Route::put('/api/update/death/indigency/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'update_death_certificate']);
Route::get('/print/death/certificate/{id}', [App\Http\Controllers\Barangay\BarangayController::class, 'print_death_certification']);


/*End Admin Routes */