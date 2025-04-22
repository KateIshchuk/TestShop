<?php

namespace App\Models;

use App\Enums\DeliveryType;
use App\Enums\OrderStatus;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'delivery_type',
        'payment_type',
        'status',
        'total_price'
    ];
    protected $casts = [
        'delivery_type' => DeliveryType::class,
        'payment_type' => PaymentType::class,
        'status' => OrderStatus::class,
    ];

    public function items()
    {
       return $this->belongsToMany(Product::class,
            'order_items',
            'order_id',
            'product_id')->withPivot('quantity')->withTimestamps();
    }
}
