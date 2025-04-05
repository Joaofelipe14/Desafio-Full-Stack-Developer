<?php
namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function clientsByCity()
    {
        $distribution = Clients::with(['address.city'])
            ->select('clients.*')
            ->join('address', 'clients.address_id', '=', 'address.id')
            ->join('cities', 'address.city_id', '=', 'cities.id')
            ->select('cities.name as city_name', DB::raw('count(clients.id) as total'))
            ->groupBy('cities.name')
            ->orderBy('total', 'desc')
            ->get();
            
        // Calcular porcentagens
        $totalClients = Clients::count();
        $data = $distribution->map(function ($item) use ($totalClients) {
            return [
                'city' => $item->city_name,
                'total' => $item->total,
                'percentage' => round(($item->total / $totalClients) * 100, 2)
            ];
        });
        
        return response()->json($data, 200);
    }
}