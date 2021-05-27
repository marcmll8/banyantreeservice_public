<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Producte extends Model
{
    use HasFactory;
    /**
     * Relacio N a N amb cistella
     *
     * @return void
     */
    public function liniesCistella()
    {
        return $this->belongsToMany(Cistella::class, "cistellas_linias")->withPivot('quantitat');
    }
  
    /**
     * Relacio amb Imatges
     *
     * @return void
     */
    public function imatges()
    {
        return $this->hasMany(Imatge::class);
    }

    /**
     * Funcio que retorna si un producte esta disponible o no
     *
     * @param integer $quantity
     * @return void
     */
    public function disponible($quantity = 1)
    {

        $disponible = Disponible::where("producte_id", $this->id)->first();
        // dd($quantity);
        if ($disponible == null) {
            return false;
        } else if (($disponible->quantitat_total - $disponible->quantitat_venuda) >= $quantity) {
            return true;
        } else {
            return false;
        }
    }
}
