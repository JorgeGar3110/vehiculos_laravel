@extends('layout')

@section('title')
    <h1>Administración de marcas</h1>
@endsection


@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success">Registrar</button>
            </div>
            <hr>
        </div>
        <div class="row">
            <table id="tablaMarcas">
                <thead>

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <script>
        var baseUrl = "{{ env('APP_URL') }}";
    </script>
    
    <script defer src="{{ asset('js/marcas/index.js') }}"></script>
@endsection