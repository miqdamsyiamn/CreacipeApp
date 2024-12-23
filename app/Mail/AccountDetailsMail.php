<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->from('noreply@creacipe.com', 'Creacipe')
                    ->subject('Detail Akun Anda')
                    ->view('Email.accountdetails')
                    ->with([
                        'user' => $this->user,
                        'password' => $this->password,
                    ]);
    }
}
