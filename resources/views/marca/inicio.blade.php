@extends('layout')

@section('title')
    <h1>Administración de marcas</h1>
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
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" class="form-control filtro" name="cat_marcas-nombre-like">
                        </div>
                    </div>
                    <div class="col-md-4 padding15">
                        <div class="form-group">
                            <label for="marca2">Marca</label>
                            <input type="text" id="marca2" class="form-control filtro" name="cat_marcas-nombre-equal">
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
                        <table id="tablaMarcas">
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

    <div id="modalMarca" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar marca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formMarca" method="POST" data-parsley-validate="">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group" id="cb_marca">
                            <label for="marca">Marca</label>
                            <input type="text" id="txt_marca" class="form-control filtro" name="cat_marcas[nombre]" data-cb="cb_marca" data-parsley-errors-container="#cb_marca" required>
                            <input type="hidden" id="txt_id" class="form-control filtro" name="id">
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

    <script defer src="{{ asset('js/marcas/index.js') }}"></script>
@endsection
