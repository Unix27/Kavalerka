<?php

namespace Customers\Mails;

use Customers\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class CustomerRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->subject('Регистрация');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->customer->email)->view('cabinet::emails.registration');
    }
}
