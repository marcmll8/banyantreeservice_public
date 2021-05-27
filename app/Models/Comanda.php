<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    use HasFactory;
    /**
     * Relacio a comanda Linia
     *
     * @return void
     */
    public function comandaLinies()
    {
        return $this->hasMany(Comanda_Linia::class);
    }

    /**
     * Relacio a usuari
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
