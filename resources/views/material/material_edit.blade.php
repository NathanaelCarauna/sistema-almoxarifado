@extends('templates.principal')

@section('title')
    Editar Material
@endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>EDITAR MATERIAL</h2>
    </div>

    <form method="POST" action="{{ route('material.update', ['material' => $material->id]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="imagem"> Selecione uma imagem </label>
                <input class="form-control-file @error('imagem') is-invalid @enderror" type="file"
                       name="imagem" id="imagem" accept=".png, .jpg, .jpeg, .svg, .dib, .bmp"/>
                @error('imagem')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="nomeMaterial">Material</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nomeMaterial"
                       name="nome" placeholder="Material"
                       autofocus autocomplete="nomeMaterial" min="1" maxlength="100"
                       value="{{ old('nome', $material->nome) }}" required/>
                @error('nome')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="codigoMaterial">Código</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigoMaterial"
                       name="codigo" min="1" maxlength="20" placeholder="Código"
                       value="{{ old('codigo', $material->codigo) }}" autofocus required/>
                @error('codigo')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="materialQuantidade">Quantidade mínima</label>
                <input type="text" class="form-control @error('quantidade_minima') is-invalid @enderror"
                       id="materialQuantidade"
                       name="quantidade_minima" autofocus min="1"
                       value="{{ old('quantidade_minima', $material->quantidade_minima) }}" required/>
                @error('quantidade_minima')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group form-row"
             style="border-top: #cfc5c5 1px solid; border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0; margin-bottom: 20px; padding-top: 20px">
            <div class="col-md-4">
                <label for="corredor">Selecione o Corredor</label>
                <select class="form-control text-center" name="corredor" id="corredor">
                    <option @if($material->corredor == 1) selected @endif value="1">1</option>
                    <option @if($material->corredor == 2) selected @endif value="2">2</option>
                    <option @if($material->corredor == 3) selected @endif value="3">3</option>
                    <option @if($material->corredor == 4) selected @endif value="4">4</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="prateleira">Selecione a Prateleira</label>
                <select class="form-control text-center" name="prateleira" id="prateleira">
                    <option @if($material->prateleira == 'a') selected @endif value="a">A</option>
                    <option @if($material->prateleira == 'b') selected @endif value="b">B</option>
                    <option @if($material->prateleira == 'c') selected @endif value="c">C</option>
                    <option @if($material->prateleira == 'd') selected @endif value="d">D</option>
                    <option @if($material->prateleira == 'e') selected @endif value="e">E</option>
                    <option @if($material->prateleira == 'f') selected @endif value="f">F</option>
                    <option @if($material->prateleira == 'g') selected @endif value="g">G</option>
                    <option @if($material->prateleira == 'h') selected @endif value="h">H</option>
                    <option @if($material->prateleira == 'i') selected @endif value="i">I</option>
                    <option @if($material->prateleira == 'j') selected @endif value="j">J</option>
                    <option @if($material->prateleira == 'k') selected @endif value="k">K</option>
                    <option @if($material->prateleira == 'l') selected @endif value="l">L</option>
                    <option @if($material->prateleira == 'm') selected @endif value="m">M</option>
                    <option @if($material->prateleira == 'n') selected @endif value="n">N</option>
                    <option @if($material->prateleira == 'o') selected @endif value="o">O</option>
                    <option @if($material->prateleira == 'p') selected @endif value="p">P</option>
                    <option @if($material->prateleira == 'q') selected @endif value="q">Q</option>
                    <option @if($material->prateleira == 'r') selected @endif value="r">R</option>
                    <option @if($material->prateleira == 's') selected @endif value="s">S</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="coluna">Selecione a Coluna</label>
                <select class="form-control text-center" name="coluna" id="coluna">
                    <option @if($material->coluna == 1) selected @endif value="1">1</option>
                    <option @if($material->coluna == 2) selected @endif value="2">2</option>
                    <option @if($material->coluna == 3) selected @endif value="3">3</option>
                    <option @if($material->coluna == 4) selected @endif value="4">4</option>
                    <option @if($material->coluna == 5) selected @endif value="5">5</option>
                    <option @if($material->coluna == 6) selected @endif value="6">6</option>
                    <option @if($material->coluna == 7) selected @endif value="7">7</option>
                    <option @if($material->coluna == 8) selected @endif value="8">8</option>
                    <option @if($material->coluna == 9) selected @endif value="9">9</option>
                </select>
            </div>
        </div>

        <div div class="form-group col-md-12" class="form-row"
             style="border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0; margin-bottom: 20px">
            <label for="materialDescricao">Descrição</label>
            <textarea class="form-control @error('descricao') is-invalid @enderror" autofocus min="1" max="255"
                      name="descricao" id="materialDescricao" cols="30" rows="3"
                      required>{{ old('descricao', $material->descricao) }}</textarea>
            @error('descricao')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>

            @enderror
        </div>
        <div class="form-row">
            <div class="col-sm-auto">
                <Button class="btn btn-secondary" type="button"
                        onClick="if(confirm('Tem certeza que deseja Cancelar a alteração do Material?')) location.href='{{route('material.indexEdit')}}'">
                    Cancelar
                </Button>
            </div>
            <div class="col-sm-auto">
                <Button class="btn btn-success" type="submit"
                        onclick="return confirm('Tem certeza que deseja Atualizar o Material?')"> Atualizar
                </Button>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/CheckFields.js')}}"></script>
