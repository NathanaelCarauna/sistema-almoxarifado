@extends('templates.principal')

@section('title') Cadastrar Notas Fiscais @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>CADASTRAR NOTA FISCAL</h2>
    </div>

    <form method="POST" action="{{ route('criar.nota') }}" enctype="multipart/form-data">
        @csrf

        @include('notas.nota_conteudo')

        <div class="form-group row">
            <div class="col-md-2">
                <Button class="btn btn-secondary" type="button"
                        onclick="if(confirm('Tem certeza que deseja Cancelar o cadastro do Material?')) location.href = '../' ">
                    Cancelar
                </Button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </form>


    <div class="modal fade" id="emitenteModal" tabindex="-1" role="dialog" aria-labelledby="emitenteModal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel" style="font-weight: bolder">Adicionar Emitente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_modal">
                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="razao_social">Razao Social<span style="color: red">*</span></label>
                                <input class="form-control" id="razao_social" name="razao_social" value="" placeholder="Digite a Razão Social do emitente">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="inscricao_estadual">Inscrição Estadual</label>
                                <input class="form-control" id="inscricao_estadual" name="inscricao_estadual" value="" placeholder="Digite a Inscrição Estadual do emitente">
                            </div>
                            <div class="col-md-6">
                                <label for="cnpj">CNPJ<span style="color: red">*</span></label>
                                <input class="form-control" id="cnpj_emitente" name="cnpj" value="" placeholder="Digite o CNPJ do emitente">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="submit-emitente">Adicionar Emitente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#form_modal').submit(function (e) {
                e.preventDefault();

                var inscricao_estadual = $("#inscricao_estadual").val();
                var cnpj = $("#cnpj_emitente").val();
                var razao_social = $("#razao_social").val();

                if (cnpj == "" || razao_social == "") {
                    alert('Os campos CNPJ e Razão Social são Obrigatórios!');
                } else {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('adicionar_emitente.nota')}}",
                        data: {'razao_social': razao_social, 'cnpj': cnpj, 'inscricao_estadual': inscricao_estadual},
                        success: function (data) {
                            alert(data.success);
                            $('#emitente').append("<option value='" + data.id + "'>" + data.cnpj + "</option>")
                        }
                    });
                }
            });
        });
    </script>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/CheckFields.js')}}"></script>
