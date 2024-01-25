<?php

namespace App\Observers;

use App\Models\Area;

class AreaObserver
{
    public function creating(Area $location): void
    {
        $location->user_id = auth()->id();
    }
}
