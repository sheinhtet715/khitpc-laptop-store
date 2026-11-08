<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductSpecsController;
use App\Http\Controllers\Admin\ReceiptVerificationController;
use App\Http\Controllers\Admin\AdminInvitationController;

Route::get('/accept-admin-invite/{token}', [AdminInvitationController::class, 'showAcceptForm'])->name('admin.invitation.accept');
Route::post('/accept-admin-invite/{token}', [AdminInvitationController::class, 'processAcceptForm'])->name('admin.invitation.process');

Route::group(['prefix' => 'admin', 'middleware' => AdminMiddleware::class], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin#home');
	//category
    Route::group(['prefix' => 'category'], function () {
        Route::get('list', [CategoryController::class, 'list'])->name('category#list');
        Route::post('create', [CategoryController::class, 'create'])->name('category#create');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('category#update');
    });
	//review
    Route::get('reviews', [AdminController::class, 'reviewList'])->name('review#list');
    Route::get('reviews/delete/{id}', [AdminController::class, 'reviewDelete'])->name('review#delete');
    Route::post('review/feature/{id}', [AdminController::class, 'toggleFeature'])->name('account#reviewFeature');

	//brand
    Route::group(['prefix' => 'brand'], function () {

        Route::get('list', [BrandController::class, 'list'])->name('brand#list');
        Route::post('create', [BrandController::class, 'create'])->name('brand#create');
        Route::get('delete/{id}', [BrandController::class, 'delete'])->name('brand#delete');
        Route::get('edit/{id}', [BrandController::class, 'edit'])->name('brand#edit');
        Route::post('update/{id}', [BrandController::class, 'update'])->name('brand#update');
    });
	//product specs
    Route::group(['prefix' => 'productspecs'], function () {
        Route::get('list', [ProductSpecsController::class, 'list'])->name('productspecs#list');
        Route::post('create', [ProductSpecsController::class, 'create'])->name('productspecs#create');
        Route::get('delete/{id}', [ProductSpecsController::class, 'delete'])->name('productspecs#delete');
        Route::get('edit/{id}', [ProductSpecsController::class, 'edit'])->name('productspecs#edit');
        Route::post('update/{id}', [ProductSpecsController::class, 'update'])->name('productspecs#update');
    });
	//product
    Route::group(['prefix' => 'product'], function () {
        Route::get('list', [ProductController::class, 'list'])->name('product#list');
        Route::post('create', [ProductController::class, 'create'])->name('product#create');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product#edit');
        Route::post('update', [ProductController::class, 'update'])->name('product#update');
    });
	//discount
    Route::group(['prefix' => 'discount'], function () {
        Route::get('list', [DiscountController::class, 'list'])->name('discount#list');
        Route::post('create', [DiscountController::class, 'create'])->name('discount#create');
        Route::get('delete/{id}', [DiscountController::class, 'delete'])->name('discount#delete');
        Route::get('edit/{id}', [DiscountController::class, 'edit'])->name('discount#edit');
        Route::post('update/{id}', [DiscountController::class, 'update'])->name('discount#update');
    });
	//offer
    Route::group(['prefix' => 'offer'], function () {
        Route::get('list', [OfferController::class, 'list'])->name('offer#list');
        Route::post('create', [OfferController::class, 'create'])->name('offer#create');
        Route::get('delete/{id}', [OfferController::class, 'delete'])->name('offer#delete');
        Route::get('edit/{id}', [OfferController::class, 'edit'])->name('offer#edit');
        Route::post('update/{id}', [OfferController::class, 'update'])->name('offer#update');
    });
	//profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('change/password', [ProfileController::class, 'changePasswordPage'])->name('profile#changePasswordPage');
        Route::post('change/password', [ProfileController::class, 'changePassword'])->name('profile#changePassword');

        Route::get('edit', [ProfileController::class, 'editProfile'])->name('profile#edit');
        Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile#update');
    });
	//order
    Route::group(['prefix' => 'orders'], function () {

        Route::get('all', [ReceiptVerificationController::class, 'ordersList'])->name('orders#list');
        Route::get('show/{order}', [ReceiptVerificationController::class, 'orderShow'])->name('orders#show');
        Route::get('receipts', [ReceiptVerificationController::class, 'list'])->name('receipts#list');
        Route::get('receipts/{receipt}', [ReceiptVerificationController::class, 'show'])->name('receipts#show');
        Route::post('receipts/{receipt}/approve', [ReceiptVerificationController::class, 'approve'])->name('receipts#approve');
        Route::post('receipts/{receipt}/reject', [ReceiptVerificationController::class, 'reject'])->name('receipts#reject');
    });
	//report
    Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('admin#salesReport');
    Route::group(['middleware' => SuperAdminMiddleware::class], function () {
	//payment
        Route::group(['prefix' => 'payment'], function () {
            Route::get('list', [PaymentController::class, 'list'])->name('payment#list');
            Route::post('create', [PaymentController::class, 'create'])->name('payment#create');
            Route::get('delete/{id}', [PaymentController::class, 'delete'])->name('payment#delete');
            Route::get('edit/{id}', [PaymentController::class, 'edit'])->name('payment#edit');
            Route::post('update/{id}', [PaymentController::class, 'update'])->name('payment#update');
        });
	//account
        Route::group(['prefix' => 'account'], function () {
            Route::get('create/newAdmin', [AdminController::class, 'createAdminPage'])->name('account#newAccountPage');
            Route::post('create/newAdmin', [AdminController::class, 'createAdmin'])->name('account#newAccount');
            Route::get('admin/list', [AdminController::class, 'adminList'])->name('account#adminList');
            Route::get('admin/delete/{id}', [AdminController::class, 'adminDelete'])->name('account#adminDelete');
            Route::post('admin/change-role/{id}', [AdminController::class, 'changeRole'])->name('account#changeRole');
            Route::get('user/list', [AdminController::class, 'userList'])->name('account#userList');
            Route::get('user/delete/{id}', [AdminController::class, 'userDelete'])->name('account#userDelete');
        });
        Route::get('audit-logs', [AdminController::class, 'auditLogs'])->name('admin#auditLogs');
    });
});
