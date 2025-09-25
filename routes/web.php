<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
    use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;



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