<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\States;


class StateController extends Controller
{
    public function index()
    {
        return States::all();
    }
    public function cities($state_id)
    {
        try {
            $cities = Cities::where('state_id', $state_id)
                ->select(['id', 'name', 'state_id'])
                ->orderBy('name')
                ->get();
    
            return response()->json([
                'data' => $cities
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar cidades',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
