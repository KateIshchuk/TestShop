<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'stock'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk('public'); // Колекція для зображень товарів
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
