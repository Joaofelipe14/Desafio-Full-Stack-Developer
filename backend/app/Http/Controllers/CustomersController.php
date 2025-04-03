<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarEmailBoasVindasJob;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customers;
use Exception;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customers::paginate(5);

        return response()->json($customers, 200);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'cpf' => 'nullable|string|size:11|unique:customers,cpf',
                'email' => 'required|email|unique:customers,email',
                'birth_date' => 'nullable|date',
                'city_id' => 'nullable|exists:cities,id',
                'address' => 'nullable|string|max:255',
                'neighborhood' => 'nullable|string|max:255',
            ]);

            $addressId = null;

            if (!empty($validated['city_id'])) {
                $address = Address::create([
                    'address' => $validated['address'] ?? null,
                    'neighborhood' => $validated['neighborhood'] ?? null,
                    'city_id' => $validated['city_id'],
                ]);
                $addressId = $address->id;
            }

            $cliente = Customers::create([
                'name' => $validated['name'],
                'cpf' => $validated['cpf'],
                'email' => $validated['email'],
                'birth_date' => $validated['birth_date'],
                'address_id' => $addressId,
            ]);

            EnviarEmailBoasVindasJob::dispatch($cliente)
                ->delay(now()->addMinutes(2));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Cliente cadastrado com sucesso',
                'data' => $cliente
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['status' => 'error', 'message' => 'Erro inesperado'], 500);
        }
    }


    public function show($id)
    {
        $cliente = Customers::with(['address.city.state'])->find($id);

        if (!$cliente) {
            return response()->json(['erro' => 'Cliente não encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $cliente = Customers::find($id);

            if (!$cliente) {
                return response()->json(['erro' => 'Cliente não encontrado'], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'cpf' => 'sometimes|string|size:11|unique:customers,cpf,' . $id,
                'email' => 'sometimes|email|unique:customers,email,' . $id,
                'birth_date' => 'sometimes|date',
                'city_id' => 'sometimes|exists:cities,id',
                'address' => 'sometimes|string|max:255',
                'neighborhood' => 'sometimes|string|max:255',
            ]);

            $addressId = $cliente->address_id;
            if (!empty($validated['city_id'])) {
                $address = Address::updateOrCreate(
                    ['id' => $addressId],
                    [
                        'address' => $validated['address'] ?? $cliente->address->address,
                        'neighborhood' => $validated['neighborhood'] ?? $cliente->address->neighborhood,
                        'city_id' => $validated['city_id']
                    ]
                );
                $addressId = $address->id;
            }

            $cliente->update([
                'name' => $validated['name'] ?? $cliente->name,
                'cpf' => $validated['cpf'] ?? $cliente->cpf,
                'email' => $validated['email'] ?? $cliente->email,
                'birth_date' => $validated['birth_date'] ?? $cliente->birth_date,
                'address_id' => $addressId,
            ]);

            DB::commit();

            return response()->json($cliente, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Erro inesperado'], 500);
        }
    }


    public function destroy($id)
    {
        $cliente = Customers::find($id);

        if (!$cliente) {
            return response()->json(['erro' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['mensagem' => 'Cliente excluído com sucesso'], 200);
    }
}
