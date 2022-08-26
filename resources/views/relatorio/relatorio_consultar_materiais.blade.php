<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Materiais</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</head>
<body>
<img align="right" src="{{ public_path('imagens/ufape_rel.png') }}" width="200px" height="100px">
<h2>RELATÓRIO DE MATERIAIS</h2> <br><br>

<table id="tableMateriais" style="width: 100%">
    <thead style="background-color: lightgray; border-radius: 15px">
    <tr>
        <th class="align-middle" scope="col">Código</th>
        <th class="align-middle" scope="col" style="text-align: center" width="340px">Material - Descrição</th>
        <th class="align-middle" scope="col">Qtd Total</th>
        <th class="align-middle" scope="col">Qtd Mínima</th>
        <th class="align-middle" scope="col">Localização</th>
        <th class="align-middle" scope="col">Unidade</th>
    </tr>
    </thead>
    <tbody>
    @if(count($materiais) > 0)
        <?php
        $cinza = '#ddd';
        $branco = '#fff';
        $cor = $branco;
        $ultimaCor = $cor;
        ?>
        @foreach($materiais as $material)
                {{ $quantidadeTotal = 0 }}

                @foreach ($estoques as $estoque)
                    @if($estoque->material_id == $material->id)
                        {{ $quantidadeTotal += $estoque->quantidade }}
                    @endif
                @endforeach

            <tr style="background-color:{{ $cor }}" <?php $ultimaCor = $cor?>>
                <td class="align-middle" scope="col" style="text-align: center">{{$material->codigo}}</td>
                <td class="align-middle" scope="col" style="text-align: center">{{$material->nome}} - {{$material->descricao}}</td>
                <td class="align-middle" scope="col" style="text-align: center">{{$quantidadeTotal}}</td>
                <td class="align-middle" scope="col" style="text-align: center">{{$material->quantidade_minima}}</td>
                <td class="align-middle" scope="col" style="text-align: center">{{$material->corredor}} - {{$material->prateleira}} - {{$material->coluna}}</td>
                <td class="align-middle" scope="col" style="text-align: center">{{$material->unidade}}</td>
            </tr>
            @if($ultimaCor == $cinza)
                <?php $cor = $branco?>
            @elseif($ultimaCor == $branco)
                <?php $cor = $cinza?>
            @endif
        @endforeach
    @endif
    </tbody>
</table>
</body>
</html>
