<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $birthday;
    public $email;
    public $phone;
    public $permis;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $birthday, $email, $phone, $permis)
    {
        $this->name = $name;
        $this->birthday = $birthday;
        $this->email = $email;
        $this->phone = $phone;
        $this->permis = $permis;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('administrateur@pmt.com')
                    ->markdown('emails.complete');
    }
}
