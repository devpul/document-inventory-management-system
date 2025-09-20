<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ManageUsers\ManageUsersController;

// Route::get('/', function () {
//     return view('auth.login');
// });

// ====================================== AUTH

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::prefix('auth')->name('auth.')->group(function(){
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register/store', [RegisterController::class, 'store'])->name('register_store');

    Route::post('user/login', [LoginController::class, 'loginUser'])->name('login_store');
    Route::post('admin/login', [LoginController::class, 'loginAdmin'])->name('login_admin');

    Route::post('/user/logout', [LoginController::class, 'logout'])->name('logout');
});

// ====================================== DASHBOARD
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function() {
    Route::get('index/admin', [DashboardController::class, 'index'])->name('index_admin');
    Route::get('index/user', [DashboardController::class, 'index'])->name('index_user');

    // ====================================== DOCUMENTS
    // --------------------- INDEX
    Route::get('documents', [DocumentController::class, 'index'])->name('documents');
    // --------------------- CREATE
    Route::get('document/create',[DocumentController::class, 'create'])->name('document_create');
    Route::post('document/post', [DocumentController::class, 'store'])->name('document_store');
    // --------------------- EDIT
    Route::get('document/edit/{id}/{filename}', [DocumentController::class, 'edit'])->name('document_edit');
    Route::put('document/update/{id}', [DocumentController::class, 'update'])->name('document_update');
    // --------------------- DELETE
    Route::delete('/document/delete/{id}', [DocumentController::class, 'destroy'])->name('document_delete');
    // --------------------- DETAIL
    Route::get('/document/detail/{id}/{filename}', [DocumentController::class, 'detail'])->name('document_detail');
    // --------------------- PREVIEW FILE    
    Route::get('/documents/preview/{id}/{filename}', [DocumentController::class, 'preview'])->name('documents.preview');
    // --------------------- SHARE
    Route::get('/document/sharePage/{id}', [DocumentController::class, 'sharePage'])->name('document_share_page');
    Route::post('/document/share/{id}', [DocumentController::class, 'share'])->name('document_share');
    Route::get('/document/shared_page', [DashboardController::class, 'shared_page'])->name('document_shared_page');
    // --------------------- SEARCH
    Route::get('/documents/search', [DocumentController::class, 'search'])->name('documents.search');
    // --------------------- DOWNLOAD
    Route::get('/document/download/{id}/{filename}', [DocumentController::class, 'download'])->name('document_download');


    // ====================================== MANAGE USER
    Route::get('/manage-users', [ManageUsersController::class, 'index'])->name('manage_users');
    Route::get('/manage-users/detail_user/{id}', [ManageUsersController::class, 'detailUser'])->name('manage_detail_user');
    Route::get('/manage-users/create_user', [ManageUsersController::class, 'create'])->name('manage_create_user');
    Route::post('/manage-user/store_user', [ManageUsersController::class, 'store'])->name('manage_store_user'); 
    Route::get('/manage-users/edit_user/{id}', [ManageUsersController::class, 'edit'])->name(name: 'manage_edit_user');
    Route::put('/manage-users/update_user/{id}', [ManageUsersController::class, 'update'])->name('manage_update_user');
    Route::delete('/manage-users/delete_user/{id}', [ManageUsersController::class, 'drop'])->name('manage_delete_user');
    // routes/web.php
    Route::get('/manage-users/search', [ManageUsersController::class, 'search'])->name('manage_users_search');


}); 

