<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionPurchaseController;
use App\Http\Controllers\TransactionSaleController;
use App\Http\Controllers\ReportPurchaseController;
use App\Http\Controllers\ReportSaleController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;

Auth::routes();
// Route::get('/home', [HomeController::class, 'index'])->name('home');

// ROUTE LOGIN
Route::get('/', function () {
    return view('auth.login');
});



// ROUTE DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// ROUTE MEREK 
Route::get('/brand', [BrandController::class, 'index'])->name('brand.index'); // liihat data
Route::post('/brand/add', [BrandController::class, 'store'])->name('brand.store'); // tambah data
Route::put('/brand/update/{id}', [BrandController::class, 'update'])->name('brand.update'); // edit data
Route::delete('/brand/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete'); // hapus data


// ROUTE KATEGORI 
Route::get('/category', [CategoryController::class, 'index'])->name('category.index'); // liihat data
Route::post('/category/add', [CategoryController::class, 'store'])->name('category.store'); // tambah data
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update'); // edit data
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete'); // hapus data


// ROUTE PRODUK 
Route::get('/product', [ProductController::class, 'index'])->name('product.index'); // liihat data
Route::post('/product/add', [ProductController::class, 'store'])->name('product.store'); // tambah data
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update'); // edit data
Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete'); // hapus data


// ROUTE TRANSAKSI PEMBELIAN
Route::get('/transaction_purchase', [TransactionPurchaseController::class, 'index'])->name('transaction_purchase.index');
Route::post('/transaction_purchase/add', [TransactionPurchaseController::class, 'store'])->name('transaction_purchase.store');
Route::put('/transaction_purchase/update/{id}', [TransactionPurchaseController::class, 'update'])->name('transaction_purchase.update');
Route::delete('/transaction_purchase/delete/{id}', [TransactionPurchaseController::class, 'destroy'])->name('transaction_purchase.delete');
Route::get('/transaction_purchase/invoice/{id}', [TransactionPurchaseController::class, 'invoice'])->name('transaction_purchase.invoice');



// ROUTE TRANSAKSI PENJUALAN
Route::get('/transaction_sale', [TransactionSaleController::class, 'index'])->name('transaction_sale.index');
Route::post('/transaction_sale/add', [TransactionSaleController::class, 'store'])->name('transaction_sale.store');
Route::put('/transaction_sale/update/{id}', [TransactionSaleController::class, 'update'])->name('transaction_sale.update');
Route::delete('/transaction_sale/delete/{id}', [TransactionSaleController::class, 'destroy'])->name('transaction_sale.delete');
Route::get('/transaction_sale/invoice/{id}', [TransactionSaleController::class, 'invoice'])->name('transaction_sale.invoice');




// ROUTE LAPORAN PEMBELIAN
Route::get('/report_purchase', [ReportPurchaseController::class, 'index'])->name('report_purchase.index');
Route::get('/report_purchase/filter', [ReportPurchaseController::class, 'filter'])->name('report_purchase.filter'); // filter data
Route::get('/report_purchase/exportExcel', [ReportPurchaseController::class, 'exportExcel'])->name('report_purchase.exportExcel'); // export excel
Route::get('/report_purchase/exportPdf', [ReportPurchaseController::class, 'exportPdf'])->name('report_purchase.exportPdf'); // export pdf


// ROUTE LAPORAN PENJUALAN
Route::get('/report_sale', [ReportSaleController::class, 'index'])->name('report_sale.index');
Route::get('/report_sale/filter', [ReportSaleController::class, 'filter'])->name('report_sale.filter'); // filter data
Route::get('/report_sale/exportExcel', [ReportSaleController::class, 'exportExcel'])->name('report_sale.exportExcel'); // export excel
Route::get('/report_sale/exportPdf', [ReportSaleController::class, 'exportPdf'])->name('report_sale.exportPdf'); // export pdf