<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartTotalCalculated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cartId;

    /**
     * Create a new event instance.
     *s
     * @param  int  $cartId
     * @param  float  $total
     * @return void
     */
    public function __construct($cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
