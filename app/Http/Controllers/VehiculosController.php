<?php

namespace App\Http\Controllers;

use App\Models\cat_colores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\vehiculos;
use App\Models\propietarios_vehiculos;
use App\Models\propietarios;
use App\Models\cat_marcas;

class VehiculosController extends Controller
{
    public function inicio()
    {
        $propietarios = propietarios::obtenerPropietarios();
        $marcas = cat_marcas::obtenerMarcas();
        $colores = cat_colores::obtenerColores();

        $datos = [
            'urlGuardar' => 'vehiculos/guardar',
            'urlEditar' => 'vehiculos/editar',
            'colores' => $colores,
            'marcas' => $marcas,
            'propietarios' => $propietarios
        ];

        return view('vehiculos/inicio', $datos);
    }

    public function obtenerRegistros(Request $request)
    {
        $response = [
            'rows' => [],
            'total' => 0
        ];

        $query = vehiculos::select('vehiculos.*')
            ->orderBy('vehiculos.id', 'ASC')->whereNull('deleted_at');

        if (isset($request->filter)) {
            foreach ($request->filter as $index => $value) {
                if (!empty($value)) {
                    $auxiliar = explode('-', $index);

                    if ($auxiliar[2] ==  'like')
                        $query = $query->Where("{$auxiliar[0]}.{$auxiliar[1]}", 'like', "%{$value}%");

                    if ($auxiliar[2] ==  'equal')
                        $query = $query->Where("{$auxiliar[0]}.{$auxiliar[1]}", '=', "$value");
                }
            }
        }

        $queryCount = $query;
        $response['total'] = $queryCount->get()->count();

        if (isset($request->limit))
            $query = $query->take($request->limit);

        if (isset($request->offset))
            $query = $query->skip($request->offset);

        $response['rows'] = $query->get();
        return response()->json($response);
    }

    function obtenerVehiculo(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => "",
            'datos' => null
        ];

        if (!isset($request->id))
            return redirect()->route('/vehiculos');

        $id = base64_decode($request->id);

        $vehiculo = vehiculos::where('id',$id)
                    ->with(['propietarios' => function ($q) use($id)
                    {
                        $q->where('propietario_actual', true)
                        ->orderBy('id', 'desc')
                        ->take(1);
                    }])
                    ->get();        

        if (!$vehiculo) {
            $response['error'] = true;
            $response['msj'] = "No se encontraron coincidencias";
        } else {
            $response['datos'] = $vehiculo[0];
        }

        return response()->json($response);
    }

    function editar(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => ""
        ];

        if (!isset($request->id))
            return redirect()->route('/marcas');

        $id = base64_decode($request->id);

        $vehiculo = vehiculos::where("id", '=', $id)
            ->update($request->vehiculos);

        if (!$vehiculo) {
            $response['error'] = true;
            $response['msj'] = "No fue posible actualizar el vehículo seleccionado";
        } else {
            $response['msj'] = "Vehículo actualizado correctamente";
        }

        return response()->json($response);
    }

    function guardar(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => ""
        ];


        DB::beginTransaction();

        $vehiculoId = null;

        $query = vehiculos::select("*")
                    ->where('vin', '=', $request->vehiculos['vin'])
                    ->whereNull('deleted_at');

        $queryCount = $query;
        if($queryCount->get()->count() == 0)
        {
            $vehiculoId = vehiculos::insertGetId($request->vehiculos);
        }
        else
        {
            $datosVehiculo = $query->get()[0];
            vehiculos::where("id", '=', $datosVehiculo->id)
            ->update($request->vehiculos);

            $vehiculoId = $datosVehiculo->id;

        }

        $propietarioVehiculo = $request->propietarios_vehiculos;
        $propietarioVehiculo['vehiculo_id'] = $vehiculoId;
        $propietarioVehiculo['propietario_actual'] = true;

        $propietario = propietarios_vehiculos::insert($propietarioVehiculo);


        if (!$propietario) {
            DB::rollBack();
            $response['error'] = true;
            $response['msj'] = "No fue posible guardar el vehículo seleccionado";
        } else {
            DB::commit();
            $response['msj'] = "Vehículo guardado correctamente";
        }

        return response()->json($response);
    }

    function eliminar(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => ""
        ];

        if (!isset($request->id))
            return redirect()->route('/marcas');

        $id = base64_decode($request->id);

        $vehiculo = vehiculos::where("id", '=', $id)
            ->update(['deleted_at' => date('Y-m-d H:m:s')]);

        if (!$vehiculo) {
            $response['error'] = true;
            $response['msj'] = "No fue posible eliminar el vehículo seleccionado";
        } else {
            $response['msj'] = "Vehículo eliminado correctamente";
        }

        return response()->json($response);
    }
}
