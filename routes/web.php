<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\FormSpController;
use App\Http\Controller\CatatanPelanggaranSantriController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LockScreen;
use App\Http\Controllers\RaporAdabController;


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
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('home');
    });
    Route::get('home',function()
    {
        return view('home');
    });
});

Auth::routes();

// ----------------------------- home dashboard ------------------------------//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// -----------------------------login----------------------------------------//
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ----------------------------- lock screen --------------------------------//
Route::get('lock_screen', [App\Http\Controllers\LockScreen::class, 'lockScreen'])->middleware('auth')->name('lock_screen');
Route::post('unlock', [App\Http\Controllers\LockScreen::class, 'unlock'])->name('unlock');

// ------------------------------ register ---------------------------------//
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'storeUser'])->name('register');

// ----------------------------- forget password ----------------------------//
Route::get('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'getEmail'])->name('forget-password');
Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'postEmail'])->name('forget-password');

// ----------------------------- reset password -----------------------------//
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'getPassword']);
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword']);

// ----------------------------- user profile ------------------------------//
Route::get('profile_user', [App\Http\Controllers\UserManagementController::class, 'profile'])->name('profile_user');
Route::post('profile_user/store', [App\Http\Controllers\UserManagementController::class, 'profileStore'])->name('profile_user/store');

// ----------------------------- user userManagement -----------------------//
Route::get('userManagement', [App\Http\Controllers\UserManagementController::class, 'index'])->middleware('auth')->name('userManagement');
Route::get('user/add/new', [App\Http\Controllers\UserManagementController::class, 'addNewUser'])->middleware('auth')->name('user/add/new');
Route::post('user/add/save', [App\Http\Controllers\UserManagementController::class, 'addNewUserSave'])->name('user/add/save');
Route::get('view/detail/{id}', [App\Http\Controllers\UserManagementController::class, 'viewDetail'])->middleware('auth');
Route::post('update', [App\Http\Controllers\UserManagementController::class, 'update'])->name('update');
Route::get('delete_user/{id}', [App\Http\Controllers\UserManagementController::class, 'delete'])->middleware('auth');
Route::get('activity/log', [App\Http\Controllers\UserManagementController::class, 'activityLog'])->middleware('auth')->name('activity/log');
Route::get('activity/login/logout', [App\Http\Controllers\UserManagementController::class, 'activityLogInLogOut'])->middleware('auth')->name('activity/login/logout');

Route::get('change/password', [App\Http\Controllers\UserManagementController::class, 'changePasswordView'])->middleware('auth')->name('change/password');
Route::post('change/password/db', [App\Http\Controllers\UserManagementController::class, 'changePasswordDB'])->name('change/password/db');

// ----------------------------- form staff ------------------------------//
Route::get('form/staff/new', [App\Http\Controllers\FormController::class, 'index'])->middleware('auth')->name('form/staff/new');
Route::post('form/save', [App\Http\Controllers\FormController::class, 'saveRecord'])->name('form/save');
Route::get('form/view/detail', [App\Http\Controllers\FormController::class, 'viewRecord'])->middleware('auth')->name('form/view/detail');
Route::get('form/view/detail/{id}', [App\Http\Controllers\FormController::class, 'viewDetail'])->middleware('auth');
Route::post('form/view/update', [App\Http\Controllers\FormController::class, 'viewUpdate'])->name('form/view/update');
Route::get('delete/{id}', [App\Http\Controllers\FormController::class, 'viewDelete'])->middleware('auth');

// ----------------------------- Form SP ------------------------------//
Route::get('/pengelolaansp', [App\Http\Controllers\SpController::class, 'index'])->middleware('auth');
Route::get('/pengelolaansp/create', [App\Http\Controllers\SpController::class, 'create'])->middleware('auth');
Route::post('/pengelolaansp/store', [App\Http\Controllers\SpController::class, 'store'])->middleware('auth');
Route::get('/pengelolaansp/{id}/edit', [App\Http\Controllers\SpController::class, 'edit'])->middleware('auth');
Route::put('/pengelolaansp/{id}', [App\Http\Controllers\SpController::class, 'update'])->middleware('auth');
Route::delete('/pengelolaansp/{id}', [App\Http\Controllers\SpController::class, 'destroy'])->middleware('auth');

Route::get('/pengelolaansp/print', [App\Http\Controllers\SpController::class, 'print'])->middleware('auth');

// ----------------------------- Form Catatan Pelanggaran Santri ------------------------------//
Route::get('/pelanggaransantri', [App\Http\Controllers\CatatanPelanggaranSantriController::class, 'index'])->middleware('auth');
Route::get('/pelanggaransantri/create', [App\Http\Controllers\CatatanPelanggaranSantriController::class, 'create'])->middleware('auth');
Route::post('/pelanggaransantri/store', [App\Http\Controllers\CatatanPelanggaranSantriController::class, 'store'])->middleware('auth');
Route::get('/pelanggaransantri/{id}/edit', [App\Http\Controllers\CatatanPelanggaranSantriController::class, 'edit'])->middleware('auth');
Route::put('/pelanggaransantri/{id}', [App\Http\Controllers\CatatanPelanggaranSantriController::class, 'update'])->middleware('auth');
Route::delete('/pelanggaransantri/{id}', [App\Http\Controllers\CatatanPelanggaranSantriController::class, 'destroy'])->middleware('auth');

// ----------------------------- Form Pencatatan Adab dan Ibadah Santri ------------------------------//
Route::get('/pencatatanadabdanibadah', [App\Http\Controllers\CatatanAdabDanIbadahSantriController::class, 'index'])->middleware('auth');
Route::get('/pencatatanadabdanibadah/create', [App\Http\Controllers\CatatanAdabDanIbadahSantriController::class, 'create'])->middleware('auth');
Route::post('/pencatatanadabdanibadah/store', [App\Http\Controllers\CatatanAdabDanIbadahSantriController::class, 'store'])->middleware('auth');
Route::get('/pencatatanadabdanibadah/{id}/edit', [App\Http\Controllers\CatatanAdabDanIbadahSantriController::class, 'edit'])->middleware('auth');
Route::put('/pencatatanadabdanibadah/{id}', [App\Http\Controllers\CatatanAdabDanIbadahSantriController::class, 'update'])->middleware('auth');
Route::delete('/pencatatanadabdanibadah/{id}', [App\Http\Controllers\CatatanAdabDanIbadahSantriController::class, 'destroy'])->middleware('auth');

// ----------------------------  Rapor Adab dan Ibadah  ----------------------------------------------//

// Route::get('/raporadabdanibadah', [App\Http\Controllers\RaporAdabController::class, 'index'])->middleware('auth');
// Route::get('/raporadabdanibadah/create', [App\Http\Controllers\RaporAdabController::class, 'create'])->middleware('auth');
// Route::post('/raporadabdanibadah/store', [App\Http\Controllers\RaporAdabController::class, 'store'])->middleware('auth');
Route::resource('rapor', RaporAdabController::class);





