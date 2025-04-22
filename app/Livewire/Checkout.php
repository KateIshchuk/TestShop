<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Enums\DeliveryType;
use App\Enums\PaymentType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $deliveryType = DeliveryType::Pickup->value;
    public string $paymentType = PaymentType::COD->value;

    protected function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'required',
            'deliveryType' => 'required',
            'paymentType' => 'required',
        ];
    }
    public function getDeliveryOptionsProperty(): array
    {
        return DeliveryType::options();
    }

    public function getPaymentOptionsProperty(): array
    {
        return PaymentType::options();
    }
    public function placeOrder()
    {
        $this->validate();

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            session()->flash('error', 'Ваш кошик порожній.');
            return;
        }

        try {
            DB::transaction(function () use ($cart) {
                $total = 0;

                $order = Order::create([
                    'customer_name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'delivery_type' => $this->deliveryType,
                    'payment_type' => $this->paymentType,
                    'total_price' => 0,
                ]);

                foreach ($cart as $productId => $qty) {
                    $product = Product::where('id', $productId)->lockForUpdate()->first();

                    if (!$product || $product->stock < $qty) {
                        throw new \Exception("Недостатньо товару: {$product?->name}");
                    }

                    $product->stock -= $qty;
                    $product->save();

                    $total += $product->price * $qty;

                    $order->items()->attach($product->id,['quantity' => $qty]);
                }

                $order->update(['total_price' => $total]);

                session()->forget('cart');
            });

            return redirect()->route('order.success');

        } catch (\Throwable $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout')
            ->extends('layouts.app')
            ->section('content');
    }
}

