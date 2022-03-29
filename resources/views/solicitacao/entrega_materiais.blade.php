@extends('templates.principal')

@section('title') Entrega de Materiais @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>ENTREGAR MATERIAIS</h2>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <h6>Clique em uma linha na tabela para visualizar uma amostra dos materiais da solicitação.</h6>
    <h6>Para ver todos os materiais e aprovar/cancelar uma entrega clique em uma linha da tabela subsequente.</h6>

    <table id="tableSolicitacoes" class="table table-hover table-responsive-md" style="margin-top: 10px;">
        <thead style="background-color: #151631; color: white; border-radius: 15px">
        <tr>
            <th scope="col" class="align-middle" style="padding-left: 10px">Requerente</th>
            <th scope="col" class="align-middle" style="padding-left: 10px">Material</th>
            <th scope="col" class="align-middle">Situação</th>
            <th scope="col" class="align-middle" style="text-align: center">Data</th>
        </tr>
        </thead>
        <tbody>
        @if (count($dados) > 0 && count($materiaisPreview) > 0)
            @for ($i = 0; $i < count($dados); $i++)
                <tr data-id="{{ $dados[$i]->solicitacao_id }}" style="cursor: pointer">
                    <td class="expandeOption">{{ $dados[$i]->nome }}</td>
                    <td class="expandeOption">{{$materiaisPreview[$i]}}...</td>
                    <td class="expandeOption">
                        @if ($dados[$i]->status == "Aprovado")
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check-circle"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd"
                                      d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                            </svg>
                        @endif
                        @if ($dados[$i]->status == "Aprovado Parcialmente")
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check2-circle"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                <path fill-rule="evenodd"
                                      d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
                            </svg>
                        @endif
                        {{ $dados[$i]->status }}
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                        </svg>
                    </td>
                    <td class="expandeOption"
                        style="text-align: center">{{ date('d/m/Y',  strtotime($dados[$i]->created_at))}}</td>
                </tr>
            @endfor
        @endif
        </tbody>
    </table>

    <form method="POST" id="formSolicitacao" name="formSolicitacao" action="{{ route('entrega.materiais') }}">
        @csrf
        <div class="modal fade" id="detalhesSolicitacao" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel" style="color:#151631">Solicitação - <span
                                id="numSolicitacao"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="overlay">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" style="width: 5rem; height: 5rem"
                                     role="status"></div>
                            </div>
                        </div>
                        <div id="modalBody" style="display: none">
                            <table id="tableItens" class="table table-hover table-responsive-md"
                                   style="margin-top: 10px">
                                <thead style="background-color: #151631; color: white; border-radius: 15px">
                                <tr>
                                    <th scope="col" class="align-middle">Material</th>
                                    <th scope="col" class="align-middle">Descrição</th>
                                    <th scope="col" class="text-center align-middle">Localização</th>
                                    <th scope="col" style="text-align: center; width: 10%">Qtd. Solicitada</th>
                                    <th scope="col" style="text-align: center; width: 10%">Qtd. Aprovada</th>
                                </tr>
                                </thead>
                                <tbody id="listaItens"></tbody>
                            </table>
                            <div id="observacaoRequerente">
                                <label for="textObservacaoRequerente"><strong>Observações do
                                        Requerente:</strong></label>
                                <textarea class="form-control" name="observacaoRequerente" id="textObservacaoRequerente"
                                          cols="30" rows="3" readonly></textarea>
                            </div>
                            <div id="observacaoAdmin" style="margin-top: 10px; margin-bottom: 10px">
                                <label for="textObservacaoAdmin"><strong>Observações do Administrador:</strong></label>
                                <textarea class="form-control" name="observacaoAdmin" id="textObservacaoAdmin" cols="30"
                                          rows="3" readonly></textarea>
                            </div>
                            <strong style="margin-top: 10px">Dados do Solicitante:</strong>
                            <div class="form-row" style="margin-top: 5px">
                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputNomeReceptor">Nome</label>
                                        <input type="text" class="form-control" id="inputNomeReceptor" value=""
                                               readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputRgReceptor">RG</label>
                                    <input type="text" class="form-control" value="" id="inputRgReceptor" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputRgReceptor">Tipo</label>
                                    <input type="text" class="form-control" id="inputTipoReceptor" name="tipoReceptor" value=""
                                            readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="solicitacaoID" name="solicitacaoID" value="">

                        <button id="cancelar_entrega" style="display: none" name="action" type="submit"
                                class="btn btn-danger" value="cancelar_entrega">Cancelar
                        </button>
                        <button id="aprovar_entrega" style="display: none" name="action" type="submit"
                                class="btn btn-success" value="aprovar_entrega">Aprovar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script type="text/javascript" src="{{asset('js/solicitacoes/entrega.js')}}"></script>
