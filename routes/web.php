<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LogoutController;
use App\Livewire\Crs\CrsCreate;
use App\Livewire\Crs\CrsEdit;
use App\Livewire\Crs\CrsLists;
use App\Livewire\Member\MemberLists;
use App\Livewire\Ntfy\NtfyCreate;
use App\Livewire\Ntfy\NtfyEdit;
use App\Livewire\Ntfy\NtfyLists;
use App\Livewire\User\UserEdit;
use App\Livewire\User\UserEditPassword;
use Illuminate\Support\Facades\Route;

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


Route::get('/', IndexController::class)->middleware(['auth','role:Admin|Member' , 'verified'])->name('index');;

Route::group(['middleware' => ['auth', 'role:Admin|Member']], function() {

    Route::get('/member-edit', UserEdit::class)->name('member-edit');
    Route::get('/member-edit-password', UserEditPassword::class)->name('member-edit-password');

    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');

 });

Route::group(['middleware' => ['auth', 'role:Admin|Member', 'permission:สมาชิก']], function() {
    Route::get('/members', MemberLists::class)->name('member-lists');
 });
Route::group(['middleware' => ['auth', 'role:Admin|Member', 'permission:จองรถ']], function() {
    Route::get('/car', CrsLists::class)->name('crs-lists');
    Route::get('/crs/create', CrsCreate::class)->name('crs-create');
    Route::get('/crs/edit/{id}', CrsEdit::class)->name('crs-edit');
 });

Route::group(['middleware' => ['auth', 'role:Admin|Member', 'permission:แจ้งเตือน']], function() {
    Route::get('/ntfy', NtfyLists::class)->name('ntfy-lists');
    Route::get('/ntfy-create', NtfyCreate::class)->name('ntfy-create');
 });
Route::group(['middleware' => ['auth', 'role:Admin', 'permission:แจ้งเตือน']], function() {
    Route::get('/ntfy-create', NtfyCreate::class)->name('ntfy-create');
    Route::get('/ntfy-edit/{id}', NtfyEdit::class)->name('ntfy-edit');
 });






Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
