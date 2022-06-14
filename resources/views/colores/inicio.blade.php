@extends('layout')

@section('title')
    <h1>Administración de colores</h1>
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
                            <label for="marca">Color like</label>
                            <input type="text" id="color" class="form-control filtro" name="cat_colores-nombre-like">
                        </div>
                    </div>
                    <div class="col-md-4 padding15">
                        <div class="form-group">
                            <label for="marca2">Color equal</label>
                            <input type="text" id="color2" class="form-control filtro" name="cat_colores-nombre-equal">
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
                        <table id="tablaColores">
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

    <div id="modalColor" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formColor" method="POST" data-parsley-validate="">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="form-group" id="cb_color">
                                <label for="marca">Color</label>
                                <input type="text" id="txt_color" class="form-control filtro" name="cat_colores[nombre]" data-cb="cb_color" data-parsley-errors-container="#cb_color" required>
                                <input type="hidden" id="txt_id" class="form-control filtro" name="id">
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

    <script defer src="{{ asset('js/colores/index.js') }}"></script>
@endsection
