<div class="form-group row">
    <div class="col-md-3">
        <label for="inscricao_estadual"> Inscrição Estadual </label>
        <input class="form-control  @error('inscricao_estadual') is-invalid @enderror" type="text" name="inscricao_estadual" id="inscricao_estadual"
               maxlength="100" @if(isset($config->inscricao_estadual)) value="{{$config->inscricao_estadual}}"
               @else value="{{ old('inscricao_estadual') }}" @endif autocomplete="inscricao_estadual" autofocus
               placeHolder="Inscrição Estadual" disabled>
        @error('inscricao_estadual')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="nome"> Nome </label>
        <input class="form-control @error('nome') is-invalid @enderror"
               @if(isset($config->nome)) value="{{$config->nome}}"
               @else value="{{ old('nome') }}" @endif autofocus type="text" name="nome"
               id="nome" min="1910-01-01" disabled>
        @error('nome')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="cnpj"> CNPJ </label>
        <input class="form-control @error('cnpj') is-invalid @enderror"
               @if(isset($config->cnpj)) value="{{$config->cnpj}}"
               @else value="{{ old('cnpj') }}" @endif
               type="text"
               name="cnpj" id="cnpj" maxlength="11" autocomplete="cnpj" autofocus
               placeHolder="CNPJ" disabled>
        @error('cnpj')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="fone">{{ __('Fone') }}</label>
        <input id="fone" type="text" min="0" class="form-control @error('fone') is-invalid @enderror"
               name="fone" @if(isset($config->fone)) value="{{$config->fone}}"
               @else value="{{ old('fone') }}" @endif required autocomplete="numTel"
               placeholder="(00)00000-0000" disabled>

        @error('fone')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
</div>


<div class="form-group row">

    <div class="col-md-4">
        <label for="estado"> Estado </label>
        <input type="text" name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror"
               @if(isset($config->estado)) value="{{$config->estado}}"
               @else value="{{ old('estado') }}" @endif autocomplete="estado" autofocus placeHolder="Estado" disabled>
        @error('estado')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="municipio"> Municipio </label>
        <input class="form-control @error('municipio') is-invalid @enderror"
               @if(isset($config->municipio)) value="{{$config->municipio}}"
               @else value="{{ old('municipio') }}" @endif
               autocomplete="municipio" autofocus type="text" name="municipio" id="municipio"
               placeHolder="Garanhuns" disabled>
        @error('municipio')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="bairro"> Bairro </label>
        <input class="form-control @error('bairro') is-invalid @enderror"
               @if(isset($config->bairro)) value="{{$config->bairro}}"
               @else value="{{ old('bairro') }}" @endif
               autocomplete="bairro" autofocus type="text" name="bairro" id="bairro"
               placeHolder="Heliopolis" disabled>
        @error('bairro')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-md-6">
        <label for="endereco"> Endereço </label>
        <input class="form-control @error('endereco') is-invalid @enderror"
               @if(isset($config->endereco)) value="{{$config->endereco}}"
               @else value="{{ old('endereco') }}" @endif
               autocomplete="endereco" autofocus type="text" name="endereco" id="endereco"
               placeHolder="R, Joaquin Tavora, S/N" disabled>
        @error('endereco')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="cep"> CEP </label>
        <input name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror" maxlength="8"
               @if(isset($config->cep)) value="{{$config->cep}}"
               @else value="{{ old('cep') }}" @endif type="text" autocomplete="cep" autofocus placeHolder="00000000" disabled>
        @error('cep')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4">
        <label for="codigo">Código</label>
        <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo"
               name="codigo" placeholder="Código" autofocus autocomplete="codigo" min="1" maxlength="100"
               @if(isset($nota->codigo)) value="{{$nota->codigo}}"
               @else value="{{ old('codigo') }}" @endif
               @if(isset($readOnly)) disabled @endif required/>
        @error('codigo')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="codigoMaterial">CNPJ</label>
        <input type="text" class="form-control @error('cnpj') is-invalid @enderror" id="cnpj"
               name="cnpj" min="1" maxlength="20" placeholder="CNPJ"
               @if(isset($nota->cnpj)) value="{{$nota->cnpj}}"
               @else value="{{ old('cnpj') }}" @endif
               @if(isset($readOnly)) disabled @endif
               autofocus
               required/>
        @error('cnpj')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="valor_nota">Valor Nota</label>
        <input type="text" class="form-control @error('valor_nota') is-invalid @enderror" id="valor_nota"
               name="valor_nota" placeholder="nota" autofocus autocomplete="valor_nota" min="1" maxlength="100"
               @if(isset($nota->valor_nota)) value="{{$nota->valor_nota}}"
               @else value="{{ old('valor_nota') }}" @endif
               @if(isset($readOnly)) disabled @endif
               required/>
        @error('valor_nota')
        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
        @enderror
    </div>
</div>
