<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório De Saída de Materiais Por Solicitações</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</head>
<body>
<img align="right" src="{{ public_path('imagens/ufape_rel.png') }}" width="200px" height="100px">
    <h2>RELATÓRIO DE SOLICITAÇÕES ENTREGUES</h2>
    <h4>RELATÓRIO REFERENTE AO PERÍODO: {{ date('d/m/Y',  strtotime($datas[0])) }} A {{ date('d/m/Y',  strtotime($datas[1])) }}</h4>

    <table id="tableMateriais" style="width: 100%">
        <thead style="background-color: lightgray; border-radius: 15px">
            <tr>
                <th class="align-middle" scope="col">Requerente</th>
                <th class="align-middle" scope="col" style="text-align: center" width="340px">Materiais</th>
                <th class="align-middle" scope="col">Unidade</th>
                <th class="align-middle" scope="col">Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @if(count($solicitacoes) > 0)
            <?php
                $cinza = '#ddd';
                $branco = '#fff';
                $cor = $branco;
                $ultimaCor = $cor;
            ?>
                @foreach($solicitacoes as $solicitacao)
                    <tr style="background-color:{{ $cor }}" <?php $ultimaCor = $cor?>>
                        <td class="align-middle" scope="col" style="text-align: center">{{$solicitacao->receptor}}</td>
                        <td class="align-middle" scope="col" style="text-align: center">
                            @foreach($solicitacao->itensSolicitacoes as $item)
                                {{$item->material->nome}} <br>
                            @endforeach
                        </td>
                        <td class="align-middle" scope="col" style="text-align: center">
                            @foreach($solicitacao->itensSolicitacoes as $item)
                                {{$item->material->unidade}} <br>
                            @endforeach
                        </td>
                        <td class="align-middle" scope="col" style="text-align: center">
                            @foreach($solicitacao->itensSolicitacoes as $item)
                                {{$item->quantidade_aprovada}} <br>
                            @endforeach
                        </td>
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

    <br>

    <table id="tableMateriais" style="width: 100%">
        <thead style="background-color: lightgray; border-radius: 15px">
            <tr>
                <th class="align-middle" scope="col">Materiais</th>
                <th class="align-middle" scope="col">Unidade</th>
                <th class="align-middle" scope="col">Quantidade total</th>
            </tr>
        </thead>
        <tbody>
            @if(count($solicitacoes) > 0)
            <?php
                $cinza = '#ddd';
                $branco = '#fff';
                $cor = $branco;
                $ultimaCor = $cor;
            ?>

                @foreach($quantidades as $key => $quantidade)
                    <tr style="background-color:{{ $cor }}" <?php $ultimaCor = $cor?>>
                        <td class="align-middle" scope="col" style="text-align: center">{{$key}}</td>
                        <td class="align-middle" scope="col" style="text-align: center">{{$quantidade[0]}}</td>
                        <td class="align-middle" scope="col" style="text-align: center">{{$quantidade[1]}}</td>
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
