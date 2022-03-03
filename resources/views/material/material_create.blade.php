@extends('templates.principal')

@section('title') Cadastrar Material @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>CADASTRAR MATERIAL</h2>
    </div>

    <form method="POST" action="{{ route('material.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="imagem"> Selecione uma imagem </label>
                <input class="form-control-file @error('imagem') is-invalid @enderror" type="file"
                    name="imagem" id="imagem" accept=".png, .jpg, .jpeg, .svg, .dib, .bmp" />
                @error('imagem')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="nomeMaterial">Material</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nomeMaterial"
                    name="nome" placeholder="Material" autofocus autocomplete="nomeMaterial" min="1" maxlength="100" value="{{ old('nome') }}" required/>
                @error('nome')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="codigoMaterial">Código</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigoMaterial"
                    name="codigo" min="1" maxlength="20" placeholder="Código" value="{{ old('codigo') }}" autofocus required/>
                @error('codigo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="materialQuantidade">Quantidade mínima</label>
                <input type="text" class="form-control @error('quantidade_minima') is-invalid @enderror" id="materialQuantidade"
                    name="quantidade_minima" autofocus min="1" value="{{ old('quantidade_minima') }}" required />
                @error('quantidade_minima')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div  >
            <div class="form-group col-md-12" class="form-row" style="border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0; margin-bottom: 20px">
                <label for="materialDescricao">Descrição</label>
                <textarea class="form-control @error('descricao') is-invalid @enderror" autofocus min="1" max="255"
                    name="descricao" id="materialDescricao" cols="30" rows="3" required>{{ old('descricao') }}</textarea>
                @error('descricao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>

                @enderror
            </div>
        </div>
        <Button class="btn btn-secondary" type="button" onclick="if(confirm('Tem certeza que deseja Cancelar o cadastro do Material?')) location.href = '../' "> Cancelar </Button>
        <button type="submit" class="btn btn-success">Salvar</button>
      </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/CheckFields.js')}}"></script>
