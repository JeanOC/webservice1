<?php

use App\Http\Controllers\Admin\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

Route::resource('categorias', CategoriaController::class)->names('admin.categorias');
Route::get('categorias/{id}/veliminar', [CategoriaController::class, 'veliminar'])->name('admin.categorias.veliminar');
Route::post('categorias/{id}/eliminar', [CategoriaController::class, 'eliminar'])->name('admin.categorias.eliminar');