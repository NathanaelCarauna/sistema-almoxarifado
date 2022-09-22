@extends('templates.principal')

@section('title')
    Relatório Material
@endsection

<style>
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 37px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
</style>

@section('content')
    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>RELATÓRIO DE MATERIAIS</h2>
    </div>

    <div>
        <form method="POST" target="_blank" action="{{ route('relatorio.materiais') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">

                <div class="col-md-4">
                    <label for="tipo_relatorio"> {{ __('Tipo de Relatório:') }} </label>

                    <select id="tipo_relatorio" class="form-control @error('tipo_relatorio') is-invalid @enderror"
                            name="tipo_relatorio">
                        <option value="" selected hidden>Escolher...</option>
                        <option value="0">Entrada de Material</option>
                        <option value="1">Saída de Material</option>
                        <option value="2">Materiais Não Movimentados</option>
                        <option value="3">Saída de Material(Solicitação)</option>
                        <option value="4">Materiais mais movimentados(Solicitação)</option>
                        <option value="5">Solicitações entregues</option>
                        <option value="6">Materiais em estado crítico</option>
                        <option value="7">Consultar Materiais</option>
                        <option value="8">Solicitação de material especifico</option>

                    </select>
                    @error('tipo_relatorio')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-8 form-row" id="rel_item">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="selectMaterial" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Material</label>
                            <select id="selectMaterial" name="material_id" class="selectMaterial form-control" style="width: 100%">
                                <option></option>
                                @foreach($materiais as $material)
                                    <option value="{{$material->id}}">{{$material->codigo}} - {{ $material->nome }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="data_inicio">{{ __('Data de início:') }}</label>

                            <input type="date" value="{{ old('data_inicio_item') }}"
                                   class="form-control @error('data_inicio_item') is-invalid @enderror" name="data_inicio_item"
                                   min="1910-01-01">

                            @error('data_inicio_item')

                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="data_fim_item">{{ __('Data de fim:') }}</label>

                            <input type="date" value="{{ old('data_fim_item') }}"
                                   class="form-control @error('data_fim_item') is-invalid @enderror" name="data_fim_item"
                                   min="1910-01-01">

                            @error('data_fim_item')

                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="col-md-4" id="data_inicio">
                    <div class="form-group">
                        <label for="data_inicio">{{ __('Data de início:') }}</label>

                        <input id="data_inicio" type="date" value="{{ old('data_inicio') }}"
                               class="form-control @error('data_inicio') is-invalid @enderror" name="data_inicio"
                               min="1910-01-01">

                        @error('data_inicio')

                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4" id="data_fim">
                    <div class="form-group">
                        <label for="data_fim">{{ __('Data de fim:') }}</label>

                        <input id="data_fim" type="date" value="{{ old('data_fim') }}"
                               class="form-control @error('data_fim') is-invalid @enderror" name="data_fim"
                               min="1910-01-01">

                        @error('data_fim')

                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <button id="gera_Relatorio" type="submit" class="btn btn-success">Gerar Relatório</button>
        </form>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/relatorio/relatorio_escolha.js')}}"></script>
