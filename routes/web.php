<?php

use App\Http\Controllers\Admin\EmployeeController;
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

Route::get('/', function () {
    return view('admin.index');
})->name('admin.index');

Route::resource('admin/employees', EmployeeController::class);
Route::post('admin/employees/upload', [EmployeeController::class, 'upload'])->name('employees.upload');
