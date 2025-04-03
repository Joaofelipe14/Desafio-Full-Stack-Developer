<?php

namespace App\Jobs;

use App\Models\Cliente;
use App\Mail\EmailBoasVindasMailable;
use App\Models\ClienteEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EnviarEmailBoasVindasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Cliente $cliente) {}

    public function handle()
    {
        try {
            Mail::to($this->cliente->email)->send(new EmailBoasVindasMailable($this->cliente));
            
            ClienteEmailLog::create([
                'cliente_id' => $this->cliente->id,
                'tipo' => 'boas_vindas',
                'status' => 'enviado',
                'enviado_em' => now(),
            ]);

        } catch (Throwable $e) {
            ClienteEmailLog::create([
                'cliente_id' => $this->cliente->id,
                'tipo' => 'boas_vindas',
                'status' => 'falha: ' . $e->getMessage(),
                'enviado_em' => now(),
            ]);

            throw $e; // Permite retentativas
        }
    }
}