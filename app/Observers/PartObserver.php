<?php

namespace App\Observers;

use App\Models\Part;

class PartObserver
{
    public function creating(Part $part): void
    {
        $part->user_id = auth()->id();
    }
}
