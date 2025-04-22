<?php

namespace App\Enums;

use App\Traits\OptionsTrait;

enum OrderStatus: string
{
    use OptionsTrait;
    case New = 'new';
    case Processing = 'processing';
    case Completed = 'completed';
    public function label(): string
    {
        return match($this) {
            self::New => 'Новий',
            self::Processing => 'В обробці',
            self::Completed => 'Завершений',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::New => 'gray',
            self::Processing => 'orange',
            self::Completed => 'green',
        };
    }
}
