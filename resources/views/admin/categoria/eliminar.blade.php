@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Eliminar Categorias de Moodle</h1>
@stop

@section('content')
@php
    foreach (json_decode($ecategoria) as $cat) {
    }
@endphp
<div class="card">
  <div class="card-header">
    Eliminar Categoría
  </div>
  <div class="card-body">
    <form action="{{route('admin.categorias.eliminar', $cat->id)}}" method="POST">
        @csrf
        @if ($contador != 1 or $contador2 != 0)
            <h3>Esta categoría: tiene Subcategorias o Cursos</h3>
            <div class="mb-3">
                <label for="scategoria" class="form-label">Elegir opción</label>
                <select class="form-select" aria-label="Default select example" id="recursive" name="recursive">
                        <option value="1" selected>Eliminar todo el contenido</option>
                        <option value="0" selected>Trasladar el contenido a otra categoría</option>
                  </select>
            </div>
            <div class="mb-3">
                <label for="scategoria" class="form-label">Elegir categoría donde se va a trasladar</label>
                <select class="form-select" aria-label="Default select example" id="newparent" name="newparent">
                
                @foreach (json_decode($categorias) as $item)
                @php $valor = false; @endphp
                    @foreach (json_decode($scategoria) as $item2)
                        @if ($item->id == $item2->id)
                            @php
                                $valor = true;
                            @endphp
                        @endif
                    @endforeach
                        @if ($valor == false)
                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                        @endif
                @endforeach
                  </select>
            </div>
        @else
            <input name="recursive" type="hidden" value="1">
            <input name="newparent" type="hidden" value="0">
            <h3>Esta categoría: no tiene contenido</h3>
        @endif
        <button type="submit" class="btn btn-danger">Eliminar Categoría</button>
        <a class="btn btn-secondary" href="{{route('admin.categorias.index')}}" role="button">Cancelar</a>
    </form>
  </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop