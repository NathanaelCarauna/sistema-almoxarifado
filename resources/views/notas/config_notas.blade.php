@extends('templates.principal')

@section('title')
    Configurar Notas Fiscais
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>CONFIGURAR NOTAS FISCAIS</h2>
    </div>

    <form id="formUsuario" action="{{ route('alterar_config.nota') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(session()->has('sucess'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>{{session('sucess')}}</strong>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
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
                           id="nome" min="1910-01-01" required>
                    @error('nome')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="fone">{{ __('Fone') }}</label>
                    <input id="fone" type="text" min="0" class="form-control @error('fone') is-invalid @enderror"
                           name="fone" @if(isset($config->fone)) value="{{$config->fone}}"
                           @else value="{{ old('fone') }}" @endif required autocomplete="numTel"
                           placeholder="(00)00000-0000" required>

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
                           placeHolder="CNPJ" required>
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
                           @else value="{{ old('cep') }}" @endif type="text" autocomplete="cep" autofocus placeHolder="00000000" required>
                    @error('cep')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="estado"> Estado </label>
                    <select class="form-control" id="estado" name="estado">
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
                           placeHolder="R, Joaquin Tavora, S/N" required>
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
                           placeHolder="Heliopolis" required>
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
                           placeHolder="Garanhuns" required>
                    @error('municipio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-12" class="form-row"
                 style="border-bottom: #cfc5c5 1px solid; padding: 0 0 10px 0; margin-bottom: 20px">
            </div>

            <Button class="btn btn-secondary" type="button"
                    onclick="if(confirm('Tem certeza que deseja Cancelar a configuração da notas fiscais?')) location.href = '../' ">
                Cancelar
            </Button>
            <Button class="btn btn-success" type="submit"> Cadastrar</Button>
        </div>
    </form>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/usuario/CheckFields.js')}}"></script>
