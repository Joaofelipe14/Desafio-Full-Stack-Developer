<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnviarWebhookClienteCriado implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cliente;

    public function __construct($cliente)
    {
        $this->cliente = $cliente;
    }

    public function handle()
    {
        try {
            $url = env('WEBHOOK_CLIENTE_CRIADO');
            $token = env('WEBHOOK_SECRET');

            $response = Http::retry(5, 2000)->post($url, [
                'id' => $this->cliente->id,
                'nome' => $this->cliente->nome,
                'cpf' => $this->cliente->cpf,
                'email' => $this->cliente->email,
                'data_nascimento' => $this->cliente->data_nascimento,
                'cidade_id' => $this->cliente->cidade_id,
                'criado_em' => $this->cliente->created_at,
                'token' => $token
            ]);

            if ($response->failed()) {
                Log::error('Erro no webhook', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Falha ao enviar webhook');
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar webhook:', ['erro' => $e->getMessage()]);
            $this->release(10); 
        }
    }
}
