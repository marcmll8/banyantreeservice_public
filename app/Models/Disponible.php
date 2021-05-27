<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponible extends Model
{
    use HasFactory;
    /**
     * Relacio a producte
     *
     * @return void
     */
    public function producte()
    {
        return $this->belongsTo(Producte::class);
    }
}
