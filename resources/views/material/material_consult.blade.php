@extends('templates.principal')

@section('title') Consultar Materiais @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>CONSULTAR MATERIAIS</h2>
    </div>

    <table id="tableMateriais" class="table table-hover table-responsive-md">
        <thead style="background-color: #151631; color: white; border-radius: 15px">
        <tr>
            <th class="align-middle" scope="col" style="padding: 0px"></th>
            <th class="align-middle" scope="col" style="padding-left: 10px">Imagem</th>
            <th class="align-middle" scope="col" style="padding-left: 10px">Material</th>
            <th class="align-middle" scope="col" style="padding-left: 10px">Descrição</th>
            <th class="align-middle" scope="col" style="text-align: center">Qtd Total</th>
            <th class="align-middle" scope="col" style="text-align: center">Qtd Mínima</th>
            <th class="align-middle" scope="col" style="text-align: center">Localização</th>
            <th class="align-middle" scope="col" style="text-align: center">Código</th>
            <th class="align-middle" scope="col" style="text-align: center">Unidade</th>
        </tr>
        </thead>
        <tbody>

        @forelse($materials as $material)
            @php
                $quantidadeTotal = 0;
                foreach ($estoques as $estoque) {
                    if($estoque->material_id == $material->id){
                        $quantidadeTotal += $estoque->quantidade;
                    }
                }
            @endphp
            <tr onclick="location.href = '{{ route('material.index') }}'" style="cursor: pointer;">
            @if($material->quantidade_minima > $quantidadeTotal)
                <!-- Cor Vermelha -->
                    <td bgcolor="E36763"></td>
            @elseif(($material->quantidade_minima + 20) > $quantidadeTotal)
                <!-- Cor Amarela -->
                    <td bgcolor="ffe680"></td>
            @else
                <!-- Cor Verde -->
                    <td bgcolor="c7f9cc"></td>
                @endif
                <td>
                    @if($material->imagem != null)
                        <img src="{{ url('storage/img/materiais/'.$material->imagem) }}" alt="{{ $material->imagem }}"
                             width="80" height="80">
                    @else
                        <img src="{{ asset('/imagens/foto_inexistente.jpeg') }}"
                             width="80" height="80">
                    @endif
                </td>
                <td>{{ $material->nome }}</td>
                <td>{{ $material->descricao }}</td>
                <td style="text-align: center">{{ $quantidadeTotal }}</td>
                <td style="text-align: center">{{ $material->quantidade_minima }}</td>
                <td style="text-align: center">{{$material->corredor}}-{{strtoupper($material->prateleira)}}-{{$material->coluna}}</td>
                <td style="text-align: center">{{ $material->codigo }}</td>
                <td style="text-align: center">{{ $material->unidade }}</td>
            </tr>
        @empty
            <td colspan="5">Sem materiais cadastrados ainda</td>
        @endempty
        </tbody>
    </table>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/todos_materiais.js')}}"></script>
