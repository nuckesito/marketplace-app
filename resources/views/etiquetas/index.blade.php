@extends('adminlte::page')
@include('components.helpButton')
@section('title', 'Index')

@section('content_header')
    <h1 class="m-0 text-dark">Gestionar Etiquetas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('crear etiqueta')
                <a class="btn btn-dark ml-auto" href="{{ route('etiquetas.create') }}">Nuevo</a>
            @endcan
            <div class="card">
                @php
                    $heads = [
                        'ID',
                        'Name',
                        'Precio (Bolivianos)',
                        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                    ];

                    $config = [
                        'data' => [],
                        'order' => [[1, 'asc']],
                        'columns' => [null, null, null, ['orderable' => false]],
                    ];

                    foreach ($etiquetas as $etiqueta) {
                        $btnEdit =
                            '<a href="' .
                            route('etiquetas.edit', ['etiqueta' => $etiqueta->id]) .
                            '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>';
                        $btnDelete =
                            '<form action="' .
                            route('etiquetas.destroy', ['etiqueta' => $etiqueta->id]) .
                            '" method="POST" class="d-inline">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>';

                        $config['data'][] = [
                            $etiqueta->id,
                            $etiqueta->name,
                            $etiqueta->precio,
                            '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
                        ];
                    }
                @endphp

                {{-- Minimal example / fill data using the component slot --}}
                <x-adminlte-datatable id="table1" :heads="$heads">
                    @foreach ($config['data'] as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>
@stop
