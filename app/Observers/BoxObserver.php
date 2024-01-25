<?php

namespace App\Observers;

use App\Enums\BoxKindEnum;
use App\Models\Box;

class BoxObserver
{
    public function creating(Box $box): void
    {
        $box->user_id = auth()->id();
        $box->kind = BoxKindEnum::SELL;
    }
}
