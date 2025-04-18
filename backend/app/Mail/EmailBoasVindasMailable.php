<?php

namespace App\Mail;

use App\Models\Clients;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBoasVindasMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;

    public function __construct(Clients $cliente)
    {
        $this->cliente = $cliente;
    }

    public function build()
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('🎉 Bem-vindo ao ' . config('app.name'))
            ->view('emails.boas-vindas');
    }
}