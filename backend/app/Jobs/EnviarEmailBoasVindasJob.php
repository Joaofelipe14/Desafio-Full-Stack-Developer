<?php

namespace App\Jobs;

use App\Models\Cliente;
use App\Mail\EmailBoasVindasMailable;
use App\Models\ClienteEmailLog;
use App\Models\Customers;
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

    public function __construct(public Customers $customer) {}

    public function handle()
    {
        try {
            Mail::to($this->customer->email)->send(new EmailBoasVindasMailable($this->customer));
            
            ClienteEmailLog::create([
                'customer_id' => $this->customer->id,
                'type' => 'boas_vindas',
                'status' => 'enviado',
                'sent_in' => now(),
            ]);

        } catch (Throwable $e) {
            ClienteEmailLog::create([
                'customer_id' => $this->customer->id,
                'type' => 'boas_vindas',
                'status' => 'falha: ' . $e->getMessage(),
                'sent_in' => now(),
            ]);

            throw $e; // Permite retentativas
        }
    }
}