<?php

namespace App\Listeners;

use App\Events\CartTotalCalculated;
use Illuminate\Support\Facades\Log;

class LogCartTotalCalculated
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
    public function handle(CartTotalCalculated $event): void
    {
        Log::channel('event')->info('Sepet Toplamı Hesaplandı:', [
            'cart_id' => $event->cartId
        ]);
    }
}
