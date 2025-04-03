<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarEmailBoasVindasJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;
use App\Models\Customers;

class HuggyWebhookController extends Controller
{
    public function receberWebhook(Request $request)
    {
        Log::info('Webhook recebido:', $request->all());

        if ($request->input('token') !== env('TOKEN_HUGGY_WEEBHOOK')) {
            return response()->json(['erro' => 'Token inválido'], 403);
        }

        if (isset($request->messages['createdCustomer'])) {

            foreach ($request->messages['createdCustomer'] as $clienteData) {
                try {
                    $cliente = Customers::create([
                        'name' => $clienteData['name'],
                        'mobile' => $clienteData['mobile'] ?? null,
                        'email' => $clienteData['email'],
                        'url_perfil' => $clienteData['photo'] ?? null,
                    ]);

                    EnviarEmailBoasVindasJob::dispatch($cliente)
                    ->delay(now()->addMinutes(2));
                    Log::info('Cliente criado com sucesso:', ['email' => $clienteData['email']]);
                } catch (\Exception $e) {
                    Log::error('Erro ao criar cliente:', [
                        'email' => $clienteData['email'],
                        'erro' => $e->getMessage()
                    ]);
                }
            }
        }

        $tokenWeebhook =env('TOKEN_HUGGY_WEEBHOOK');

        return response( $tokenWeebhook );
    }
}
