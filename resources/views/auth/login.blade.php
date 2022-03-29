@extends('templates.templateLogin')

@section('title')
    Login
@endsection

@section('content')
<div class="container-fluid" style="background-color: white; margin-bottom: 30px; margin-top: 30px;padding: 20px; border-radius: 15px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-7" style="margin-right: 30px">
                <div>
                    <h2 style="color: #3E3767"><strong>Plataforma Eletrônica de Gestão de Almoxarifados (PEGA)</strong></h2>
                    <p style="color: #3E3767; text-align: justify">
                        É uma aplicação web desenvolvida no âmbito da cooperação técnica UFAPE-LMTS / UPE com o objetivo de informatizar o gerenciamento de almoxarifados,
                         auxiliando os responsáveis nas suas rotinas de trabalho,
                         como controlar o estoque e atender demandas dos solicitantes por materiais etc.
                    </p>
                    <h2 style="color: #3E3767"><strong>Quais são os benefícios?</strong></h2>
                    <p style="color: #3E3767; text-align: justify">
                        <ul>
                            <li>
                                Praticidade e confiabilidade no gerenciamento do almoxarifado, permitindo uma visão holística do setor.
                            </li>
                            <li>
                                Informatização do processo de solicitação, aprovação e controle de estoque e materiais.
                            </li>
                            <li>
                                Acesso fácil por meio da internet.
                            </li>
                        </ul>
                    </p>
                    <h2 style="color: #3E3767"><strong>Quais materiais posso solicitar?</strong></h2>
                    <p style="color: #3E3767; text-align: justify">
                        Quaisquer materiais cadastrados no sistema e disponíveis no estoque da instituição.
                    </p>
                </div>
            </div>
            <div class="col-sm-5" style="margin-right: -100px">
                <h3 style="font-family: 'Segoe UI'; color: #3E3767; text-align: center; margin-left: -10%"><u>Entrar</u></h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group col-md-11">
                        <label for="email" class="control-label"
                               style="font-family: 'Segoe UI'; color: #3E3767; font-weight: bold; font-size: 20px">E-mail</label>
                        <input id="email" type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror" name="email"
                               value="{{ old('email') }}"
                               style="padding: 0; color: black; border-radius: 0; box-shadow: none; border: none; border-bottom: 1px solid"
                               required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-11">
                        <label for="password" class="control-label"
                               style="font-family: 'Segoe UI'; color: #3E3767; font-weight: bold; font-size: 20px">Senha</label>
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               style="padding: 0; color: black; border-radius: 0; box-shadow: none; border: none; border-bottom: 1px solid"
                               required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input class="form-control-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Lembrar E-mail e Senha') }}
                        </label>
                    </div>
                    <br>
                    <div class="form-group col-md-11">
                        <button type="submit" class="btn btn-success btn-block">
                            {{ __('Entrar') }}
                        </button>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="form-group col-md-11">
                            <center>
                                <a class=" btn-link" href="{{ route('password.request') }}">Esqueci minha senha</a>
                            </center>
                            <hr style="margin-top: 0">
                        </div>
                    @endif
                </form>
                <div class="form-group col-md-11">
                    <a type="button" href="{{ route('register') }}" class="btn btn-primary btn-block">
                        {{ __('Cadastre-se') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
