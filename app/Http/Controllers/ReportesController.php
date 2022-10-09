<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\vehiculos;
use App\Models\reporte_robos;

class ReportesController extends Controller
{
    public function inicio()
    {
        $vehiculos = vehiculos::obtenerVehiculosReporte();

        $datos = [
            'urlGuardar' => 'reportes/guardar',
            'urlEditar' => 'reportes/editar',
            'vehiculos' => $vehiculos
        ];

        return view('reportes/inicio', $datos); 
    }

    public function obtenerRegistros(Request $request)
    {
        $response = [
            'rows' => [],
            'total' => 0
        ];

        $query = reporte_robos::select(
                'reporte_robos.*',
                'reporte_robos.id as reporte_robo_id', 
                'vehiculos.*', 
                'vehiculos.id as vehiculo_id')
            ->join('vehiculos', 'vehiculos.id', "=", 'reporte_robos.vehiculo_id')
            ->orderBy('reporte_robos.id', 'ASC')
            ->whereNull('reporte_robos.deleted_at');

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

    function obtenerReporte(Request $request)
    {
        $response = [
            'error' => false,
            'msj' => "",
            'datos' => null
        ];

        if (!isset($request->id))
            return redirect()->route('/reportes');

        $id = base64_decode($request->id);

        $reporte = reporte_robos::where('id',$id)
                    ->with(['vehiculo' => function ($q) use($id){
                        vehiculos::get();
                    }])
                    ->get()[0];        

        if (!$reporte) {
            $response['error'] = true;
            $response['msj'] = "No se encontraron coincidencias";
        } else {
            $response['datos'] = $reporte;
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

        $vehiculo = reporte_robos::where("id", '=', $id)
            ->update($request->reportes);

        if (!$vehiculo) {
            $response['error'] = true;
            $response['msj'] = "No fue posible actualizar el reporte de robo del vehículo seleccionado";
        } else {
            $response['msj'] = "Reporte de robo de vehículo actualizado correctamente";
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

        $noReporte = DB::select('SELECT LPAD((SELECT COUNT(id) FROM reporte_robos) + 1, 5, "0") AS reporte')[0];

        $reporte = $request->reportes;
        $reporte['no_reporte'] = $noReporte->reporte;
        $reporte = reporte_robos::insert($reporte);

        if (!$reporte) {
            DB::rollBack();
            $response['error'] = true;
            $response['msj'] = "No fue posible guardar el reporte de robo de vehículo";
        } else {
            DB::commit();
            $response['msj'] = "Reporte de robo de Vehículo guardado correctamente";
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

        $vehiculo = reporte_robos::where("id", '=', $id)
            ->update(['deleted_at' => date('Y-m-d H:m:s')]);

        if (!$vehiculo) {
            $response['error'] = true;
            $response['msj'] = "No fue posible eliminar el reporte de robo del vehículo seleccionado";
        } else {
            $response['msj'] = "Reporte de robo del vehículo eliminado correctamente";
        }

        return response()->json($response);
    }
}
