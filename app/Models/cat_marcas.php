<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cat_marcas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
    ];

    protected $hidden = [
    ];


    function obtenerMarcas()
    {
        $marcas = cat_marcas::select('cat_marcas.*')
                ->orderBy('cat_marcas.id','ASC')
                ->whereNull('deleted_at')
                ->get();

        return $marcas;
    }
}
