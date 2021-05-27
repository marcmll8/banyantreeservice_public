<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comanda_Linia extends Model
{
    use HasFactory;
    protected $table = "comanda_linias";

    /**
     * Relacio a producte
     *
     * @return void
     */
    public function producte()
    {
        return $this->belongsTo(Producte::class);
    }

    /**
     * Relacio a comanda
     *
     * @return void
     */
    public function comanda()
    {
        return $this->belongsTo(Comanda::class);
    }
}
