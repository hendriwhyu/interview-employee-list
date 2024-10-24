<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\AuthController;
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

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::post('/login', 'signIn')->name('signIn');
    Route::post('/register', 'signUp')->name('signUp');
    Route::delete('/logout', 'logout')->name('logout');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.index');
    Route::resource('employees', EmployeeController::class);
    Route::post('employees/upload', [EmployeeController::class, 'upload'])->name('employees.upload');
});

