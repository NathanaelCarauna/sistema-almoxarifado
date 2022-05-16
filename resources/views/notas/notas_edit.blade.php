@extends('templates.principal')

@section('title') Cadastrar Notas Fiscais @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>EDITAR NOTA FISCAL</h2>
    </div>

    <form method="POST" action="{{ route('update.nota') }}" enctype="multipart/form-data">
        @csrf

        @include('notas.nota_conteudo')

        <input type="hidden" value="{{$nota->id}}" name="nota_id">

        <div class="form-group row">
            <div class="col-md-6">
                <Button class="btn btn-secondary" type="button"
                        onclick="if(confirm('Tem certeza que deseja Cancelar a alteração da Nota Fiscal?')) location.href = '../' ">
                    Cancelar
                </Button>
                <button type="submit" class="btn btn-success">Atualizar</button>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/CheckFields.js')}}"></script>
