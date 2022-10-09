<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class vehiculos extends Model
{
    use HasFactory;

    public function obtenerVehiculosReporte()
    {
        $vehiculos = vehiculos::select(
            'vehiculos.id',
            DB::raw('CONCAT(vehiculos.vin, " | ", cat_marcas.nombre, " - ", vehiculos.linea, " " , vehiculos.modelo) as informacion')
        )
        ->join('cat_marcas', 'cat_marcas.id' , '=', 'vehiculos.cat_marca_id')
        ->whereNull('vehiculos.deleted_at')
        ->get();

        return $vehiculos;
    }

    public function propietarios()
    {
        return $this->belongsToMany(propietarios::class, 'propietarios_vehiculos', 'vehiculo_id', 'propietario_id');
    }

}
