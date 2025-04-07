<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request 
     * @return \Illuminate\Http\Response
     */
    public function Call(Request $request)
    {
        $request->validate([
            'from' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
        ]);

        $from = $request->input('from');
        $frase = "
            O Senhor é o meu pastor, nada me faltará.
            Ele me faz repousar em pastos verdejantes.
            Leva-me para junto das águas de descanso.
            Refrigera a minha alma.
            Guia-me pelas veredas da justiça por amor do seu nome.
            
            Ainda que eu ande pelo vale da sombra da morte,
            não temerei mal algum, porque tu estás comigo.
            O teu bordão e o teu cajado me consolam.
            
            Preparas-me uma mesa na presença dos meus adversários,
            unges-me a cabeça com óleo, o meu cálice transborda.
            
            Certamente que a bondade e a misericórdia me seguirão
            todos os dias da minha vida,
            e habitarei na casa do Senhor para todo o sempre.
            
            Salmo 23 - Bíblia Sagrada
        ";

        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $authToken);

        try {
            $call = $client->calls->create(
                $from,
                $twilioNumber,
                [
                    'twiml' => "<Response><Say language='pt-BR'>{$frase}</Say></Response>"
                ]
            );

            return response()->json([
                'message' => 'Chamada iniciada com sucesso!',
                'call_sid' => $call->sid
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}