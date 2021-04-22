<?php

namespace Customers\Events;

use Customers\Models\Customer;
use Customers\Models\CustomerPayment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPayment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customerPayment;

    /**
     * Create a new event instance.
     *
     * @param CustomerPayment $customerPayment
     */
    public function __construct(CustomerPayment $customerPayment)
    {
        $this->customerPayment = $customerPayment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
