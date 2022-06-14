<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\propietarios;
use App\Models\cat_generos;

class PropietariosController extends Controller
{
    public function inicio()
    {
        $generos = cat_generos::select('*')
            ->whereNull('deleted_at')
            ->get();

        $datos = [
            'urlGuardar' => 'propietarios/guardar',
            'urlEditar' => 'propietarios/editar',
            'generos' => $generos
        ];

        return view('propietarios/inicio', $datos);
    }

    public function obtenerRegistros(Request $request)
    {
        $response = [
            'rows' => [],
            'total' => 0
        ];

        $query = propietarios::select(
                    'propietarios.id', 
                    DB::raw('CONCAT(propietarios.nombre, " ", propietarios.apellido_paterno, " ", propietarios.apellido_materno) as nombre_completo'), 
                    'propietarios.curp', 
                    'propietarios.fecha_nacimiento', 
                    'cat_generos.nombre as genero')
                ->join('cat_generos', 'cat_generos.id' , '=' , 'propietarios.cat_genero_id')
                ->orderBy('propietarios.id','ASC')
                ->whereNull('propietarios.deleted_at');

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

        $marca = propietarios::insert($request->propietarios);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible guardar el propietario";
        }
        else
        {
            $response['msj'] = "Propietario guardado correctamente";
        }

        return response()->json($response);
    }

    function obtenerPropietario(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => "",
            'datos' => null
        ];

        if(!isset($request->id))
            return redirect()->route('/propietarios');

        $id = base64_decode($request->id);

        $marca = propietarios::find($id);

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
            return redirect()->route('/propietarios');

        $id = base64_decode($request->id);

        $marca = propietarios::where("id", '=' , $id)
                    ->update($request->propietarios);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible actualizar el propietario seleccionado";
        }
        else
        {
            $response['msj'] = "Propietario actualizado correctamente";
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
            return redirect()->route('/propietarios');

        $id = base64_decode($request->id);

        $marca = propietarios::where("id", '=' , $id)
                    ->update(['deleted_at' => date('Y-m-d H:m:s')]);

        if(!$marca)
        {
            $response['error'] = true;
            $response['msj'] = "No fue posible eliminar el propietario seleccionado";
        }
        else
        {
            $response['msj'] = "Propietario eliminado correctamente";
        }

        return response()->json($response);
    }
}
