@extends('templates.principal')

@section('title') Depositos @endsection

@section('content')
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

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>CONSULTAR DEPÓSITOS</h2>
    </div>

    <div  style="float: right">
        <span style="font-weight: bold">Selecione um depósito:</span>
        <select name="selectDeposito" id="selectDeposito">
            <option selected hidden>Escolher depósito</option>
            @foreach($depositos as $d)
                <option value="{{ $d->id }}">{{ $d->id }}. {{$d->nome}} </option>
            @endforeach
        </select>
    </div>

    <table id="tableDepositos" class="table table-hover table-responsive-md" >
        <thead style="background-color: #151631; color: white; border-radius: 15px">
             <tr>
                <th scope="col" style="padding-left: 10px">Material</th>
                <th scope="col" style="text-align: center">Quantidade</th>
                <th scope="col" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody id="listaEstoque"></tbody>
    </table>

@endsection
@section('post-script')
    <script type="text/javascript">
        $('select[name=selectDeposito]').change(function (){
            var deposito_id = $(this).val();

            $.get('/get_estoques/' + deposito_id, function (estoques) {
                $('#listaEstoque').empty();
                $.each(estoques, function (key, value) {
                    $('#listaEstoque').append(`<tr><td>${value.nome}</td><td style=\"text-align: center\">${value.quantidade}</td><td style=\"text-align: center\"><a href="deletar_estoque/${value.id}">Deletar</a><td></tr>`);
                });
            });
        });

    </script>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script type="text/javascript" src="{{asset('js/deposito/consulta.js')}}"></script>
