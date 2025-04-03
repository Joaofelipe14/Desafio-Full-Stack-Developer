<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class ChamadasController extends Controller
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function iniciarLigacao(Request $request)
    {
        $request->validate([
            'destino' => 'required|string'
        ]);

        try {
            $chamada = $this->twilio->calls->create(
                '+5599981708802',
                env('TWILIO_PHONE_NUMBER'),
                [
                    'url' => route('twilio.conectar') . '?To=' . urlencode($request->input('destino'))
                ]
            );

            return response()->json([
                'mensagem' => 'Chamada iniciada!',
                'call_sid' => $chamada->sid
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'erro' => 'Falha ao iniciar a chamada',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }

    public function conectarUsuarios(Request $request)
    {
        $numeroDestino = $request->query('To');
    
        return response("<?xml version='1.0' encoding='UTF-8'?>
            <Response>
                <Dial>
                    <Number>{$numeroDestino}</Number>
                </Dial>
            </Response>", 200)
            ->header('Content-Type', 'text/xml');
    }
}
