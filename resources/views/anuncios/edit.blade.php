@extends('adminlte::page')

@section('title', 'Editar')

@section('content_header')
    <h1 class="m-0 text-dark">Editar anuncio</h1>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stop

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                        <strong>¡Revise los campos!</strong>
                        @foreach ($errors->all() as $error)
                            <span class="badge badge-danger">{{ $error }}</span>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- ------------------------------inicio formulario------------------------------------ --}}
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card card-primary">

                            <form method="POST" action="{{ route('anuncios.update', $anuncio->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">

                                    {{-- input para seleccionar categoria --}}
                                    <div {{-- class="form-group" --}}>
                                        <label {{-- for="padre_id" --}}>Categoria:</label>
                                        <select class="form-select" aria-label="Default select example" name="categoria_id"
                                            required>
                                            <option selected>Seleccionar</option>

                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" required>{{ $categoria->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    {{-- input para titulo --}}
                                    <div {{-- class="form-group" --}}>
                                        <label {{-- for="nombre" --}}>Título:</label>
                                        <input type="text" class="form-control {{-- {{ $errors->has('nombre') ? 'is-invalid' : '' }} --}}"
                                            {{-- id="nombre" --}} name="titulo" placeholder="" required
                                            value="{{ old('titulo', $anuncio->titulo) }}">
                                        {{-- @if ($errors->has('nombre'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('nombre') }}
                                            </div>
                                        @endif --}}
                                    </div>

                                    {{-- input para precio --}}
                                    <div>
                                        <label for="">Precio</label>
                                        <input type="text"class="form-control" name="precio"
                                            id=""value="{{ old('precio', $anuncio->precio) }}" required>
                                    </div>

                                    {{-- input para moneda --}}
                                    <div>
                                        <label>Moneda:</label>
                                        <select class="form-select" name="moneda_id" required>
                                            <option selected>Seleccionar</option>
                                            @foreach ($monedas as $moneda)
                                                <option value="{{ $moneda->id }}">{{ $moneda->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- input para descripcion --}}
                                    <br>
                                    <div>
                                        <label for="">Descripción</label>
                                        {{-- <input type="textarea" class="form-control" name="descripcion"
                                            id=""value="{{ old('precio') }}">> --}}

                                        <textarea name="descripcion" class="form-control" id="" cols="" rows="5"required>{{ old('descripcion', $anuncio->descripcion) }}</textarea>
                                    </div>

                                    {{-- input para condicion --}}
                                    <div>
                                        <label>Condición:</label>
                                        <select class="form-select" name="condicion_id">
                                            <option selected value="">Seleccionar
                                            </option>
                                            @foreach ($condiciones as $condicion)
                                                <option value="{{ $condicion->id }}">{{ $condicion->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- input para imagen --}}
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Carga una imagen a tu anuncio:</label>
                                        <input class="form-control" type="file" id="formFile" name="formFile"
                                            {{-- accept="image/*" --}}>
                                    </div>

                                    <div class="image-wrapper">
                                        <img src="{{ Storage::url($anuncio->imagen->url) }}"
                                            class="rounded mx-auto d-block" alt="" id="picture">
                                    </div>
                                </div>
                                {{-- botones --}}
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a class="btn btn-default" href="{{ route('anuncios.index') }}">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

    <style>
        .image-wrapper {
            position: relative;
            padding-bottom: 56.25%;
        }

        .image-wrapper img {
            position: absolute;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
@stop