<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public array $cartItems = [];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $sessionCart = session()->get('cart', []);

        $this->cartItems = [];

        foreach ($sessionCart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $this->cartItems[$productId] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }
    }

    public function increment($productId)
    {
        if (!isset($this->cartItems[$productId])) return;

        $product = $this->cartItems[$productId]['product'];

        if ($this->cartItems[$productId]['quantity'] < $product->stock) {
            $this->cartItems[$productId]['quantity']++;
            $this->updateSessionCart();
        }
    }

    public function decrement($productId)
    {
        if (!isset($this->cartItems[$productId])) return;

        if ($this->cartItems[$productId]['quantity'] > 1) {
            $this->cartItems[$productId]['quantity']--;
            $this->updateSessionCart();
        }
    }

    public function remove($productId)
    {
        unset($this->cartItems[$productId]);
        $this->updateSessionCart();
    }

    public function updateSessionCart()
    {
        $cart = [];
        foreach ($this->cartItems as $productId => $item) {
            $cart[$productId] = $item['quantity'];
        }
        session()->put('cart', $cart);
    }

    public function getTotal()
    {
        return collect($this->cartItems)->sum(fn($item) => $item['product']->price * $item['quantity']);
    }

    public function render()
    {
        return view('livewire.cart')
            ->extends('layouts.app')
            ->section('content');
    }
}

