<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
    use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengantarController;



//auth
Route::get("/", [AuthController::class,'login']);
Route::post("/login",[AuthController::class,'authenthicate']);
Route::post("/logout",[AuthController::class,'logout']);
Route::get("/register", [AuthController::class,'registerView']);
Route::post("/register", [AuthController::class,'register']);

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->Middleware('role:Admin,User,Kepala RT,Kepala RW');


Route::get('/resident',[ResidentController ::class,'index'])->middleware('role:Admin');  
Route::get('/resident/create',[ResidentController ::class,'create'])->middleware('role:Admin');    
Route::get('/resident/{id}',[ResidentController ::class,'edit'])->middleware('role:Admin');    
Route::post('/resident',[ResidentController ::class,'store'])->middleware('role:Admin');  
Route::put('/resident/{id}',[ResidentController ::class,'update'])->middleware('role:Admin');  
Route::delete('/resident/{id}',[ResidentController ::class,'destroy'])->middleware('role:Admin');  

Route::get('/account_list',[userController::class, 'account_list_view'])->middleware('role:Admin');

Route::get('/account-requests',[UserController::class, 'account_requests_view'])->middleware('role:Admin');
Route::post('/account_requests/approval/{id}',[UserController::class, 'account_approval'])->middleware('role:Admin');

Route::get('/profile', [UserController::class, 'profile_view'])->Middleware('role:Admin,User,Kepala RT,Kepala RW,Kepala Desa,Staff Desa');
Route::post('/profile/{id}', [UserController::class, 'update_profile'])->Middleware('role:Admin,User,Kepala RT,Kepala RW,Kepala Desa,Staff Desa');
Route::get('/change_password', [UserController::class, 'change_password_view'])->Middleware('role:Admin,User,Kepala RT,Kepala RW,Kepala Desa,Staff Desa');
Route::post('/change_password/{id}', [UserController::class, 'change_password'])->Middleware('role:Admin,User,Kepala RT,Kepala RW,Kepala Desa,Staff Desa');

Route::prefix('pengantar')->name('pengantar.')->group(function () {
    // Routes umum
    Route::get('/', [PengantarController::class, 'index'])->name('index');
    Route::get('/create', [PengantarController::class, 'create'])->name('create');
    Route::post('/', [PengantarController::class, 'store'])->name('store');
    Route::get('/{pengantar}', [PengantarController::class, 'show'])->name('show');
    Route::get('/{pengantar}/edit', [PengantarController::class, 'edit'])->name('edit');
    Route::put('/{pengantar}', [PengantarController::class, 'update'])->name('update');
    Route::delete('/{pengantar}', [PengantarController::class, 'destroy'])->name('destroy');
    
    // Routes untuk approval
    Route::put('/{pengantar}/process-rt', [PengantarController::class, 'processRT'])->name('process.rt');
    Route::put('/{pengantar}/process-rw', [PengantarController::class, 'processRW'])->name('process.rw');
    
    // Dashboard untuk RT dan RW
    Route::get('/dashboard/rt', [PengantarController::class, 'dashboardRT'])->name('dashboard.rt');
    Route::get('/dashboard/rw', [PengantarController::class, 'dashboardRW'])->name('dashboard.rw');
});

Route::prefix('pengantar')->name('pengantar.')->group(function () {
    Route::get('/', [PengantarController::class, 'index'])->name('index');
    Route::get('/create', [PengantarController::class, 'create'])->name('create');
    Route::post('/', [PengantarController::class, 'store'])->name('store');
    Route::get('/{pengantar}', [PengantarController::class, 'show'])->name('show');
    Route::get('/{pengantar}/edit', [PengantarController::class, 'edit'])->name('edit');
    Route::put('/{pengantar}', [PengantarController::class, 'update'])->name('update');
    Route::delete('/{pengantar}', [PengantarController::class, 'destroy'])->name('destroy');
    
    // PENTING: Ubah PUT ke POST untuk kompatibilitas form
    Route::post('/{pengantar}/update-rt', [PengantarController::class, 'processRT'])->name('update.rt');
    Route::post('/{pengantar}/update-rw', [PengantarController::class, 'processRW'])->name('update.rw');
    
    Route::get('/{id}/detail', [PengantarController::class, 'getDetail'])->name('detail');
});

// Dashboard RT & RW (di luar prefix pengantar)
Route::get('/dashboard-rt', [PengantarController::class, 'dashboardRT'])->name('dashboard.rt');
Route::get('/dashboard-rw', [PengantarController::class, 'dashboardRW'])->name('dashboard.rw');
