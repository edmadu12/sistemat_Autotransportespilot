<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function getViajes()
    {
        $viajes = DB::table('viajesreales as a')
            ->select('a.cliente', 'a.origen', 'a.fecha', 'a.tracto', DB::raw('SUM(a.kilometraje) as kilometraje'))
            ->whereBetween('a.fecha', ['2023-11-01 00:00:00', '2023-11-11 23:00:00'])
            ->groupBy('a.cliente', 'a.origen', 'a.fecha')
            ->get();

        // Aquí puedes hacer lo que necesites con los datos de $viajes
        // Por ejemplo, puedes pasarlos a la vista dashboard
        return view('dashboard', ['viajes' => $viajes]);
    }
}
