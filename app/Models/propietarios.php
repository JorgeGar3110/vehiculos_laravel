<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class propietarios extends Model
{
    use HasFactory;

    function obtenerPropietarios()
    {
        $propietarios = propietarios::select(
            'propietarios.id', 
            DB::raw('CONCAT(propietarios.curp, " | ", propietarios.nombre, " ", propietarios.apellido_paterno, " ", propietarios.apellido_materno) as propietario'))
        ->join('cat_generos', 'cat_generos.id' , '=' , 'propietarios.cat_genero_id')
        ->orderBy('propietarios.id','ASC')
        ->whereNull('propietarios.deleted_at')->get();

        return $propietarios;
    }
}
