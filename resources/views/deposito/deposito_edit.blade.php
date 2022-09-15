
@extends('../templates.principal')

@section('title')
    Editar Depósito
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>EDITAR DEPÓSITO</h2>
    </div>

    @if(session()->has('fail'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{session('fail')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <form action="{{ route('deposito.update', $deposito->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-row" style="border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0; margin-bottom: 20px">
            <div class="form-group col-md-3">
                <label for="nomeDeposito">Nome do depósito</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" autofocus id="nomeDeposito"
                    name="nome" placeholder="Depósito" value="{{ old('nome', $deposito->nome) }}" min="3" maxLength="50" required/>
                @error('nome')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2" >
                <label for="depositoCodigo">Código</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" autofocus id="depositoCodigo"
                    name="codigo" placeholder="Código" value="{{ old('codigo', $deposito->codigo) }}" min="1" maxLength="20" required/>
                @error('codigo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="col-sm-auto">
                <Button class="btn btn-secondary" type="button" onClick="if(confirm('Tem certeza que deseja cancelar a Alteração do Deposito?'))location.href='../'"> Cancelar </Button>
            </div>
            <div class="col-sm-auto">
                <Button class="btn btn-success" type="submit" onclick="return confirm('Tem certeza que deseja Alterar o Deposito?')"> Atualizar </Button>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/deposito/CheckFields.js')}}"></script>
