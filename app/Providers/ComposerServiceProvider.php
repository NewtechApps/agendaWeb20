<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;


class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        // Composers diversos
        view()->composer(['cadastros.perfil.index',
                          'cadastros.usuario.index',
                          'cadastros.empresas.index',
                          'cadastros.tipoServico.index',
                          'cadastros.tipoAgenda.index',
                          'cadastros.eventos.index',
                          'cadastros.eventos.dashboard',
                          'cadastros.feriados.index',
                          'auth.update',
                          'home'],

                          'App\Http\Views\GeneralViewComposer@menu');


        view()->composer(['cadastros.eventos.index',
                          'cadastros.usuario.index'],
                          'App\Http\Views\GeneralViewComposer@empresas');

        view()->composer(['cadastros.usuario.index'],
                          'App\Http\Views\GeneralViewComposer@tiposServico');

        view()->composer(['cadastros.eventos.index',
                          'cadastros.eventos.dashboard'],
                          'App\Http\Views\GeneralViewComposer@tiposAgenda');

        view()->composer(['cadastros.eventos.index'],
                          'App\Http\Views\GeneralViewComposer@usuarios');

        view()->composer(['cadastros.eventos.index'],
                          'App\Http\Views\GeneralViewComposer@feriados');
  
  
    }
}
