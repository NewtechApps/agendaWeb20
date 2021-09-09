<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () { return view('auth.login'); });
Route::get('/update-user', function() { return view('auth.update'); });
Route::get('/mailMessage', function (){ return view('auth.mailMessage'); });



// Rotas de Cadastros - Perfil do Usuario
Route::group(['prefix' => 'perfilUsuario'], function () {
    Route::get('/'        , 'perfilUsuarioController@index');
    Route::post('create'  , 'perfilUsuarioController@create');
    Route::delete('delete', 'perfilUsuarioController@delete');
});


// Rotas de Cadastros - Usuarios
Route::group(['prefix' => 'usuario'], function () {
    Route::get('/'            , 'usuarioController@index');
    Route::post('store'       , 'usuarioController@store');
    Route::delete('delete'    , 'usuarioController@delete');
    Route::post('updateUser'  , 'usuarioController@updateUser');
    Route::get('empresas/{id}', 'usuarioController@empresas');
});



// Rotas de Cadastros - Linha de Produto
Route::group(['prefix' => 'tipoServico'], function () {
    Route::get('/'      , 'tipoServicoController@index');
    Route::post('create', 'tipoServicoController@create');
    Route::post('status', 'tipoServicoController@status');
    Route::post('delete', 'tipoServicoController@delete');
});


// Rotas de Cadastros - Tipo de Agenda
Route::group(['prefix' => 'tipoAgenda'], function () {
    Route::get('/'      , 'tipoAgendaController@index');
    Route::post('store' , 'tipoAgendaController@store');
    Route::post('status', 'tipoAgendaController@status');
    Route::post('delete', 'tipoAgendaController@delete');
});


// Rotas de Cadastros - Feriados
Route::group(['prefix' => 'feriados'], function () {
    Route::get('/'        , 'feriadosController@index');
    Route::get('consulta' , 'feriadosController@consulta');
    Route::post('create'  , 'feriadosController@create');
    Route::delete('delete', 'feriadosController@delete');
});



// Rotas de Cadastros - Agendas
Route::group(['prefix' => 'eventos'], function () {
    Route::get('/'         , 'EventosController@index');
    Route::post('create'   , 'EventosController@create');
    Route::post('delete'   , 'EventosController@delete');
    Route::post('deleteAll', 'EventosController@deleteAll');
    Route::get('relatorio' , 'EventosController@relatorio');
    Route::get('consulta'  , 'EventosController@consulta')->name('loadEvents');

    Route::get('carregaMultiplasDatas/{id}', function($id){
    return response()->json( DB::table('events')->where('id_evento', '=', $id)->whereNull('deleted_at')->get() );  });

    Route::get('carregaIntervaloDatas/{id}', function($id){
    return response()->json( DB::table('events')->where('id', '=', $id)->whereNull('deleted_at')->get() );  });
});




// Rotas de Cadastros - Empresas
Route::group(['prefix' => 'empresa'], function () {
    Route::get('/'        , 'empresaController@index');
    Route::post('create'  , 'empresaController@create');
    Route::post('update'  , 'empresaController@update');
    Route::delete('delete', 'empresaController@delete');
});

