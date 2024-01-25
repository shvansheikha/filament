<?php

namespace App\Observers;

use App\Enums\BoxKindEnum;
use App\Models\Box;

class RentObserver
{
    public function creating(Box $box): void
    {
        $box->user_id = auth()->id();
        $box->kind = BoxKindEnum::RENT;
    }
}
