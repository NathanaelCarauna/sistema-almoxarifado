<meta name="csrf-token" content="{{ csrf_token() }}"/>

<div class="form-group">
    <div class="form-group">
        <h2 class="h4"> Dados Institucionais / Pessoais </h2>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
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

        <div class="form-group col-md-4">
            <label for="fone">{{ __('Fone') }}</label>
            <input id="fone" type="text" min="14" class="form-control @error('fone') is-invalid @enderror"
                   name="fone" @if(isset($config->fone)) value="{{$config->fone}}"
                   @else value="{{ old('fone') }}" @endif required autocomplete="numTel"
                   placeholder="(00)00000-0000" disabled>

            @error('fone')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="cnpj"> CNPJ </label>
            <input class="form-control @error('cnpj') is-invalid @enderror"
                   @if(isset($config->cnpj)) value="{{$config->cnpj}}"
                   @else value="{{ old('cnpj') }}" @endif
                   type="text"
                   name="cnpj" id="cnpj" maxlength="14" autocomplete="cnpj" autofocus
                   placeHolder="CNPJ" disabled>
            @error('cnpj')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <h2 class="h4"> Endereço </h2>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
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

        <div class="form-group col-md-6">
            <label for="estado"> Estado </label>
            <select class="form-control" id="estado" name="estado" disabled>
                <option disabled>Selecione</option>
                <option value="AC" @if(isset($config->estado) && $config->estado == 'AC') selected @endif>Acre</option>
                <option value="AL" @if(isset($config->estado) && $config->estado == 'AL') selected @endif>Alagoas</option>
                <option value="AP" @if(isset($config->estado) && $config->estado == 'AP') selected @endif>Amapá</option>
                <option value="AM" @if(isset($config->estado) && $config->estado == 'AM') selected @endif>Amazonas</option>
                <option value="BA" @if(isset($config->estado) && $config->estado == 'BA') selected @endif>Bahia</option>
                <option value="CE" @if(isset($config->estado) && $config->estado == 'CE') selected @endif>Ceará</option>
                <option value="DF" @if(isset($config->estado) && $config->estado == 'DF') selected @endif>Distrito Federal</option>
                <option value="ES" @if(isset($config->estado) && $config->estado == 'ES') selected @endif>Espirito Santo</option>
                <option value="GO" @if(isset($config->estado) && $config->estado == 'GO') selected @endif>Goiás</option>
                <option value="MA" @if(isset($config->estado) && $config->estado == 'MA') selected @endif>Maranhão</option>
                <option value="MS" @if(isset($config->estado) && $config->estado == 'MS') selected @endif>Mato Grosso do Sul</option>
                <option value="MT" @if(isset($config->estado) && $config->estado == 'MT') selected @endif>Mato Grosso</option>
                <option value="MG" @if(isset($config->estado) && $config->estado == 'MG') selected @endif>Minas Gerais</option>
                <option value="PA" @if(isset($config->estado) && $config->estado == 'PA') selected @endif>Pará</option>
                <option value="PB" @if(isset($config->estado) && $config->estado == 'PB') selected @endif>Paraíba</option>
                <option value="PR" @if(isset($config->estado) && $config->estado == 'PR') selected @endif>Paraná</option>
                <option value="PE" @if(isset($config->estado) && $config->estado == 'PE') selected @endif>Pernambuco</option>
                <option value="PI" @if(isset($config->estado) && $config->estado == 'PI') selected @endif>Piauí</option>
                <option value="RJ" @if(isset($config->estado) && $config->estado == 'RJ') selected @endif>Rio de Janeiro</option>
                <option value="RN" @if(isset($config->estado) && $config->estado == 'RN') selected @endif>Rio Grande do Norte</option>
                <option value="RS" @if(isset($config->estado) && $config->estado == 'RS') selected @endif>Rio Grande do Sul</option>
                <option value="RO" @if(isset($config->estado) && $config->estado == 'RO') selected @endif>Rondônia</option>
                <option value="RR" @if(isset($config->estado) && $config->estado == 'RR') selected @endif>Roraima</option>
                <option value="SC" @if(isset($config->estado) && $config->estado == 'SC') selected @endif>Santa Catarina</option>
                <option value="SP" @if(isset($config->estado) && $config->estado == 'SP') selected @endif>São Paulo</option>
                <option value="SE" @if(isset($config->estado) && $config->estado == 'SE') selected @endif>Sergipe</option>
                <option value="TO" @if(isset($config->estado) && $config->estado == 'TO') selected @endif>Tocantins</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
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
    </div>

    <div class="form-group">
        <h2 class="h4"> Dados Nota Fiscal </h2>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="numero">Número<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero"
                   name="numero" placeholder="Digite o número da nota fiscal" autofocus autocomplete="numero" minlength="11" maxlength="11"
                   @if(isset($nota->numero)) value="{{$nota->numero}}"
                   @else value="{{ old('numero') }}" @endif
                   @if(isset($readOnly)) disabled @endif required/>
            @error('numero')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="serie">Série<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('serie') is-invalid @enderror" id="serie"
                   name="serie" min="3" placeholder="000"
                   @if(isset($nota->serie)) value="{{$nota->serie}}"
                   @else value="{{ old('serie') }}" @endif
                   @if(isset($readOnly)) disabled @endif
                   autofocus
                   required/>
            @error('serie')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="natureza_operacao">Natureza da Operação<span style="color: red">*</span></label>
            <input type="text" class="form-control @error('natureza_operacao') is-invalid @enderror" id="natureza_operacao"
                   name="natureza_operacao" placeholder="Digite a natureza da operação" autofocus autocomplete="natureza_operacao" min="1" maxlength="100"
                   @if(isset($nota->natureza_operacao)) value="{{$nota->natureza_operacao}}"
                   @else value="{{ old('natureza_operacao') }}" @endif
                   @if(isset($readOnly)) disabled @endif required/>
            @error('natureza_operacao')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="data_emissao">Data da Emissão<span style="color: red">*</span></label>
            <input type="date" class="form-control @error('data_emissao') is-invalid @enderror" id="data_emissao"
                   name="data_emissao" min="1" maxlength="20" placeholder="Digite a data da emissão da nota fiscal"
                   @if(isset($nota->data_emissao)) value="{{$nota->data_emissao}}"
                   @else value="{{ old('data_emissao') }}" @endif
                   @if(isset($readOnly)) disabled @endif
                   autofocus
                   required/>
            @error('data_emissao')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <div @if(isset($readOnly)) class="col-md-6" @else class="col-md-12" @endif>
            <div class="form-row">
                <div class="col-md-9">
                    <label for="emitente">Emitente<span style="color: red">*</span></label>
                </div>
                @if(!isset($readOnly))
                    <div class="col-md-3">
                        <a data-toggle="modal" data-target="#emitenteModal" style="float: right; margin-right: 10px"><b style="color: #2d995b">Adicionar Emitente</b>
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#29c14e" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M3 3h18v18H3zM12 8v8m-4-4h8"/>
                            </svg>
                        </a></div>
                @endif
            </div>
            <select class="@if(!isset($readOnly)) selectEmitente @endif form-control" name="emitente_id" id="emitente" @if(isset($readOnly)) disabled @endif required style="width: 100%;">
                <option></option>
                @foreach($emitentes as $emitente)
                    <option @if(isset($nota) && $nota->emitente_id == $emitente->id) selected @endif value="{{$emitente->id}}">{{$emitente->razao_social}} - {{$emitente->cnpj}}</option>
                @endforeach
            </select>
        </div>

        @if(isset($readOnly))
            <div class="col-md-6">
                <label for="valor_nota">Valor da Nota</label>
                <input class="form-control" value="{{$nota->valor_nota}}" disabled>
            </div>
        @endif
    </div>


    <div class="form-group col-md-12" class="form-row"
         style="border-bottom: #cfc5c5 1px solid; padding: 0 0 10px 0; margin-bottom: 20px">
    </div>
</div>


<script>
    $('.selectEmitente').select2({
        placeholder: "Selecione o Emitente Pelo CNPJ.",
        language: { noResults: () => "Nenhum resultado encontrado.",},
    });
</script>
<style>
    .select2-selection{
        height: 40%!important;
    }
    .select2-selection__rendered{

        margin: 0px;
        margin-bottom: 15px;
    }
    .select2-selection__arrow{
        height: 20%!important;
    }
</style>
