
@extends('templates.principal')

@section('title') Analisar Solicitações @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>ANALISAR SOLICITAÇÕES</h2>
    </div>

    @if(session()->has('inputNULL'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{session('inputNULL')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

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
                <th scope="col" style="padding-left: 10px">Requerente</th>
                <th scope="col" style="padding-left: 10px">Material</th>
                <th scope="col" style="padding-left: 10px">Situação</th>
                <th scope="col" style="text-align: center">Data</th>
            </tr>
        </thead>


        <tbody>
            @if (count($dados) > 0 && count($materiaisPreview) > 0)
                @for ($i = 0; $i < count($dados); $i++)
                    <tr data-id="{{ $dados[$i]->solicitacao_id }}" style="cursor: pointer">
                        <td class="expandeOption">{{ $dados[$i]->nome }}</td>
                        <td class="expandeOption">{{ $materiaisPreview[$i] }}...</td>
                        <td class="expandeOption">
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-clock-history" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            {{ $dados[$i]->status }}
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                            </svg>
                        </td class="expandeOption">
                        <td class="expandeOption" style="text-align: center">{{ date('d/m/Y',  strtotime($dados[$i]->created_at))}}</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>

    <form method="POST" id="formSolicitacao" name="formSolicitacao" action="{{ route('analise.solicitacao') }}">
        @csrf
        <div class="modal fade" id="detalhesSolicitacao" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalLabel" style="color:#151631">Solicitação - <span id="numSolicitacao"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div id="overlay">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem" role="status"></div>
                        </div>
                    </div>
                    <div id="modalBody" style="display: none">
                        <table id="tableItens" class="table table-hover table-responsive-md" style="margin-top: 10px">
                            <thead style="background-color: #151631; color: white; border-radius: 15px">
                                <tr>
                                    <th class="align-middle" scope="col">Material</th>
                                    <th class="align-middle" scope="col">Descrição</th>
                                    <th class="align-middle" scope="col" style="text-align: center; width: 5%">Unidade</th>
                                    <th class="align-middle" scope="col" style="text-align: center; width: 10%">Qtd. Solicitada</th>
                                    <th class="align-middle" scope="col" style="text-align: center; width: 10%">Qtd. Estoque</th>
                                    <th class="align-middle" scope="col" style="text-align: center; width: 10%">Qtd. Aprovada</th>
                                </tr>
                            </thead>
                            <tbody id="listaItens"></tbody>
                        </table>
                        <div id="observacaoRequerente">
                            <label for="textObservacaoRequerente"><strong>Observações do Requerente:</strong></label>
                            <textarea class="form-control" name="observacaoRequerente" id="textObservacaoRequerente" cols="30" rows="3" readonly></textarea>
                        </div>
                        <div id="observacaoAdmin" style="margin-top: 10px; margin-bottom: 10px">
                            <label for="textObservacaoAdmin"><strong>Observações do Administrador:</strong></label>
                            <textarea class="form-control" name="observacaoAdmin" id="textObservacaoAdmin" cols="30" rows="3"></textarea>
                        </div>
                        <strong>Dados do Solicitante:</strong>
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

                    <button id="negaSolicitacao" style="display: none" name="action" type="submit" class="btn btn-danger" value="nega" disabled>Negar</button>
                    <button id="aprovaSolicitacao" style="display: none" name="action" type="submit" class="btn btn-success" value="aprova" disabled>Aprovar</button>
                </div>
              </div>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script type="text/javascript" src="{{asset('js/solicitacoes/analise.js')}}"></script>
