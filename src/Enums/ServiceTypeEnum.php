<?php

declare(strict_types=1);

namespace App\Enums;

enum ServiceTypeEnum: int
{
    case internet = 1;
    case tv = 2;
    case ip = 3;
}
