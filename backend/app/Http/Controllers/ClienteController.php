<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarEmailBoasVindasJob;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Exception;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(5);

        return response()->json($clientes, 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|size:11|unique:clientes,cpf',
                'email' => 'required|email|unique:clientes,email',
                'data_nascimento' => 'required|date',
                'cidade_id' => 'required|exists:cidades,id'
            ]);

            $cliente = Cliente::create($validated);

            EnviarEmailBoasVindasJob::dispatch($cliente)
                ->delay(now()->addMinutes(2));
    
            return response()->json([
                'status' => 'success',
                'message' => 'Cliente cadastrado com sucesso',
                'data' => $cliente 
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Erro inesperado'], 500);
        }
    }


    public function show($id)
    {
        $cliente = Cliente::with(['cidade.estado'])->find($id);

        if (!$cliente) {
            return response()->json(['erro' => 'Cliente não encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {

        try {
            $cliente = Cliente::find($id);

            if (!$cliente) {
                return response()->json(['erro' => 'Cliente não encontrado'], 404);
            }

            $request->validate([
                'nome' => 'sometimes|string|max:255',
                'cpf' => 'sometimes|string|size:11|unique:clientes,cpf,' . $id,
                'email' => 'sometimes|email|unique:clientes,email,' . $id,
                'data_nascimento' => 'sometimes|date',
                'cidade_id' => 'sometimes|exists:cidades,id'
            ]);

            $cliente->update($request->all());

            return response()->json($cliente, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Erro inesperado'], 500);
        }
    }


    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['erro' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['mensagem' => 'Cliente excluído com sucesso'], 200);
    }
}
