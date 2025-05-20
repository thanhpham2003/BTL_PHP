<?php

use App\Http\Controllers\Admin\AboutAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\InfoAdminController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FrontEnd\LoginController;
use App\Http\Controllers\Admin\MainAdminController;
use App\Http\Controllers\Admin\MenuAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\Users\LoginAdminController;
use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\FrontEnd\AboutController;
use App\Http\Controllers\FrontEnd\ContactController;
use App\Http\Controllers\FrontEnd\MainController;
use App\Http\Controllers\FrontEnd\MenuController;
use App\Http\Controllers\FrontEnd\PayController;
use App\Http\Controllers\FrontEnd\ProductController;
use App\Http\Controllers\FrontEnd\ReviewController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\FrontEnd\OrderController;

//admin
Route::get('admin/users/login', [LoginAdminController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginAdminController::class, 'store']);

Route::middleware(['auth'])->group(function(){

    Route::prefix('admin')->group(function(){
        Route::get('/', [MainAdminController::class, 'index'])-> name('admin');
        Route::get('/main', [MainAdminController::class, 'index']);

        Route::prefix('menus')->group(function(){
            Route::get('add', [MenuAdminController::class, 'create']);
            Route::post('add', [MenuAdminController::class, 'store']);
            Route::get('list', [MenuAdminController::class, 'index']);
            Route::get('edit/{menu}', [MenuAdminController::class, 'show']);
            Route::post('edit/{menu}', [MenuAdminController::class, 'update']);
            Route::delete('destroy', [MenuAdminController::class, 'destroy']);
        });
        
        Route::prefix('products')->group(function(){
            Route::get('add', [ProductAdminController::class, 'create'])->name("admin.product.list");
            Route::post('add', [ProductAdminController::class, 'store']);
            Route::get('list', [ProductAdminController::class, 'index']);
            Route::get('edit/{product}', [ProductAdminController::class, 'show']);
            Route::post('edit/{product}', [ProductAdminController::class, 'update']);
            Route::delete('destroy', [ProductAdminController::class, 'destroy']);
        });

        Route::post('upload/service', [UploadController::class, 'store']);

        Route::prefix('sliders')->group(function(){
            Route::get('add', [SliderController::class, 'create'])->name("admin.slider.create");
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index'])->name("admin.slider.list");
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::delete('destroy', [SliderController::class, 'destroy']);
        });

        Route::prefix('abouts')->group(function(){
            Route::get('add', [AboutAdminController::class, 'create'])->name("admin.about.create");
            Route::post('add', [AboutAdminController::class, 'store']);
            Route::get('list', [AboutAdminController::class, 'index'])->name("admin.about.list");
            Route::get('edit/{about}', [AboutAdminController::class, 'show']);
            Route::post('edit/{about}', [AboutAdminController::class, 'update']);
            Route::delete('destroy', [AboutAdminController::class, 'destroy']);
        });

        Route::prefix('infos')->group(function(){
            Route::get('show', [InfoAdminController::class, 'index'])->name("admin.info");
            Route::post('edit/{info}', [InfoAdminController::class, 'update'])->name("admin.info.update");
        });

        Route::prefix('contacts')->group(function(){
            Route::get('pending', [ContactAdminController::class, 'pending'])->name("admin.contact.pending");
            Route::get('replied', [ContactAdminController::class, 'replied'])->name("admin.contact.replied");
            Route::post('mark-as-replied/{id}', [ContactAdminController::class, 'markAsReplied'])->name("admin.contact.markAsReplied");
            Route::delete('destroy', [ContactAdminController::class, 'destroy'])->name("admin.contact.destroy");
        });

        Route::prefix('reviews')->group(function(){
            Route::get('pending', [ReviewAdminController::class, 'pending'])->name("admin.review.pending");
            Route::get('replied', [ReviewAdminController::class, 'replied'])->name("admin.review.replied");
            Route::post('mark-as-replied/{id}', [ReviewAdminController::class, 'markAsReplied'])->name("admin.review.markAsReplied");
            Route::delete('destroy', [ReviewAdminController::class, 'destroy'])->name("admin.review.destroy");
        });

        Route::prefix('orders')->group(function(){
            Route::get('pending', [OrderAdminController::class, 'pending'])->name("admin.order.pending");

            Route::get('processing', [OrderAdminController::class, 'processing'])->name("admin.order.processing");
            Route::post('mark-as-processing/{id}', [OrderAdminController::class, 'markAsProcessing'])->name("admin.order.markAsProcessing");

            Route::get('shipped', [OrderAdminController::class, 'shipped'])->name("admin.order.shipped");
            Route::post('mark-as-shipped/{id}', [OrderAdminController::class, 'markAsShipped'])->name("admin.order.markAsShipped");

            Route::get('completed', [OrderAdminController::class, 'completed'])->name("admin.order.completed");
            Route::post('mark-as-completed/{id}', [OrderAdminController::class, 'markAsCompleted'])->name("admin.order.markAsCompleted");

            Route::get('canceled', [OrderAdminController::class, 'canceled'])->name("admin.order.canceled");
            Route::post('mark-as-canceled/{id}', [OrderAdminController::class, 'markAsCanceled'])->name("admin.order.markAsCanceled");

        });
        
    });

});


//client
Route::get("/", [MainController::class, "index"])->name("fr.homepage");

Route::prefix("product")->group(function(){
    Route::get("", [ProductController::class, "index"])->name("fr.product");
    Route::get("/show-modal-detail/{id}", [ProductController::class, "showDetailInPopup"])->name("fr.product.show_modal_detail");
    Route::get("detail/{productID}", [ProductController::class, "detail"])->name("fr.product.detail");
    Route::get('/product/filter', [ProductController::class, 'filter'])->name('fr.product.filter');
});


Route::get("about", [AboutController::class, "index"])->name("fr.about");

Route::prefix('contact')->group(function(){
    Route::get("", [ContactController::class, "index"])->name("fr.contact");
    Route::post("send", [ContactController::class, "store"])->name("fr.contact.send");
});

Route::get("pay", [PayController::class, "index"])->name("fr.pay");

Route::get("login", [LoginController::class, "index"])->name("fr.login");
Route::post("login", [LoginController::class, "login"])->name("fr.post.login");
Route::get("register", [LoginController::class, "show"])->name("fr.register");
Route::post("register", [LoginController::class, "register"])->name("fr.post.register");
Route::post('/logout', [LoginController::class, 'logout'])->name('fr.logout');

Route::middleware(['auth:frontend'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::prefix('/cart')->group(function(){
        Route::get("", [CartController::class, "viewCart"])->name("cart.view");
        Route::post("/order", [OrderController::class, "store"])->name("fr.order");
    });
    Route::post('/review', [ReviewController::class, 'send'])->name('fr.review.send');
});
