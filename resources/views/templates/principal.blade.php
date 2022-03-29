<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almoxarifado - @yield('title')</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('css/templates/principal.css')}}" rel="stylesheet"/>

    <script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js/jquery-mask-plugin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
            integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
            crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="{{asset('js/templates/principal.js')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body style="background-color: #151631">

<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;">
    <ul id="menu-barra-temp" style="list-style:none;">
        <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
            <a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a>
        </li>
        <li>
            <a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a>
        </li>
    </ul>
</div>

@include('templates.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2" style="background-color: #151631; color: white; height: 550px;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{asset('imagens/logo.png')}}"
                     style="width:200px; margin-top:5px; margin-bottom:-5px; margin-left:10px; margin-right:30px;">
            </a>
            @auth
                @if(Auth::user()->hasVerifiedEmail())
                    @auth
                        @if (Auth::user()->cargo_id == 1)
                            @include('templates.painel.requerente')
                        @endif
                    @endauth
                    @auth
                        @if(Auth::user()->cargo_id == 2)
                            @include('templates.painel.admin')
                        @endif
                    @endauth
                    @auth
                        @if (Auth::user()->cargo_id == 3)
                            @include('templates.painel.diretoria')
                        @endif
                    @endauth
                        @auth
                        @if (Auth::user()->cargo_id == 4)
                            @include('templates.painel.terceirizado')
                        @endif
                    @endauth
                @endif
            @endauth
            @guest
                <div style="margin-top: 10px">
                    <a type="button" style="color: white; text-decoration: none; display: block"
                    href="{{ route('login') }}">
                        <div class="menuEffect" id="consultaSolicitacao" style="padding: 10px">
                            <h6 class="mb-0">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-box-arrow-in-right"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                    <path fill-rule="evenodd"
                                        d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                Entrar
                            </h6>
                        </div>
                    </a>
                </div>
                <div>
                    <a type="button" style="color: white; text-decoration: none; display: block"
                    href="{{ route('register') }}">
                        <div class="menuEffect" id="consultaSolicitacao" style="padding: 10px">
                            <h6 class="mb-0">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-plus"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                Cadastrar-se
                            </h6>
                        </div>
                    </a>
                </div>
                @else
                    <div>
                        <a type="button" style="color: white; text-decoration: none; display: block"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); sessionStorage.clear(); document.getElementById('logout-form').submit();">
                            <div class="menuEffect" id="consultaSolicitacao" style="padding: 10px">
                                <h6 class="mb-0">
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-box-arrow-in-left"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                                        <path fill-rule="evenodd"
                                            d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                                    </svg>
                                    Sair
                                </h6>
                            </div>
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
        </div>
        <div class="col-10" style="background-color: #1b1c42; ">
            <div class="container" style="background-color: white;margin-top: 30px; padding: 20px;border-radius: 15px">
                @yield('content')
                @yield('post-script')
            </div>
        </div>
    </div>
</div>

@include('templates.rodape')
</body>
</html>
