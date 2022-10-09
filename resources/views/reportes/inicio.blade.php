@extends('layout')

@section('title')
    <h1>Administración de reportes</h1>
@endsection


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 padding15">
                        <button class="btn btn-success" id="btnRegistrar">Registrar</button>
                    </div>
                    <hr>
                </div>
                <div class="row" id="toolbar">
                    <div class="col-md-4 padding15">
                        <div class="form-group">
                            <label for="reporte">Reporte equal</label>
                            <input type="text" id="reporte" class="form-control filtro" name="reporte_robos-no_reporte-equal">
                        </div>
                    </div>
                    <div class="col-md-4 padding15">
                        <div class="form-group">
                            <label for="vin">VIN like</label>
                            <input type="text" id="vin" class="form-control filtro" name="vehiculos-vin-like">
                        </div>
                    </div>
                    <div class="col-md-4 padding15">
                        <div class="form-group">
                            <label for="placa">Placa like</label>
                            <input type="text" id="placa" class="form-control filtro" name="vehiculos-placa-like">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 padding15">
                        <button class="btn btn-default" id="btnBuscar">Buscar</button>
                    </div>
                    <div class="col-md-6 padding15">
                        <button class="btn btn-default" id="btnLimpiar">Limpiar filtros</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 padding15">
                        <table id="tablaReportes">
                            <thead>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalReporte" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar reporte de robo de vehículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formReporte" method="POST" data-parsley-validate="">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" id="cb_marca">
                                    <label for="vehiculo_id">Vehiculo</label>
                                    <select id="vehiculo_id" name="reportes[vehiculo_id]" class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($vehiculos as $vehiculo)
                                            <option value="{{ $vehiculo->id }}">{{ $vehiculo->informacion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" id="fecha">
                                    <label for="txt_fecha">Fecha de robo</label>
                                    <input type="date" id="txt_fecha" class="form-control filtro" name="reportes[fecha_robo]"
                                        data-cb="fecha" data-parsley-errors-container="#fecha" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="hora">
                                    <label for="txt_hora">Hora de robo</label>
                                    <input type="time" id="txt_hora" class="form-control filtro" name="reportes[hora_robo]"
                                        data-cb="hora" data-parsley-errors-container="#hora" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="cb_detalles">
                                    <label for="txt_detalles">Detalles</label>
                                    <textarea type="text" id="txt_detalles" class="form-control filtro"
                                        name="reportes[detalles]" data-cb="cb_detalles"
                                        data-parsley-errors-container="#cb_detalles" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="txt_id" class="form-control filtro" name="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        var urlGuardar = "{{ $urlGuardar }}";
        var urlEditar = "{{ $urlEditar }}";
    </script>

    <script defer src="{{ asset('js/reportes/index.js') }}"></script>
@endsection
