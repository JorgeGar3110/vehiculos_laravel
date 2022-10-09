@extends('layout')

@section('title')
    <h1>Administración de vehículos</h1>
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
                        <div class="form-group" id="cb_marca">
                            <label for="marca">Marca</label>
                            <select id="marca" name="vehiculos-cat_marca_id-equal" class="form-control filtro">
                                <option value="">Seleccione una opción</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                @endforeach
                            </select>
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
                        <table id="tablaVehiculos">
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

    <div id="modalVehiculo" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar vehículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formVehiculo" method="POST" data-parsley-validate="">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" id="cb_marca">
                                    <label for="marca">Marca</label>
                                    <select id="marca_id" name="vehiculos[cat_marca_id]" class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($marcas as $marca)
                                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" id="cb_linea">
                                    <label for="txt_linea">Linea</label>
                                    <input type="text" id="txt_linea" class="form-control filtro" name="vehiculos[linea]"
                                        data-cb="cb_linea" data-parsley-errors-container="#cb_linea" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="cb_modelo">
                                    <label for="txt_modelo">Modelo</label>
                                    <input type="text" id="txt_modelo" class="form-control filtro"
                                        name="vehiculos[modelo]" data-cb="cb_modelo"
                                        data-parsley-errors-container="#cb_modelo" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" id="cb_color">
                                    <label for="color">Color</label>
                                    <select id="color_id" name="vehiculos[cat_color_id]" class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($colores as $color)
                                            <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="cb_placa">
                                    <label for="txt_placa">Placa</label>
                                    <input type="text" id="txt_placa" class="form-control filtro"
                                        name="vehiculos[placa]" data-cb="cb_placa"
                                        data-parsley-errors-container="#cb_placa" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="cb_vin">
                                    <label for="txt_placa">VIN</label>
                                    <input type="text" id="txt_vin" class="form-control filtro"
                                        name="vehiculos[vin]" data-cb="cb_vin" data-parsley-errors-container="#cb_vin"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="cb_propietario">
                                    <label for="propietario">Propietario</label>
                                    <select id="propietario" name="propietarios_vehiculos[propietario_id]"
                                        class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($propietarios as $propietario)
                                            <option value="{{ $propietario->id }}">{{ $propietario->propietario }}</option>
                                        @endforeach
                                    </select>
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

    <script defer src="{{ asset('js/vehiculos/index.js') }}"></script>
@endsection
