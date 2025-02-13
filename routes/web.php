<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Auth::routes();
// Route::get('/home', [HomeController::class, 'index'])->name('home');

// ROUTE LOGIN
Route::get('/', function () {
    return view('auth.login');
});



// ROUTE DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// ROUTE PRODUK 
Route::get('/product', [ProductController::class, 'index'])->name('product.index'); // liihat data
Route::post('/product/add', [ProductController::class, 'store'])->name('product.store'); // tambah data
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update'); // edit data
Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete'); // hapus data

Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transaction/add', [TransactionController::class, 'store'])->name('transaction.store');
Route::put('/transaction/update/{id}', [TransactionController::class, 'update'])->name('transaction.update');
Route::delete('/transaction/delete/{id}', [TransactionController::class, 'destroy'])->name('transaction.delete');



// ROUTE LAPORAN
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/filter', [ReportController::class, 'filter'])->name('report.filter'); // filter data
Route::get('/report/exportExcel', [ReportController::class, 'exportExcel'])->name('report.exportExcel'); // export excel
Route::get('/report/exportPdf', [ReportController::class, 'exportPdf'])->name('report.exportPdf'); // export pdf