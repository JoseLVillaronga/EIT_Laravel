<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/
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
Route::view('/','plantilla');
#################
###CRUD Regiones
Route::get('/regiones',function (){
    //Obtenemos listado regiones
    //$regiones = \Illuminate\Support\Facades\DB::select('SELECT * FROM regiones ORDER BY idRegion DESC');
    $regiones = \Illuminate\Support\Facades\DB::table('regiones')->orderBy('idRegion','DESC')
        ->get();
    //Retornamos la lista regiones
    return view('regiones',['regiones'=>$regiones]);
});
Route::get('/destinos',function (){
   //listado destinos
    $destinos = \Illuminate\Support\Facades\DB::table('destinos as d')
        ->join('regiones as r','d.idRegion','=','r.idRegion')
        ->get();
    //retorna destinos
    return view('destinos',['destinos'=>$destinos]);
});
Route::get('/destino/create',function (){
    $regiones = \Illuminate\Support\Facades\DB::table('regiones')->get();
    return view('destinoCreate',['regiones'=>$regiones]);
});
Route::post('/destino/store',function (){
    //capturamos post
    $aeropuerto = request('aeropuerto');
    $precio = request('precio');
    $idRegion = request('idRegion');
    try {
        /*\Illuminate\Support\Facades\DB::insert('INSER INTO destinos
                                                        (aeropuerto,precio,idRegion)
                                                        VALUE
                                                        (:aeropuerto, :precio, :idRegion ),
                                                        [ $aeropuerto, $precio, $idRegion ]
                                                        ');*/
        \Illuminate\Support\Facades\DB::table('destinos')
                                                ->insert([
                                                    'aeropuerto'=>$aeropuerto,
                                                    'precio'=>$precio,
                                                    'idRegion'=>$idRegion,
                                                    'activo'=>1
                                                ]);
        return redirect('/destinos')
            ->with([
                'css'=>'green',
                'mensaje'=>'Destino: '.$aeropuerto.' agregado correctamente'
            ]);
    }catch(Throwable $th){
        return redirect('/destinos')
            ->with([
                'css'=>'red',
                'mensaje'=> $th->getMessage()
            ]);
    }
});
//Regiones
Route::get('/region/create',function (){
    return view('regionCreate');
});
Route::post('/region/store',function (){
    //capturamos post
    $nombre = request('nombre');
    try {
        \Illuminate\Support\Facades\DB::table('regiones')
            ->insert([
                'nombre'=>$nombre
            ]);
        return redirect('/regiones')
            ->with([
                'css'=>'green',
                'mensaje'=>'Region: '.$nombre.' agregado correctamente'
            ]);
    }catch(Throwable $th){
        return redirect('/regiones')
            ->with([
                'css'=>'red',
                'mensaje'=> $th->getMessage()
            ]);
    }
});
Route::get('/destino/edit/{idDestino}',function ($idDestino){
    //dd($idDestino);
    //Obtenemos listado regiones
    $regiones=\Illuminate\Support\Facades\DB::table('regiones')->get();
    //Obtener destino por id
    $destino=\Illuminate\Support\Facades\DB::table('destinos')
                                                ->where('idDestino','=',$idDestino)
                                                ->first();
    //Retornar vista
    return view('regionEdit',[
        'regiones'=>$regiones,
        'destino'=>$destino
    ]);
});
Route::post('/destino/update',function (){
    $aeropuerto = request('aeropuerto');
    $precio = request('precio');
    $idRegion = request('idRegion');
    $idDestino = request('idDestino');
    try {
        \Illuminate\Support\Facades\DB::table('destinos')
            ->where('idDestino',$idDestino)
            ->update([
                'aeropuerto'=>$aeropuerto,
                'precio'=>$precio,
                'idRegion'=>$idRegion
            ]);
        return redirect('/destinos')->with([
            'css'=>'green',
            'mensaje'=>'Destino: '.$aeropuerto.' modificado correctamente'
        ]);
    }catch (Throwable $th){
        return redirect('/destinos')
            ->with([
                'css'=>'red',
                'mensaje'=> 'No se pudo modificar el destino'.$aeropuerto.' error ('.$th->getMessage().')'
            ]);
    }
});
Route::get('/destino/delete/{idDestino}',function ($idDestino){
    //dd($idDestino);
    //Obtenemos listado regiones
    //$regiones=\Illuminate\Support\Facades\DB::table('regiones')->get();
    //Obtener destino por id
    $destino=\Illuminate\Support\Facades\DB::table('destinos as d')
        ->where('idDestino','=',$idDestino)
        ->join('regiones as r', 'd.idRegion', '=', 'r.idRegion' )
        ->first();
    //Retornar vista
    return view('destinoDelete',[
        //'regiones'=>$regiones,
        'destino'=>$destino
    ]);
});
Route::post('/destino/destroy',function (){
    $idDestino = request('idDestino');
    $aeropuerto = request('aeropuerto');
    try {
        \Illuminate\Support\Facades\DB::table('destinos')->where('idDestino',$idDestino)->delete();
        return redirect('/destinos')->with([
            'css'=>'green',
            'mensaje'=>'Destino: '.$aeropuerto.' eliminado correctamente'
        ]);
    }catch (Throwable $th){
        return redirect('/destinos')
            ->with([
                'css'=>'red',
                'mensaje'=> 'No se pudo eliminar el destino'.$aeropuerto.' error ('.$th->getMessage().')'
            ]);
    }
});

