<?php

namespace Customers\Listeners;

use Customers\Events\NewCustomer;
use Customers\Events\NewPayment;
use Customers\Mails\CustomerRegistrationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewPaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NewPayment $event
     * @return void
     */
    public function handle(NewPayment $event)
    {

    }
}
