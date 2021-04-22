<?php

namespace Customers\Mails;

use Customers\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class CustomerPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     * @param string $token
     */
    public function __construct(Customer $customer, string $token)
    {
        $this->customer = $customer;
        $this->token = $token;
        $this->subject('Сброс пароля');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('site::emails.password_reset');
    }
}
