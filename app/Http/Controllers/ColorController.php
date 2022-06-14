<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\cat_colores;

class ColorController extends Controller
{
    public function inicio()
    {
        $datos = [
            'urlGuardar' => 'colores/guardar',
            'urlEditar' => 'colores/editar',
        ];

        return view('colores/inicio', $datos);
    }

    public function obtenerRegistros(Request $request)
    {
        $response = [
            'rows' => [],
            'total' => 0
        ];

        $query = cat_colores::select('cat_colores.*')
                ->orderBy('cat_colores.id','ASC')->whereNull('deleted_at');

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

    function guardar(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => ""
        ];

        $marca = cat_colores::insert($request->cat_colores);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible guardar el color";
        }
        else
        {
            $response['msj'] = "Color guardado correctamente";
        }

        return response()->json($response);
    }

    function obtenerColor(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => "",
            'datos' => null
        ];

        if(!isset($request->id))
            return redirect()->route('/colores');

        $id = base64_decode($request->id);

        $marca = cat_colores::find($id);

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
            return redirect()->route('/colores');

        $id = base64_decode($request->id);

        $marca = cat_colores::where("id", '=' , $id)
                    ->update($request->cat_colores);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible actualizar el color seleccionado";
        }
        else
        {
            $response['msj'] = "Color actualizado correctamente";
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
            return redirect()->route('/colores');

        $id = base64_decode($request->id);

        $marca = cat_colores::where("id", '=' , $id)
                    ->update(['deleted_at' => date('Y-m-d H:m:s')]);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible eliminar el color seleccionado";
        }
        else
        {
            $response['msj'] = "Color eliminado correctamente";
        }

        return response()->json($response);
    }
}
