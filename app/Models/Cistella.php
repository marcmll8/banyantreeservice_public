<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cistella extends Model
{
    use HasFactory;
    /**
     * Relacio N a N de cistelles a prodcutes
     *
     * @return void
     */
    public function liniesCistella()
    {
        return $this->belongsToMany(Producte::class, "cistellas_linias")->withPivot('quantitat');
    }
}
