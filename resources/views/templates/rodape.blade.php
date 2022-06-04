<div id="appRodape" class="navbar-light" style="background-color:#3E3767; padding-bottom:1rem; color:white">
    <div class="container">
        <div class="row justify-content-center"
             style="border-bottom: #949494 2px solid; padding: 10px; font-weight: bold">
            <div class="col-sm-3" align="center">
                <div class="row justify-content-center" style="margin-top:15px;">
                    <div class="col-sm-12 styleItemMapaDoSite" style=" font-family:arial">
                        <a href="{{ route('home') }}">Início</a> |
                        <a href="{{ route('sistema') }}">Sistema</a> |
                        <a href="{{ route('parceria') }}">Parceria</a> |
                        <a href="{{ route('contato') }}">Contato</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-6" align="center">
                <div class="row justify-content-center" style="margin-top:10px; margin-top:1.4rem;">
                    <div class="col-sm-12" id="" style="font-weight:bold; font-family:arial; color:white; margin-left: 18%; margin-bottom: 4%">
                        Desenvolvido por
                    </div>
                    <div style="margin:3px;">
                        <a href="http://lmts.uag.ufrpe.br/" target="blank">
                            <img src="{{ asset('/imagens/logo_lmts.png') }}">
                        </a>
                    </div>
                    <div style="margin-left: 3px">
                        <a href="http://www.upe.br/garanhuns/" target="blank">
                            <img style="width: 100px" src="{{ asset('/imagens/logo_upe.png') }}">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-1" align="center">
                <div class="row justify-content-center" style="margin-top:10px; margin-top:1.4rem;">
                    <div class="col-sm-12" id="" style="font-weight:bold; font-family:arial; color:white">
                        Apoio
                    </div>
                    <div style="margin:3px;">
                        <a href="http://www.uag.ufrpe.br/" target="blank">
                            <img src="{{ asset('/imagens/logo_ufape.png') }}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
