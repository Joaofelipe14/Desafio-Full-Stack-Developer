<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarEmailBoasVindasJob;
use App\Models\Address;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Clients::query()->latest();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $clients = $query->paginate(10);
        return response()->json($clients, 200);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'mobile' => 'nullable|string',
                'email' => 'required|email|unique:clients,email',
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

            $cliente = Clients::create([
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'email' => $validated['email'],
                'birth_date' => $validated['birth_date'],
                'address_id' => $addressId,
            ]);

            EnviarEmailBoasVindasJob::dispatch($cliente)
                ->delay(now()->addMinutes(30));

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
        $cliente = Clients::with(['address.city.state'])->find($id);

        if (!$cliente) {
            return response()->json(['erro' => 'Cliente não encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $cliente = Clients::find($id);

            if (!$cliente) {
                return response()->json(['erro' => 'Cliente não encontrado'], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'mobile' => 'sometimes|string',
                'email' => 'sometimes|email|unique:clients,email,' . $id,
                'birth_date' => 'sometimes|date',
                'city_id' => 'nullable|exists:cities,id',
                'address' => 'nullable|string|max:255',
                'neighborhood' => 'nullable|string|max:255',
            ]);

            $addressId = $cliente->address_id;


            if (!empty($addressId) || !empty($validated['city_id'])) {
                $address = Address::updateOrCreate(
                    ['id' => $addressId],
                    [
                        'address' => $validated['address'] ?? $cliente->address?->address,
                        'neighborhood' => $validated['neighborhood'] ?? $cliente->address?->neighborhood,
                        'city_id' => $validated['city_id'] ?? $cliente->address?->city_id
                    ]
                );
                $addressId = $address->id;
            }
            $cliente->update([
                'name' => $validated['name'] ?? $cliente->name,
                'mobile' => $validated['mobile'] ?? $cliente->mobile,
                'email' => $validated['email'] ?? $cliente->email,
                'birth_date' => $validated['birth_date'] ?? $cliente->birth_date,
                'address_id' => $addressId,
            ]);

            DB::commit();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Cliente cadastrado com sucesso'
                ],
                200
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['status' => 'error', 'message' => 'Erro inesperado'], 500);
        }
    }


    public function destroy($id)
    {
        $cliente = Clients::find($id);

        if (!$cliente) {
            return response()->json(['erro' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['mensagem' => 'Cliente excluído com sucesso'], 200);
    }
}
