<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Catalog;
use App\Livewire\ProductPage;
use App\Livewire\Cart;
use App\Livewire\Checkout;

Route::get('/', Catalog::class)->name('catalog');
Route::get('/product/{product}', ProductPage::class)->name('product');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::view('/order-success', 'pages.order-success')->name('order.success');
