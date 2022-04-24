@extends('templates.principal')

@section('title') Entrada de Material @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>ENTRADA DE MATERIAL</h2>
    </div>

    <form method="POST" action="{{ route('movimento.entradaStore') }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="selectMaterial">Material</label>
                <select id="selectMaterial" class="selectMaterial @error('material_id') is-invalid @enderror" class="form-control"
                    style="width: 95%;" autofocus name="material_id" required>
                    <option></option>
                    @foreach($materiais as $material)
                        <option value="{{$material->id}}">{{ $material->nome }}[{{$material->codigo}}] - Localização: {{strtoupper('('.$material->corredor.'-'.$material->prateleira.'-'.$material->coluna.')')}}</option>
                    @endforeach
                </select>

                @error('material_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="inputDeposito">Depósito</label>
                <select id="inputDepositol" class="form-control @error('deposito_id') is-invalid @enderror" autofocus name="deposito_id" required>
                    <option></option>
                    @foreach($depositos as $deposito)
                        <option value="{{ $deposito->id }}"> {{ $deposito->id }}. {{$deposito->nome}} </option>
                    @endforeach
                </select>
                @error('deposito_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="materialQuantidade">Quantidade</label>
                <input type="text" class="form-control @error('quantidade') is-invalid @enderror" autofocus id="materialQuantidade"
                    name="quantidade" value="{{ old('quantidade') }}" min="1" required/>
                @error('quantidade')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="materialUnidade">Unidade</label>
                <input type="text" class="form-control" autofocus id="materialUnidade" disabled  value=""/>

                @foreach($materiais as $material)
                    <input id="unidade_{{ $material->id }}" type="hidden" 
                    value="{{ $material->unidade }}">
                @endforeach
            </div>

        </div>
            <div>
                <div class="form-group col-md-12" class="form-row" style="border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0; margin-bottom: 20px">
                    <label for="inputDescricao">Descrição</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" autofocus name="descricao"
                        id="inputDescricao" cols="30" rows="3" min="5" max="255" required>{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>

                    @enderror
                </div>
            </div>
        <input type="hidden" name="operacao" value="0">

        <Button class="btn btn-secondary" type="button" onclick="location.href = '../' "> Cancelar </Button>
        <button class="btn btn-success" type="submit">Registrar Estoque</button>
    </form>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script type="text/javascript" src="{{asset('js/movimento/CheckFields.js')}}"></script>
<script type="text/javascript" src="{{asset('js/movimento/entrada_material.js')}}"></script>

<script>
    $(document).ready(function() 
    {
        var materialUnidade;

        $("#selectMaterial").change(function() 
        {
            materialUnidade = $("#unidade_" + this.value).val();
            $("#materialUnidade").val(materialUnidade)
        });
    });
</script>