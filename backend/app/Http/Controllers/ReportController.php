<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function clientsByCity()
    {
        $distribution = Clients::with('address.city')
            ->selectRaw('cities.name as city_name, count(clients.id) as total')
            ->join('address', 'clients.address_id', '=', 'address.id')
            ->join('cities', 'address.city_id', '=', 'cities.id')
            ->groupBy('cities.name')
            ->get();

        $totalClients = Clients::count();
        $data = $distribution->map(function ($item) use ($totalClients) {
            return [
                'city' => $item->city_name,
                'total' => $item->total,
                'percentage' => round(($item->total / $totalClients) * 100, 2),
            ];
        });

        return response()->json($data, 200);
    }

    public function clientsByState()
    {
        $distribution = Clients::with('address.city.state')
            ->selectRaw('states.name as state_name, count(clients.id) as total')
            ->join('address', 'clients.address_id', '=', 'address.id')
            ->join('cities', 'address.city_id', '=', 'cities.id')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->groupBy('states.name')
            ->get();

        $totalClients = Clients::count();
        $data = $distribution->map(function ($item) use ($totalClients) {
            return [
                'state' => $item->state_name,
                'total' => $item->total,
                'percentage' => round(($item->total / $totalClients) * 100, 2),
            ];
        });

        return response()->json($data, 200);
    }

    public function clientsByAge()
    {
        $distribution = Clients::selectRaw(
            'CASE 
            WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 25 THEN "18-25"
            WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 26 AND 35 THEN "26-35"
            WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 36 AND 45 THEN "36-45"
            WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 46 AND 55 THEN "46-55"
            WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 55 THEN "55+"
            ELSE "Não informado"
        END as age_range,
        COUNT(*) as total'
        )
            ->groupBy('age_range')
            ->get();

        $totalClients = Clients::count();
        $data = $distribution->map(function ($item) use ($totalClients) {
            return [
                'age_range' => $item->age_range,
                'total' => $item->total,
                'percentage' => round(($item->total / $totalClients) * 100, 2),
            ];
        });

        return response()->json($data, 200);
    }
}
