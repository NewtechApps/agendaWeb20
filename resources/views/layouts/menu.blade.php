   
   <nav class="navbar navbar-expand-sm sticky-top navbar-dark bg-dark min-height:0px">
      <div class="collapse navbar-collapse"  id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
               <a class="navbar brand" style="padding-top: 0px;">
               <img src="{{ asset('images/favicon.png') }}" class="rounded" height='27' style="background-color: white">
               </a>
            </li>



            <li class="nav-item active">
               <a class="nav-link" href=" {{ url('/home') }}">Home</a>
            </li>


            @foreach($rotinas as $rotina)

                @switch($rotina->id_rotina)
                @case(1)
                     <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $rotina->nome }}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <a class="dropdown-item" href="{{ action('perfilUsuarioController@index') }}">Perfil de Usuário</a>
                           <a class="dropdown-item" href="{{ action('tipoServicoController@index') }}">Linha de Atuação</a>
                           <a class="dropdown-item" href="{{ action('usuarioController@index') }}">Usuários</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="{{ action('empresaController@index') }}">Empresas do Grupo</a>
                        </ul>
                     </li>
                     @break
                @case(2)
                     <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $rotina->nome }}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <a class="dropdown-item"  href="{{ action('tipoAgendaController@index') }}">Tipo de Agenda</a>
                           <a class="dropdown-item"  href="{{ action('feriadosController@index') }}">Feriados</a>
                        </ul>
                     </li>
                     @break
                @case(3)
                     <li class="nav-item active">
                        <a class="nav-link" href="{{ action('EventosController@index') }}">{{ $rotina->nome }}</a>
                     </li>
                     @break
                @case(5)
                    <li class="nav-item active">
                        <a class="nav-link" target="blank" href="{{ action('eventosController@dashboard') }}">{{ $rotina->nome }}</a>
                    </li>
                    @break
                @endswitch

            @endforeach

         </ul>



         <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item active dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ Auth::user()->nome }}
               </a>
               <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item text-right" href="{{ url('/update-user') }}">Perfil</a>
                  <a class="dropdown-item text-right" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                  <form id="frm-logout"  action="{{ route('logout') }}" method="POST" style="display: none;">
                     {{ csrf_field() }}
                  </form>
               </ul>
            </li>
            
         </ul>
      </div>
   </nav>


