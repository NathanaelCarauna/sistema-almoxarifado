@extends('templates.principal')

@section('title') Cadastrar Notas Fiscais @endsection

@section('content')

    <style>
        th, td {
            text-align: center;
        }

        label {
            font-weight: bolder;
        }
    </style>

    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>NOTA FISCAL - MATERIAIS</h2>
    </div>

    @if(session()->has('sucess'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if(session()->has('fail'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{session('fail')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if(isset($materiais_nota))
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Material</th>
                <th scope="col">Quantidade Entregue</th>
                <th scope="col">Quantidade Total</th>
                <th scope="col">Status</th>
                <th scope="col">Ação</th>
            </tr>
            </thead>
            <tbody>

            @foreach($materiais_nota as $material)
                <tr>
                    <td>
                        {{\App\Material::find($material->material_id)->nome}}
                    </td>
                    <td>{{$material->quantidade_atual}}</td>
                    <td>{{$material->quantidade_total}}</td>
                    <td>@if($material->status == false)
                            <strong class="alert-danger">
                                Pendente
                            </strong>
                        @else
                            <strong class="alert-success">Recebido</strong>
                        @endif</td>
                    <td><a href="{{route('remover_material.nota', $material->id)}}"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ba2020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <!-- Large modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Adicionar Material</button>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADICIONAR MATERIAL A NOTA FISCAL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('adicionar_material.nota') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" value="{{$nota->id}}" name="nota_fiscal_id">

                    <div class="pl-4 pr-4 pt-4">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="material">Selecione o Material</label>
                                <select class="form-select form-control" aria-label="Default select example" id="material" name="material_id">
                                    <option disabled>Selecione um Material</option>
                                    @foreach($materiais as $material)
                                        <option value="{{$material->id}}">{{$material->nome}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-4">
                                <label for="quantidade_total"> Quantidade Total</label>
                                <input class="form-control  @error('inscricao_estadual') is-invalid @enderror" type="text" name="quantidade_total" id="quantidade_total"
                                       maxlength="100" @if(isset($config->inscricao_estadual)) value="{{$config->inscricao_estadual}}"
                                       @else value="{{ old('inscricao_estadual') }}" @endif autocomplete="quantidade_total" autofocus
                                       placeHolder="Insira a quantidade total do material" required>
                                @error('inscricao_estadual')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="valor"> Valor</label>
                                <input class="form-control  @error('valor') is-invalid @enderror" type="text" name="valor" id="valor"
                                       maxlength="100" autocomplete="valor" autofocus
                                       placeHolder="Insira o valor do material" required>
                                @error('valor')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-success" style="width: 100%">Adicionar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/CheckFields.js')}}"></script>
