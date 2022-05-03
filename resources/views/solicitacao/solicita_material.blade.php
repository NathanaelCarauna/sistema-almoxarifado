@extends('templates.principal')

@section('title') Solicitar Material @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>SOLICITAR MATERIAL</h2>
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

    <div id="error" class="alert alert-danger" role="alert" style="margin-top: 10px; display: none">
        Informe o material e a quantidade!
    </div>

    <div id="remocaoSuccess" class="alert alert-success" role="alert" style="margin-top: 10px; display: none">
        Material removido!
    </div>

    <div id="editSuccess" class="alert alert-success" role="alert" style="margin-top: 10px; display: none">
        Material Editado!
    </div>

    <div style="background-color: #D7D7E6">
        <div class="form-row" style="margin-left: 10px">
            <div class="form-group col-md-4">
                <label for="selectMaterial" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Material</label>
                <select id="selectMaterial" class="selectMaterial" class="form-control" style="width: 95%;">
                    <option></option>
                    @foreach($materiais as $material)
                        <option value="{{$material->id}}">{{$material->codigo}} - {{ $material->nome }} </option>
                    @endforeach
                </select>
            </div>
            @foreach($materiais as $material)
                <input type="hidden" id="unidade_{{$material->id}}" value="{{$material->unidade}}">
            @endforeach
            <div class="form-group col-md-2">
                <label for="quantMaterial" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Quantidade</label>
                <input type="text" min="1" class="form-control" id="quantMaterial" name="quantidade" value="{{ old('quantidade') }}">
            </div>
            <div class="form-group">
                <button id="addTable" style="margin-top: 30px; margin-left: 10px" class="btn btn-primary" onclick="addTable()">Adicionar</button>
            </div>
        </div>
    </div>

    <form method="POST" id="formSolicitacao" name="formSolicitacao" action="{{ route('solicita.store') }}">
        @csrf
        <table id="tableMaterial" class="table table-hover table-responsive-md" style="margin-top: 10px">
            <thead style="background-color: #151631; color: white; border-radius: 15px">
            <tr>
                <th scope="col">Material</th>
                <th scope="col" style="text-align: center">Quantidade</th>
                <th scope="col" style="text-align: center">Unidade</th>
                <th scope="col" style="text-align: center">Ações</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
        <label style="margin-top: 10px"><strong>Receptor</strong></label>
        <div class="form-check" style="margin-bottom: 10px">
            <input type="checkbox" class="form-check-input" id="checkReceptor" name="checkReceptor" checked>
            <label class="form-check-label" for="checkReceptor">Eu sou o receptor</label>
        </div>
        <div class="form-row" style="padding: 0 0 0 0;">
            <div class="form-group col-md-4">
                <div class="form-group">
                    <label for="inputNomeReceptor">Nome</label>
                    <input type="hidden" id="nomeReceptor" name="nomeReceptor" value="{{Auth::user()->nome}}">
                    <input type="text" class="form-control" id="inputNomeReceptor" onkeypress="return onlyLetters(event,this);" maxlength="100" name="nomeReceptor" value="{{Auth::user()->nome}}"
                           disabled="true">
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="inputRgReceptor">RG</label>
                <input type="hidden" id="rgReceptor" name="rgReceptor" value="{{Auth::user()->rg}}">
                <input type="text" min="1" maxlength="11" class="form-control" id="inputRgReceptor" name="rgReceptor" value="{{Auth::user()->rg}}" disabled="true">
            </div>
            <div class="form-group col-md-3">
                <label for="inputRgReceptor">Tipo</label>
                <select class="form-control" id="inputTipoReceptor" name="tipoReceptor" disabled="true">
                    <option id="tipoServidor" value="Servidor" selected>Servidor</option>
                    <option id="tipoAluno" value="Aluno">Aluno</option>
                    <option id="tipoTerceirizado" value="Terceirizado">Terceirizado</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-12" class="form-row" style="border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0;">
            <label for="inputObservacao"><strong>Observações:</strong></label>
            <textarea class="form-control" name="observacao" id="inputObservacao" cols="30" rows="3">{{ old('observacao') }}</textarea>
        </div>

        <input type="hidden" id="dataTableMaterial" name="dataTableMaterial" value="">
        <input type="hidden" id="dataTableQuantidade" name="dataTableQuantidade" value="">

        <Button class="btn btn-secondary" type="button" onclick="location.href = '../' "> Cancelar</Button>
        <button id="solicita" class="btn btn-success" disabled onclick="return setValuesRowInput()">Solicitar</button>
    </form>

    <div class="modal fade" id="detalhesSolicitacao" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel" style="color:#151631">Editar Solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalBody">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="selectMaterialEdit" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700;">Material</label>
                                <select id="selectMaterialEdit" style="width: 110%;" class="selectMaterial" class="form-control" name="selectMaterialEdit">
                                    <option></option>
                                    @foreach($materiais as $material)
                                        <option value="{{$material->id}}"> {{$material->codigo}} - {{ $material->nome }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" id="unidade_selected" value="">
                            <div class="form-group col-md-2" style="margin-left: 4%">
                                <label for="InputQuantEdit" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Quantidade</label>
                                <input type="number" min="1" onkeypress="return onlyNums(event,this);" class="form-control" id="InputQuantEdit" name="InputQuantEdit" value="{{ old('quantidade') }}">
                            </div>
                            <div class="form-group">
                                <button id="updateMaterial" style="margin-top: 30px; margin-left: 10px" class="btn btn-primary" onclick="confirmarAlteracao()">Atualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script type="text/javascript" src="{{asset('js/solicitacoes/solicita_material.js')}}"></script>
