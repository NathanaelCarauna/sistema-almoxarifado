<div id="accordion" class="mt-3">
    <div>
        <a type="button" style="color: white; text-decoration: none; display: block"
                data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            <div class="menuEffect" id="headingOne" style="padding: 10px">
                <h6 class="mb-0">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                        <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                    Solicitações
                </h6>
            </div>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div>
                <a data-target="#collapseOne" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('analise.solicitacoes') }}">
                    <li>Analisar</li>
                </a>
                <a data-target="#collapseOne" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('entrega.materiais') }}">
                    <li>Entregar</li>
                </a>
            </div>
        </div>
    </div>
    <div>
        <a type="button" style="color: white; text-decoration: none; display: block"
            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <div class="menuEffect" id="headingTwo" style="padding: 10px">
                <h6 class="mb-0">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-box"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                       <path fill-rule="evenodd"
                            d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                    </svg>
                    Gerenciar Estoque
                </h6>
            </div>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div>
                <a data-target="#collapseTwo" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('movimento.entradaCreate') }}">
                    <li>Nova Entrada</li>
                </a>
                <a data-target="#collapseTwo" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('movimento.saidaCreate') }}">
                    <li>Nova Saída</li>
                </a>
                <a data-target="#collapseTwo" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('movimento.transferenciaCreate') }}">
                    <li>Nova Transferência</li>
                </a>
            </div>
        </div>
    </div>
    <div>
        <a type="button" style="color: white; text-decoration: none; display: block"
            data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
            aria-controls="collapseThree">
            <div class="menuEffect" id="headingThree" style="padding: 10px">
                <h6 class="mb-0">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                        <path fill-rule="evenodd"
                            d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                    </svg>
                    Consultar
                </h6>
            </div>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div>
                <a data-target="#collapseThree" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('material.index') }}">
                    <li>Materiais</li>
                </a>
                <a data-target="#collapseThree" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('deposito.consultarDeposito') }}">
                    <li>Depósitos</li>
                </a>
                <a data-target="#collapseThree" class="menuEffect selectedMenu" class="selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('solicitacoe.admin') }}">
                    <li>Solicitações</li>
                </a>
                <a data-target="#collapseThree" class="menuEffect selectedMenu" class="selectedMenu"
                   style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                   href="{{route('consult.nota')}}">
                    <li>Notas Fiscais</li>
                </a>
            </div>
        </div>
    </div>
    <div>
        <a type="button" style="color: white; text-decoration: none; display: block"
            data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
            aria-controls="collapseFour">
            <div class="menuEffect" id="headingFour" style="padding: 10px">
                <h6 class="mb-0">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Cadastrar
                </h6>
            </div>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
            <div>
                <a data-target="#collapseFour" class="menuEffect selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('material.create') }}">
                    <li>Material</li>
                </a>
                    <a data-target="#collapseFour" class="menuEffect selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('usuario.create') }}">
                    <li>Usuário</li>
                </a>
                <a data-target="#collapseFour" class="menuEffect selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('deposito.create') }}">
                    <li>Depósito</li>
                </a>
                <a data-target="#collapseFour" class="menuEffect selectedMenu"
                   style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                   href="{{ route('cadastrar.nota') }}">
                    <li>Notas Fiscais</li>
                </a>
            </div>
        </div>
    </div>
    <div>
        <a type="button" style="color: white; text-decoration: none; display: block" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
            <div class="menuEffect" id="headingFive" style="padding: 10px">
                <h6 class="mb-0">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                    Editar
                </h6>
            </div>
        </a>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
            <div>
                <a data-target="#collapseFive" class="menuEffect selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('usuario.index') }}">
                    <li>Editar Usuário</li>
                </a>
                <a data-target="#collapseFive" class="menuEffect selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('material.indexEdit') }}">
                    <li>Editar Material</li>
                </a>
                <a data-target="#collapseFive" class="menuEffect selectedMenu"
                    style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                    href="{{ route('deposito.index') }}">
                    <li>Editar Depósito</li>
                </a>
                <a data-target="#collapseFive" class="menuEffect selectedMenu"
                   style="padding: 10px 10px 10px 35px; color: white; text-decoration: none; display: grid"
                   href="{{route('index.nota')}}">
                    <li>Editar Nota Fiscal</li>
                </a>
            </div>
        </div>
        <div>
            <a type="button" class="selectedMenu" style="color: white; text-decoration: none; display: block" href="{{ route('relatorio.materiais') }}">
                <div class="menuEffect" id="headingSix" style="padding: 10px">
                    <h6 class="mb-0">
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-archive" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        Relatórios
                    </h6>
                </div>
            </a>
        </div>

        <div>
            <a type="button" class="selectedMenu" style="color: white; text-decoration: none; display: block" href="{{ route('config.nota') }}">
                <div class="menuEffect" id="headingSix" style="padding: 10px">
                    <h6 class="mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C8C9CF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        Configurar Nota-Fiscal
                    </h6>
                </div>
            </a>
        </div>
    </div>
</div>
