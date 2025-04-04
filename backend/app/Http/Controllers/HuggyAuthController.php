<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HuggyAuthController extends Controller
{
    public function redirectToHuggy()
    {
        $query = http_build_query([
            'scope'         => 'install_app read_agent_profile',
            'response_type' => 'code',
            'redirect_uri'  => env('HUGGY_REDIRECT_URI'),
            'client_id'     => env('HUGGY_CLIENT_ID'),
        ]);


        return redirect('https://auth.huggy.app/oauth/authorize?' . $query);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return response()->json(['error' => 'Código de autorização ausente'], 400);
        }

        $response = Http::post('https://auth.huggy.app/oauth/access_token', [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => env('HUGGY_CLIENT_ID'),
            'client_secret' => env('HUGGY_CLIENT_SECRET'),
            'redirect_uri'  => env('HUGGY_REDIRECT_URI'),
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Falha na autenticação com Huggy'], 401);
        }

        $tokenData = $response->json();
        $accessToken = $tokenData['access_token'];

        $agentResponse = Http::withToken($accessToken)->get('https://api.huggy.app/v3/agents');

        if ($agentResponse->failed()) {
            return response()->json(['error' => 'Falha ao obter dados do agente'], 500);
        }

        $agentData = $agentResponse->json();
        $agent = $agentData[0] ?? null;

        if (!$agent) {
            return response()->json(['error' => 'Nenhum agente encontrado'], 404);
        }

        $email = $agent['email'];
        $name = $agent['name'];

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password'=>' ',
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        // return response()->json([
        //     'user' => $user,
        //     'token' => $token,
        // ]);

        return redirect('http://localhost:5173/?token=' . $token); // Alterar para a URL do frontend

    
    }
    
}
