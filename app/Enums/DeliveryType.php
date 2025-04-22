<?php

namespace App\Enums;

use App\Traits\OptionsTrait;

enum DeliveryType: string
{
    use OptionsTrait;
    case Pickup = 'pickup';
    case Post = 'post';

    public function label(): string
    {
        return match($this) {
            self::Pickup => 'Самовивіз',
            self::Post => 'Пошта',
        };
    }
}
