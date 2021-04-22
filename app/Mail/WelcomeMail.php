<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable {
	use Queueable, SerializesModels;
	public $data;

	public function __construct($data){
		$this->data = $data;
	}

	public function build(){
		$subject = 'Welcome';
		return $this->view('emails.welcome')->subject($subject);

	}
}
