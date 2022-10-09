<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporte_robos extends Model
{
    use HasFactory;

    function vehiculo()
    {
        return $this->hasOne(reporte_robos::class, 'vehiculo_id', 'vehiculo_id');
    }
    
}
