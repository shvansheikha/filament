<?php

namespace App\Observers;

use App\Models\Type;

class TypeObserver
{
    public function creating(Type $type): void
    {
        $type->user_id = auth()->id();
    }
}
