<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/vista', function () {
    $datos = ['curso' => 'Desarrollo con Laravel', 'codigo' => 71994, 'inicio' => '04/11/2024'];
    $nombre = 'Jose Luis';
    $numero = 52;
    return view('vista',[
        'nombre' => $nombre,
        'numero' => $numero,
        'datos' => $datos
    ]);
});
Route::get('/hola', function () {
    return 'Hola Mundo de Laravel';
});
Route::view( '/nav', 'navbar');
Route::view('/hero','hero');
Route::get('/proveedores',function (){
    $proveedores=\Illuminate\Support\Facades\DB::select('SELECT * FROM proveedores');

    return view('proveedores',['proveedores'=>$proveedores]);
});
