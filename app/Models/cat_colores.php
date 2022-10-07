<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cat_colores extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
    ];

    protected $hidden = [
    ];


    function obtenerColores()
    {
        $colores = cat_colores::select('cat_colores.*')
                ->orderBy('cat_colores.id','ASC')->whereNull('deleted_at')
                ->get();
        
        return $colores;
    }
}
