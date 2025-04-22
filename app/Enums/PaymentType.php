<?php

namespace App\Enums;

use App\Traits\OptionsTrait;

enum PaymentType: string
{
    use OptionsTrait;
    case COD = 'cod';
    case Online = 'online';

    public function label(): string
    {
        return match($this) {
            self::COD => 'Накладений платіж',
            self::Online => 'Онлайн оплата',
        };
    }
}
