<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\DefaultController;
use App\Http\Controllers\Backend\InvoiceController;
use App\Http\Controllers\Backend\PrintInvoiceController;
use App\Http\Controllers\Backend\StockController;

Route::get('/', [FrontendController::class, 'index'])->name('/');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function (){
    Route::name('users.')->prefix('users')->group(function (){
        Route::get('/view', [UserController::class, 'index'])->name('view');
        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    });
    Route::name('profiles.')->prefix('profiles')->group(function (){
        Route::get('/view', [ProfileController::class, 'index'])->name('view');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/password/view', [ProfileController::class, 'password_view'])->name('password.view');
        Route::post('/password/change', [ProfileController::class, 'password_change'])->name('password.change');

    });

    Route::name('suppliers.')->prefix('suppliers')->group(function (){
        Route::get('/view', [SupplierController::class, 'index'])->name('view');
        Route::get('/add', [SupplierController::class, 'add'])->name('add');
        Route::post('/store', [SupplierController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('delete');
    });
    Route::name('customers.')->prefix('customers')->group(function (){
        Route::get('/view', [CustomerController::class, 'index'])->name('view');
        Route::get('/add', [CustomerController::class, 'add'])->name('add');
        Route::post('/store', [CustomerController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('delete');
        Route::get('/credit', [CustomerController::class, 'credit'])->name('credit');
        Route::get('/credit/pdf', [CustomerController::class, 'creditPdf'])->name('credit.pdf');
        Route::get('/invoice/edit/{id}', [CustomerController::class, 'editInvoice'])->name('invoice.edit');
        Route::put('/invoice/update/{id}', [CustomerController::class, 'updateInvoice'])->name('invoice.update');
        Route::get('/invoice/details/pdf/{id}', [CustomerController::class, 'invoiceDetailsPdf'])->name('invoice.details.pdf');
        Route::get('/paid', [CustomerController::class, 'paidCustomer'])->name('paid');
        Route::get('/paid/pdf', [CustomerController::class, 'paidCustomerPdf'])->name('paid.pdf');
    });

    Route::name('units.')->prefix('units')->group(function (){
        Route::get('/view', [UnitController::class, 'index'])->name('view');
        Route::get('/add', [UnitController::class, 'add'])->name('add');
        Route::post('/store', [UnitController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UnitController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('delete');
    });
    Route::name('categories.')->prefix('categories')->group(function (){
        Route::get('/view', [CategoryController::class, 'index'])->name('view');
        Route::get('/add', [CategoryController::class, 'add'])->name('add');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
    });
    Route::name('products.')->prefix('products')->group(function (){
        Route::get('/view', [ProductController::class, 'index'])->name('view');
        Route::get('/add', [ProductController::class, 'add'])->name('add');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
    });

    Route::name('purchases.')->prefix('purchases')->group(function (){
        Route::get('/view', [PurchaseController::class, 'index'])->name('view');
        Route::get('/add', [PurchaseController::class, 'add'])->name('add');
        Route::post('/store', [PurchaseController::class, 'store'])->name('store');
        Route::get('/details/{id}', [PurchaseController::class, 'details'])->name('details');
        Route::get('/pending', [PurchaseController::class, 'pendingList'])->name('pending.list');
        Route::get('/approve/{id}', [PurchaseController::class, 'approve'])->name('approve');
        Route::delete('/delete/{id}', [PurchaseController::class, 'destroy'])->name('delete');
        Route::get('/report', [PurchaseController::class, 'purchaseReport'])->name('report');
        Route::post('/report/pdf', [PurchaseController::class, 'purchaseReportPdf'])->name('report.pdf');
    });

    Route::get('/get/category', [DefaultController::class, 'getCategory'])->name('get_category');
    Route::get('/get/product', [DefaultController::class, 'getProduct'])->name('get_product');
    Route::get('/get/stock', [DefaultController::class, 'getStock'])->name('check_product_stock');
    Route::get('/get/price', [DefaultController::class, 'getPrice'])->name('check_product_price');

    Route::name('invoice.')->prefix('invoice')->group(function (){
        Route::get('/view', [InvoiceController::class, 'index'])->name('view');
        Route::get('/add', [InvoiceController::class, 'add'])->name('add');
        Route::post('/store', [InvoiceController::class, 'store'])->name('store');
        Route::get('/details/{id}', [InvoiceController::class, 'details'])->name('details');
        Route::get('/pending', [InvoiceController::class, 'pendingList'])->name('pending.list');
        Route::get('/approve/{id}', [InvoiceController::class, 'approve'])->name('approve');
        Route::post('/approve/store/{id}', [InvoiceController::class, 'approvalStore'])->name('approval.store');
        Route::delete('/delete/{id}', [InvoiceController::class, 'destroy'])->name('delete');
        Route::get('/print/list', [PrintInvoiceController::class, 'index'])->name('print.list');
        Route::get('/print/{id}', [PrintInvoiceController::class, 'printInvoice'])->name('print');
        Route::get('/daily/report', [PrintInvoiceController::class, 'dailyReport'])->name('daily.report');
        Route::post('/daily/report/pdf', [PrintInvoiceController::class, 'dailyReportPdf'])->name('daily.report.pdf');
    });

    Route::name('stock.')->prefix('stock')->group(function (){
        Route::get('/report', [StockController::class, 'stockReport'])->name('report');
        Route::get('/report/pdf', [StockController::class, 'stockReportPdf'])->name('report.pdf');
        Route::get('/report/supplier/product/wise', [StockController::class, 'stockReportSupplierOrProductWise'])->name('report.supplierOrProductWise');
        Route::post('/report/supplier/wise/pdf', [StockController::class, 'stockReportSupplierWisePdf'])->name('report.supplierWisePdf');
        Route::post('/report/product/wise/pdf', [StockController::class, 'stockReportProductWisePdf'])->name('report.productWisePdf');
    });

    Route::get('/supplier/dashboard', [SupplierController::class, 'supplierDashboard'])->name('supplier.dashboard');
});


