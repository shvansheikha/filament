<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver
{
    public function creating(Tag $tag): void
    {
        $tag->user_id = auth()->id();
    }
}
