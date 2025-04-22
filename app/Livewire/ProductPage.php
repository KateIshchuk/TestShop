<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductPage extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        $cart = session()->get('cart', []);

        $currentQty = $cart[$this->product->id] ?? 0;

        if ($currentQty >= $this->product->stock) {
            session()->flash('error', 'Недостатньо товару на складі!');
            return;
        }

        $cart[$this->product->id] = $currentQty + 1;

        session()->put('cart', $cart);
        session()->flash('success', 'Товар додано до кошика!');
    }


    public function render()
    {
        return view('livewire.product-page')
        ->extends('layouts.app')
        ->section('content');
    }
}
