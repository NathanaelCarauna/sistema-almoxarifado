@extends('templates.principal')

@section('title')
    Notas Fiscais
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>CONSULTAR NOTAS FISCAIS</h2>
    </div>

    @if(session()->has('fail'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{session('fail')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @elseif(session()->has('sucess'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('sucess')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <table id="tableNotas" class="table table-hover table-responsive-md">
        <thead style="background-color: #151631; color: white; border-radius: 15px">
        <tr>
            <th class="align-middle" scope="col" style="padding-left: 10px">Código</th>
            <th class="align-middle" scope="col" style="text-align: center">CNPJ</th>
            <th class="align-middle" scope="col" style="text-align: center">Valor</th>
            <th class="align-middle" scope="col" style="text-align: center; width: 3%">Informações</th>
        </tr>
        </thead>
        <tbody>

        @forelse($notas as $nota)
            <tr>
                <td class="text-left" style="text-align: center"> {{ $nota->codigo }} </td>
                <td style="text-align: center"> {{ $nota->cnpj }} </td>
                <td style="text-align: center"> {{ $nota->valor_nota }} </td>
                <td style="text-align: center">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#notaFiscal{{$nota->id}}">
                        Detalhes
                    </button>
                </td>
            </tr>
        @empty
            <td colspan="2">Sem notas fiscais cadastradas ainda</td>
        @endempty
        </tbody>
    </table>
    @foreach($notas as $nota)
        <div class="modal fade bd-example-modal-lg" id="notaFiscal{{$nota->id}}" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TituloModalLongoExemplo">Nota Fiscal {{$nota->codigo}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="p-3">
                            @include('notas.nota_conteudo',['readOnly' => 1])
                        </div>
                        <div class="form-group row p-3">
                            @php $materialNota = \App\MaterialNotas::where('nota_fiscal_id', $nota->id)->get() @endphp
                            @if(isset($materialNota))
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">Material</th>
                                        <th scope="col">Quantidade Recebidos</th>
                                        <th scope="col">Quantidade Total</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($materialNota as $material)
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
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/nota/index.js')}}"></script>
