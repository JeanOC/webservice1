@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Categorias de Moodle</h1>
@stop

@section('content')
@php
    foreach (json_decode($ecategoria) as $cat) {
    }
@endphp
<div class="card">
  <div class="card-header">
    Editar Categoría
  </div>
  <div class="card-body">
    <form action="{{route('admin.categorias.update', $cat->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="scategoria" class="form-label">Nombre de la Categoría</label>
            <select class="form-select" aria-label="Default select example" id="scategoria" name="scategoria">
                @if ($cat->parent == 0)
                    <option value="0" selected>Superior</option>
                @else
                    <option value="0">Superior</option>
                @endif
                @foreach (json_decode($categorias) as $item)
                @if ($item->id == $cat->parent)
                    <option value="{{$item->id}}" selected>{{$item->name}}</option>
                @else
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endif
                @endforeach
              </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$cat->name}}">
            @error('name')
                <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        <div class="mb-3">
            <label for="idnumber" class="form-label">idnumber</label>
            <input type="text" class="form-control" id="idnumber" name="idnumber" value="{{$cat->idnumber}}">
            @error('idnumber')
                <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3">
                {{$cat->description}}
            </textarea>
            @error('description')
                <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Modificar Categoría</button>
            <a class="btn btn-secondary" href="{{route('admin.categorias.index')}}" role="button">Cancelar</a>
        </div>
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