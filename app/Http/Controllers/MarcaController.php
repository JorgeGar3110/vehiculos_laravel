<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\cat_marcas;

class MarcaController extends Controller
{
    public function inicio()
    {
        $datos = [
            'urlGuardar' => 'marca/guardar',
            'urlEditar' => 'marca/editar',
        ];

        return view('marca/inicio', $datos);
    }

    public function obtenerRegistros(Request $request)
    {
        $response = [
            'rows' => [],
            'total' => 0
        ];

        $query = cat_marcas::select('cat_marcas.*')
                ->orderBy('cat_marcas.id','ASC')->whereNull('deleted_at');

        if(isset($request->filter))
        {
            foreach($request->filter as $index => $value)
            {
                if(!empty($value))
                {
                    $auxiliar = explode('-', $index);

                    if($auxiliar[2] ==  'like')
                        $query = $query->Where("{$auxiliar[0]}.{$auxiliar[1]}", 'like', "%{$value}%");

                    if($auxiliar[2] ==  'equal')
                        $query = $query->Where("{$auxiliar[0]}.{$auxiliar[1]}", '=', "$value");
                }
        
            }
        }

        $queryCount = $query;
        $response['total'] = $queryCount->get()->count();

        if(isset($request->limit))
            $query = $query->take($request->limit);

        if(isset($request->offset))
            $query = $query->skip($request->offset);
        
        $response['rows'] = $query->get();
        return response()->json($response);
    }

    function obtenerMarca(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => "",
            'datos' => null
        ];

        if(!isset($request->id))
            return redirect()->route('/marca');

        $id = base64_decode($request->id);

        $marca = cat_marcas::find($id);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No se encontraron coincidencias";
        }
        else
        {
            $response['datos'] = $marca;
        }

        return response()->json($response);
    }

    function editar(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => ""
        ];

        if(!isset($request->id))
            return redirect()->route('/marca');

        $id = base64_decode($request->id);

        $marca = cat_marcas::where("id", '=' , $id)
                    ->update($request->cat_marcas);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible actualizar la marca seleccionada";
        }
        else
        {
            $response['msj'] = "Marca actualizada correctamente";
        }

        return response()->json($response);
    }

    function guardar(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => ""
        ];

        $marca = cat_marcas::insert($request->cat_marcas);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible guardar la marca seleccionada";
        }
        else
        {
            $response['msj'] = "Marca guardada correctamente";
        }

        return response()->json($response);
    }

    function eliminar(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => ""
        ];

        if(!isset($request->id))
            return redirect()->route('/marca');

        $id = base64_decode($request->id);

        $marca = cat_marcas::where("id", '=' , $id)
                    ->update(['deleted_at' => date('Y-m-d H:m:s')]);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible eliminar la marca seleccionada";
        }
        else
        {
            $response['msj'] = "Marca eliminada correctamente";
        }

        return response()->json($response);
    }
}
