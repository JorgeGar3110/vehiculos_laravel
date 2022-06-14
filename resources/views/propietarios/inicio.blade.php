@extends('layout')

@section('title')
    <h1>Administración de propietarios</h1>
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
                    <div class="col-md-3 padding15">
                        <div class="form-group">
                            <label for="curp">CURP</label>
                            <input type="text" id="curp" class="form-control filtro" name="propietarios-curp-equal">
                        </div>
                    </div>
                    <div class="col-md-3 padding15">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" class="form-control filtro" name="propietarios-nombre-like">
                        </div>
                    </div>
                    <div class="col-md-3 padding15">
                        <div class="form-group">
                            <label for="apellido_paterno">Apellido paterno</label>
                            <input type="text" id="apellido_paterno" class="form-control filtro"
                                name="propietarios-apellido_paterno-like">
                        </div>
                    </div>
                    <div class="col-md-3 padding15">
                        <div class="form-group">
                            <label for="apellido_materno">Apellido materno</label>
                            <input type="text" id="apellido_materno" class="form-control filtro"
                                name="propietarios-apellido_materno-like">
                        </div>
                    </div>

                    <div class="col-md-3 padding15">
                        <div class="form-group">
                            <label for="cat_genero_filtro">Fecha nacimiento</label>
                            <select id="cat_genero_filtro" class="form-control filtro" name="propietarios-cat_genero_id-equal">
                                <option value="">Seleccione una opción</option>
                                @foreach ($generos as $index => $genero)
                                    <option value="{{ $genero->id }}">{{ $genero->nombre }}</option>
                                @endforeach
                            </select>
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
                        <table id="tablaPropietarios">
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

    <div id="modalPropietario" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar propietario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formPropietario" method="POST" data-parsley-validate="">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="form-group" id="cb_propietario1">
                                <label for="curp">CURP</label>
                                <input type="txt_curp" id="txt_curp" class="form-control" name="propietarios[CURP]"
                                    data-cb="cb_propietario1" data-parsley-errors-container="#cb_propietario1" required
                                    minlength="18" maxlength="18">
                                <input type="hidden" id="txt_id" class="form-control filtro" name="id">
                            </div>
                            <div class="form-group" id="cb_propietario2">
                                <label for="txt_nombre">Nombre</label>
                                <input type="text" id="txt_nombre" class="form-control" name="propietarios[nombre]"
                                    data-cb="cb_propietario2" data-parsley-errors-container="#cb_propietario2" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="cb_propietario3">
                                <label for="txt_ap1">Primer apellido</label>
                                <input type="text" id="txt_ap1" class="form-control" name="propietarios[apellido_paterno]"
                                    data-cb="cb_propietario3" data-parsley-errors-container="#cb_propietario3" required>
                            </div>
                            <div class="form-group col-md-6" id="cb_propietario4">
                                <label for="txt_ap2">Segundo Apellido</label>
                                <input type="text" id="txt_ap2" class="form-control" name="propietarios[apellido_materno]"
                                    data-cb="cb_propietario4" data-parsley-errors-container="#cb_propietario4" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="cb_propietario5">
                                <label for="txt_fecha">Fecha nacimiento</label>
                                <input type="date" id="txt_fecha" class="form-control"
                                    name="propietarios[fecha_nacimiento]" data-cb="cb_propietario5"
                                    data-parsley-errors-container="#cb_propietario5" required>
                            </div>
                            <div class="form-group col-md-6" id="cb_propietario6">
                                <label for="cat_genero">Fecha nacimiento</label>
                                <select id="cat_genero" class="form-control" name="propietarios[cat_genero_id]"
                                    data-cb="cb_propietario6" data-parsley-errors-container="#cb_propietario6" required>
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($generos as $index => $genero)
                                        <option value="{{ $genero->id }}">{{ $genero->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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

    <script defer src="{{ asset('js/propietarios/index.js') }}"></script>
@endsection
