<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\cat_marcas;

class MarcaController extends Controller
{
    public function inicio()
    {
        return view('marca/inicio');
    }

    public function obtenerRegistros(Request $request)
    {
        $marca = cat_marcas::select('cat_marcas.*')->orderBy('cat_marcas.id','ASC')->get();

        echo '<pre>';
        print_r($marca);
        die();


    }
}
