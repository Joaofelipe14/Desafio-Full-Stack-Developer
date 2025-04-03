<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Cliente; // Alterado de User para Cliente
use App\Models\Clients;
use App\Models\Customers;

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