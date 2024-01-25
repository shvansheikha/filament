<?php

namespace App\Providers;

use App\Models\Box;
use App\Models\Area;
use App\Models\Part;
use App\Models\Rent;
use App\Models\Tag;
use App\Models\Type;
use App\Observers\BoxObserver;
use App\Observers\AreaObserver;
use App\Observers\PartObserver;
use App\Observers\RentObserver;
use App\Observers\TagObserver;
use App\Observers\TypeObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        Box::class => BoxObserver::class,
        Type::class => TypeObserver::class,
        Area::class => AreaObserver::class,
        Tag::class => TagObserver::class,
        Rent::class => RentObserver::class,
        Part::class => PartObserver::class,
    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
