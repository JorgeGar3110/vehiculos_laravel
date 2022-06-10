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
        'id',
    ];
}
