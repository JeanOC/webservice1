@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Categorias de Moodle</h1>
@stop

@section('content')
@if (session('info'))
  <div class="alert alert-success">
    <strong>  {{session('info')}} </strong>
  </div>
@endif
<div class="card">
  <div class="card-header">
    <a class="btn btn-primary" href="{{route('admin.categorias.create')}}" role="button">Crear Categoría</a>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <tr class="bg-dark">
          <th scope="col">Nombre de la Categoría</th>
          <th scope="col" width="25%">Acciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach (json_decode($categorias) as $item)
        <tr>
          <td>{{$item->name}}</td>
          <td>
            <a class="btn btn-dark" href="{{route('admin.categorias.edit', $item->id)}}" role="button">Editar</a>
            <a class="btn btn-danger" href="{{route('admin.categorias.veliminar', $item->id)}}" role="button">Eliminar</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
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