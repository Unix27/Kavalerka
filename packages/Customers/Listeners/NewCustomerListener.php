<?php

namespace Customers\Listeners;

use Customers\Events\NewCustomer;
use Customers\Mails\CustomerRegistrationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewCustomerListener
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
     * @param NewCustomer $event
     * @return void
     */
    public function handle(NewCustomer $event)
    {

    }
}
