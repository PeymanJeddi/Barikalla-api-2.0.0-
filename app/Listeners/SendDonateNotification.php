<?php

namespace App\Listeners;

use App\Events\DonateProcced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendDonateNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DonateProcced $event): void
    {
        Cache::put($event->key, $event->data, now()->addMinutes(5));
    }
}
