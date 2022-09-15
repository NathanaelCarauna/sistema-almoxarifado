<?php

namespace App\Http\Controllers;

use App\Deposito;
use App\Estoque;
use App\itemMovimento;
use App\Material;
use App\MaterialNotas;
use App\Movimento;
use App\NotaFiscal;
use App\Notificacao;
use App\Transferencia;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MovimentoController extends Controller
{
    public function createEntrada()
    {
        $materiais = Material::all();
        $depositos = Deposito::all();

        return view('movimento.entrada', ['materiais' => $materiais, 'depositos' => $depositos]);
    }

    public function createSaida()
    {
        $materiais = Material::all();
        $depositos = Deposito::all();

        return view('movimento.saida', ['materiais' => $materiais, 'depositos' => $depositos]);
    }

    public function createTransferencia()
    {
        $materiais = Material::all();
        $depositos = Deposito::all();

        return view('movimento.transferencia', ['materiais' => $materiais, 'depositos' => $depositos]);
    }

    private function notificacao_E_Email($estoque){
        $material = Material::find($estoque->material_id);
        $usuarios = Usuario::where('cargo_id', 2)->get();

        if($estoque->quantidade < $material->quantidade_minima){
            foreach($usuarios as $usuario){
                \App\Jobs\emailMaterialEsgotando::dispatch($usuario, $material);
                $mensagem = $material->nome . ' em estado critico.';
                $notificacao = new Notificacao();
                $notificacao->mensagem = $mensagem;
                $notificacao->usuario_id = $usuario->id;
                $notificacao->material_id = $material->id;
                $notificacao->material_quant = $estoque->quantidade;
                $notificacao->visto = false;
                $notificacao->save();
            }
        }
    }

    public function entradaStore(Request $request)
    {

        $validator = Validator::make($request->all(), Movimento::$rules, Movimento::$messages)->validate();

        $movimentoEntrada = new Movimento();
        $movimentoEntrada->operacao = $request['operacao'];
        $movimentoEntrada->descricao = $request['descricao'];

        $estoque = Estoque::where([
            ['deposito_id', '=', $request['deposito_id']],
            ['material_id', '=', $request['material_id']],
        ])->first();

        $notaFiscal = NotaFiscal::find($request->nota_fiscal_id);
        $notasMateriais = MaterialNotas::where('nota_fiscal_id', $notaFiscal->id)->get();
        $notaMaterial = null;

        foreach ($notasMateriais as $notaM){
            if($notaM->material_id == $request['material_id'])
            {
                $notaMaterial = $notaM;
                break;
            }
        }
        $difQuantNotaM = $notaMaterial->quantidade_total - $notaMaterial->quantidade_atual;
        if($difQuantNotaM >= $request['quantidade'])
        {
            $notaMaterial->quantidade_atual += $request['quantidade'];

            if($notaMaterial->quantidade_atual == $notaMaterial->quantidade_total)
            {
                $notaMaterial->status = true;
            }

            $notaMaterial->save();
        } else
        {
            return redirect()->back()->with('fail', 'A quantidade informada do material: '. Material::find($request['material_id'])->nome .', é maior que a quantidade restante na nota fiscal. Faltam '.$difQuantNotaM.' UND.')->withInput();
        }

        if (null == $estoque) {
            $estoque = new Estoque();
            $estoque->quantidade = $request['quantidade'];
            $estoque->material_id = $request['material_id'];
            $estoque->deposito_id = $request['deposito_id'];

            $this->notificacao_E_Email($estoque);

            $estoque->save();

        } else {
            $estoque->quantidade += $request['quantidade'];

            $this->notificacao_E_Email($estoque);

            $estoque->update();
        }

        $movimentoEntrada->save();

        $itemMovimento = new itemMovimento();
        $itemMovimento->quantidade = $request['quantidade'];
        $itemMovimento->material_id = $request['material_id'];
        $itemMovimento->estoque_id = $estoque->id;
        $itemMovimento->movimento_id = $movimentoEntrada->id;
        $itemMovimento->nota_fiscal_id = $request->nota_fiscal_id;

        $itemMovimento->save();

        return redirect()->route('deposito.consultarDeposito');
    }

    public function saidaStore(Request $request)
    {
        $validator = Validator::make($request->all(), Movimento::$rules, Movimento::$messages)->validate();

        $movimentoSaida = new Movimento();
        $movimentoSaida->operacao = $request['operacao'];
        $movimentoSaida->descricao = $request['descricao'];

        $estoque = DB::table('estoques')->where([
            ['deposito_id', '=', $request['deposito_id']],
            ['material_id', '=', $request['material_id']],
        ])->get()->first();

        if (null != $estoque) {
            $estoque = Estoque::findOrFail($estoque->id);
            if ($estoque->quantidade - $request['quantidade'] < 0) {
                $request->session()->flash('erro', 'Quantidade solicitada é maior que a disponível em estoque');

                return redirect()->route('movimento.saidaCreate');
            }
            $estoque->quantidade -= $request['quantidade'];
        } else {
            $request->session()->flash('erro', 'Não existe um estoque do material selecionado nesse depósito');

            return redirect()->route('movimento.saidaCreate');
        }

        $movimentoSaida->save();
        $estoque->save();

        $itemMovimento = new itemMovimento();
        $itemMovimento->quantidade = $request['quantidade'];
        $itemMovimento->material_id = $request['material_id'];
        $itemMovimento->estoque_id = $estoque->id;
        $itemMovimento->movimento_id = $movimentoSaida->id;

        $itemMovimento->save();

        return redirect()->route('deposito.consultarDeposito');
    }

    public function transferenciaStore(Request $request)
    {
        $validator = Validator::make($request->all(), Transferencia::$rules, Transferencia::$messages)->validate();

        $movimentoSaida = new Movimento();
        $movimentoSaida->operacao = '1';
        $movimentoSaida->descricao = $request['descricao'];

        $movimentoEntrada = new Movimento();
        $movimentoEntrada->operacao = '0';
        $movimentoEntrada->descricao = $request['descricao'];

        $estoqueSaida = Estoque::where([
            ['deposito_id', '=', $request['deposito_id_origem']],
            ['material_id', '=', $request['material_id']],
        ])->first();

        if (null != $estoqueSaida) {
            $estoqueSaida = Estoque::findOrFail($estoqueSaida->id);
            if ($estoqueSaida->quantidade - $request['quantidade'] < 0) {
                $request->session()->flash('erro', 'Quantidade solicitada é maior que a disponível em estoque');

                return redirect()->route('movimento.transferenciaCreate');
            }
            $estoqueSaida->quantidade -= $request['quantidade'];
            $this->notificacao_E_Email($estoqueSaida);
        } else {
            $request->session()->flash('erro', 'Não existe um estoque do material selecionado nesse depósito');

            return redirect()->route('movimento.transferenciaCreate');
        }

        $estoqueEntrada = Estoque::where([
            ['deposito_id', '=', $request['deposito_id_destino']],
            ['material_id', '=', $request['material_id']],
        ])->first();

        if (null == $estoqueEntrada) {
            $estoqueEntrada = new Estoque();
            $estoqueEntrada->quantidade = $request['quantidade'];
            $estoqueEntrada->material_id = $request['material_id'];
            $estoqueEntrada->deposito_id = $request['deposito_id_destino'];
            $this->notificacao_E_Email($estoqueEntrada);
            $estoqueEntrada->save();
        } else {
            $estoqueEntrada->quantidade += $request['quantidade'];
            $this->notificacao_E_Email($estoqueEntrada);
            $estoqueEntrada->update();
        }

        $movimentoSaida->save();
        $estoqueSaida->save();
        $movimentoEntrada->save();

        $itemMovimentoSaida = new itemMovimento();
        $itemMovimentoSaida->quantidade = $request['quantidade'];
        $itemMovimentoSaida->material_id = $request['material_id'];
        $itemMovimentoSaida->estoque_id = $estoqueSaida->id;
        $itemMovimentoSaida->movimento_id = $movimentoSaida->id;

        $itemMovimentoEntrada = new itemMovimento();
        $itemMovimentoEntrada->quantidade = $request['quantidade'];
        $itemMovimentoEntrada->material_id = $request['material_id'];
        $itemMovimentoEntrada->estoque_id = $estoqueEntrada->id;
        $itemMovimentoEntrada->movimento_id = $movimentoEntrada->id;

        $itemMovimentoEntrada->save();
        $itemMovimentoSaida->save();

        return redirect()->route('deposito.consultarDeposito');
    }
}
