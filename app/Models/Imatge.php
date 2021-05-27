<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imatge extends Model
{
    use HasFactory;
    /**
     * relacio a producte
     *
     * @return void
     */
    public function producte()
    {
        return $this->belongsTo(Producte::class);
    }
}
