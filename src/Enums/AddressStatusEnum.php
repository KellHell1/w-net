<?php

declare(strict_types=1);

namespace App\Enums;

enum AddressStatusEnum: int
{
    case active = 1;
    case disabled = 2;
}
