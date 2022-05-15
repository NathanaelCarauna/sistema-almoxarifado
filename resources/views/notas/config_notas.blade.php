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
            <div class="form-group">
                <label for="inscricao_estadual"> Inscrição Estatual </label>
                <input class="form-control  @error('inscricao_estadual') is-invalid @enderror" type="text" name="inscricao_estadual" id="inscricao_estadual"
                       maxlength="100" @if(isset($config->inscricao_estadual)) value="{{$config->inscricao_estadual}}"
                       @else value="{{ old('inscricao_estadual') }}" @endif autocomplete="inscricao_estadual" autofocus
                       placeHolder="Inscrição Estadual">
                @error('inscricao_estadual')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nome"> Nome </label>
                    <input class="form-control @error('nome') is-invalid @enderror"
                           @if(isset($config->nome)) value="{{$config->nome}}"
                           @else value="{{ old('nome') }}" @endif autofocus type="text" name="nome"
                           id="nome" min="1910-01-01">
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
                           placeholder="(00)00000-0000">

                    @error('fone')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="estado"> Estado </label>
                    <input type="text" name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror"
                           @if(isset($config->estado)) value="{{$config->estado}}"
                           @else value="{{ old('estado') }}" @endif autocomplete="estado" autofocus placeHolder="Estado">
                    @error('estado')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cnpj"> CNPJ </label>
                    <input class="form-control @error('cnpj') is-invalid @enderror"
                           @if(isset($config->cnpj)) value="{{$config->cnpj}}"
                           @else value="{{ old('cnpj') }}" @endif
                           type="text"
                           name="cnpj" id="cnpj" maxlength="11" autocomplete="cnpj" autofocus
                           placeHolder="CNPJ">
                    @error('cnpj')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="cep"> CEP </label>
                    <input name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror" maxlength="8"
                           @if(isset($config->cep)) value="{{$config->cep}}"
                           @else value="{{ old('cep') }}" @endif type="text" autocomplete="cep" autofocus placeHolder="00000000">
                    @error('cep')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <h2 class="h4"> Endereço </h2>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="endereco"> Endereço </label>
                    <input class="form-control @error('endereco') is-invalid @enderror"
                           @if(isset($config->endereco)) value="{{$config->endereco}}"
                           @else value="{{ old('endereco') }}" @endif
                           autocomplete="endereco" autofocus type="text" name="endereco" id="endereco"
                           placeHolder="R, Joaquin Tavora, S/N">
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
                           placeHolder="Heliopolis">
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
                           placeHolder="Garanhuns">
                    @error('municipio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <input hidden class="form-control @error('senha') is-invalid @enderror" autofocus
                   autocomplete="new-password"
                   type="password" name="password" id="password" placeHolder="" value="almoxarifado123">
            <input hidden class="form-control @error('confirmar_senha') is-invalid @enderror"
                   autocomplete="new-password"
                   autofocus type="password" name="password_confirmation" id="password_confirmation" placeHolder=""
                   value="almoxarifado123">
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
