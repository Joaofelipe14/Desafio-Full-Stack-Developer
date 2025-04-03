<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;

class HuggyWebhookController extends Controller
{
    public function receberWebhook(Request $request)
    {
        Log::info('Webhook recebido:', $request->all());

        if ($request->input('token') !== env('HUGGY_CLIENT_ID')) {
            return response()->json(['erro' => 'Token inválido'], 403);
        }

        if (isset($request->messages['createdCustomer'])) {
            foreach ($request->messages['createdCustomer'] as $clienteData) {
                try {
                    Cliente::create([
                        'nome' => $clienteData['name'],
                        'telefone' => $clienteData['mobile'] ?? null,
                        'email' => $clienteData['email'],
                        'foto' => $clienteData['photo'] ?? null,
                    ]);

                    Log::info('Cliente criado com sucesso:', ['email' => $clienteData['email']]);
                } catch (\Exception $e) {
                    Log::error('Erro ao criar cliente:', [
                        'email' => $clienteData['email'],
                        'erro' => $e->getMessage()
                    ]);
                }
            }
        }

        $tokenWeebhook =env('HUGGY_CLIENT_ID');

        return response( $tokenWeebhook );
    }
}
