<?php

namespace App\Http\Controllers;

use App\Models\Disponible;
use App\Models\Producte;
use App\Models\Comanda;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Fa una api amb els productes disponibles
     *
     * @return void
     */
    public function productesDisponibles()
    {
        $disponibles = Disponible::whereHas('producte', function ($query) {
            $query->where('eliminat', 0);
        })->with('producte')->get();

        return response()->json(["productes" => $disponibles]);
    }

    /**
     * Mostra una api amb les comandes pendents
     *
     * @return void
     */
    public function comandasPendientes()
    {
        return response()->json($comandas = Comanda::with('user')->where("estat", 0)->get());
    }

    /**
     * Mostra una api amb les comandes fetes
     *
     * @return void
     */
    public function comandasHechas()
    {
        return response()->json($comandas = Comanda::with('user')->where("estat", 1)->get());
    }

    /**
     * Mostra una api amb les comandes entregades
     *
     * @return void
     */
    public function comandasEntregadas()
    {
        return response()->json($comandas = Comanda::with('user')->where("estat", 2)->get());
    }
}
