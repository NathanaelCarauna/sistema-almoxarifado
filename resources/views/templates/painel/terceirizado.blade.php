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
                   href="{{ route('entrega.materiais') }}">
                    <li>Entregar</li>
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
            </div>
        </div>
    </div>
</div>
