<?php

namespace App\Enums;

use App\Traits\EnumsHelperTrait;

enum BoxKindEnum: int
{
    use EnumsHelperTrait;

    case SELL = 0;
    case RENT = 1;
}
