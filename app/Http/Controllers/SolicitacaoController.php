<?php

namespace App\Http\Controllers;

use App\Estoque;
use App\HistoricoStatus;
use App\ItemSolicitacao;
use App\Material;
use App\Notificacao;
use App\Solicitacao;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SolicitacaoController extends Controller
{
    public function show()
    {
        $estoques = Estoque::where('deposito_id', 1)->get();
        $materiais = [];
        foreach ($estoques as $estoque)
        {
            if($estoque->quantidade > 0)
            {
                array_push($materiais, Material::find($estoque->material_id));
            }
        }

        return view('solicitacao.solicita_material', ['materiais' => $materiais]);
    }

    public function store(Request $request)
    {
        $materiais = explode(',', $request->dataTableMaterial);
        $quantidades = explode(',', $request->dataTableQuantidade);

        $materiaisCheck = true;

        for ($i = 0; $i < count($materiais); ++$i) {
            if (empty($materiais[$i]) || empty($quantidades[$i]) || !is_numeric($materiais[$i]) || !is_numeric($quantidades[$i])) {
                $materiaisCheck = false;
                break;
            }

            if ((is_numeric($materiais[$i]) && intval($materiais[$i]) < 0 || strpos($materiais[$i], '.') || strpos($materiais[$i], ','))
                    || (is_numeric($quantidades[$i]) && intval($quantidades[$i]) < 0 || strpos($quantidades[$i], '.') || strpos($quantidades[$i], ','))) {
                $materiaisCheck = false;

                break;
            }
        }

        if (!$materiaisCheck) {
            return redirect()->back()->withErrors('Informe valores validos para o(s) material(is) e sua(s) quantidade(s)');
        }

        if (is_null($request->checkReceptor) && strlen($request->nomeReceptor) > 100 || strlen($request->nomeReceptor) < 5
                || strpos($request->rgReceptor, '.') || strpos($request->rgReceptor, ',') || (is_numeric($request->rgReceptor) && intval($request->rgReceptor) < 0)
                || strlen($request->rgReceptor) < 7 || strlen($request->rgReceptor) > 11) {
            return redirect()->back()->withErrors('O nome do receptor deve ter no máximo 100 dígitos e o RG 11 dígitos');
        }

        $solicitacao = new Solicitacao();
        $solicitacao->usuario_id = Auth::user()->id;
        $solicitacao->observacao_requerente = $request->observacao;
        $usuario = Usuario::find(Auth::user()->id);
        if (is_null($request->checkReceptor)) {
            $solicitacao->receptor = $request->nomeReceptor;
            $solicitacao->receptor_rg = $request->rgReceptor;
            $solicitacao->receptor_tipo = $request->tipoReceptor;
        } else {
            $solicitacao->receptor = $usuario->nome;
            $solicitacao->receptor_rg = $usuario->rg;
            $solicitacao->receptor_tipo = 'Servidor';
        }
        $solicitacao->setor_usuario = $usuario->setor;

        $solicitacao->save();

        $historicoStatus = new HistoricoStatus();
        $historicoStatus->status = 'Aguardando Analise';
        $historicoStatus->solicitacao_id = $solicitacao->id;
        $historicoStatus->save();

        for ($i = 0; $i < count($materiais); ++$i) {
            $itemSolicitacao = new ItemSolicitacao();
            $itemSolicitacao->quantidade_solicitada = $quantidades[$i];
            $itemSolicitacao->material_id = $materiais[$i];
            $itemSolicitacao->solicitacao_id = $solicitacao->id;
            $itemSolicitacao->save();
        }

        return redirect()->back()->with('success', 'Solicitação feita com sucesso!');
    }

    public function checkAnaliseSolicitacao(Request $request)
    {
        $itemSolicitacaos = session('itemSolicitacoes');

        if ('nega' == $request->action) {
            return $this->checarNegarSolicitacao($request->observacaoAdmin, $request->solicitacaoID);
        }
        if ('aprova' == $request->action) {
            return $this->checarAprovarSolicitacao($itemSolicitacaos, $request->quantAprovada, $request->observacaoAdmin, $request->solicitacaoID);
        }
    }

    public function checarNegarSolicitacao($observacaoAdmin, $solicitacaoID)
    {
        if (is_null($observacaoAdmin)) {
            return redirect()->back()->withErrors('Informe o motivo de a solicitação ter sido negada!');
        }
        DB::update('update historico_statuses set status = ?, data_finalizado = now() where solicitacao_id = ?', ['Negado', $solicitacaoID]);
        DB::update('update solicitacaos set observacao_admin = ? where id = ?', [$observacaoAdmin, $solicitacaoID]);

        if (session()->exists('itemSolicitacoes')) {
            session()->forget('itemSolicitacoes');
        }
        if (session()->exists('status')) {
            session()->forget('status');
        }

        $solicitacao = Solicitacao::where('id', $solicitacaoID)->first();
        $usuario = Usuario::where('id', $solicitacao->usuario_id)->first();

        \App\Jobs\emailSolicitacaoNaoAprovada::dispatch($usuario, $solicitacao);

        return redirect()->back()->with('success', 'Solicitação cancelada com sucesso!');
    }

    public function checarAprovarSolicitacao($itemSolicitacaos, $quantMateriais, $observacaoAdmin, $solicitacaoID)
    {
        $itensID = [];
        $materiaisID = [];
        $quantMatAprovados = [];
        $auxMateriaisRepetidos = [];
        $errorMessage = [];

        $checkInputVazio = 0;
        $checkQuantMinima = 0;
        $checkQuantAprovada = 0;

        if (count($itemSolicitacaos) != count($quantMateriais)) {
            return redirect()->back()->with('inputNULL', 'Informe os valores das quantidades aprovadas!');
        }

        //Verifica todos os materiais da solicitaçõa. Caso todos os campos estejam em branco ou com valor negativo retorna um erro.
        for ($i = 0; $i < count($itemSolicitacaos); ++$i) {
            if (empty($quantMateriais[$i])) {
                ++$checkInputVazio;
            } elseif (!empty($quantMateriais[$i]) && $quantMateriais[$i] < 0) {
                return redirect()->back()->with('inputNULL', 'Informe valores positivos para as quantidades aprovadas!');
            } else {
                //Cada material é adicionado ao auxMateriaisRepetidos.
                //Caso o material já esteja inserido nesse array a quantidade do material repetido é adicionada ao que está no array.
                if (array_key_exists($itemSolicitacaos[$i]->material_id, $auxMateriaisRepetidos)) {
                    $auxMateriaisRepetidos[$itemSolicitacaos[$i]->material_id] += $quantMateriais[$i];
                } elseif (!array_key_exists($itemSolicitacaos[$i]->material_id, $auxMateriaisRepetidos)) {
                    $auxMateriaisRepetidos[$itemSolicitacaos[$i]->material_id] = $quantMateriais[$i];
                }

                if ($auxMateriaisRepetidos[$itemSolicitacaos[$i]->material_id] <= $itemSolicitacaos[$i]->quantidade) {
                    array_push($itensID, $itemSolicitacaos[$i]->id);
                    array_push($materiaisID, $itemSolicitacaos[$i]->material_id);
                    array_push($quantMatAprovados, $quantMateriais[$i]);
                    if ($quantMateriais[$i] < $itemSolicitacaos[$i]->quantidade_solicitada) {
                        ++$checkQuantAprovada;
                    }
                } else {
                    ++$checkQuantMinima;
                    array_push($errorMessage, $itemSolicitacaos[$i]->nome.'(Dispoível:'.$itemSolicitacaos[$i]->quantidade.')');
                }
            }
        }
        if ($checkInputVazio == count($itemSolicitacaos)) {
            return redirect()->back()->with('inputNULL', 'Informe os valores das quantidades aprovadas!');
        }
        if ($checkQuantMinima > 0) {
            return redirect()->back()->withErrors($errorMessage);
        }
        for ($i = 0; $i < count($itensID); ++$i) {
            DB::update('update item_solicitacaos set quantidade_aprovada = ? where id = ?', [$quantMatAprovados[$i], $itensID[$i]]);
        }

        DB::update(
            'update historico_statuses set status = ?, data_aprovado = now() where solicitacao_id = ?',
            [0 == $checkInputVazio && 0 == $checkQuantAprovada ? 'Aprovado' : 'Aprovado Parcialmente', $solicitacaoID]
        );

        DB::update('update solicitacaos set observacao_admin = ? where id = ?', [$observacaoAdmin, $solicitacaoID]);

        if (session()->exists('itemSolicitacoes')) {
            session()->forget('itemSolicitacoes');
        }
        if (session()->exists('status')) {
            session()->forget('status');
        }

        $solicitacao = Solicitacao::where('id', $solicitacaoID)->first();
        $usuario = Usuario::where('id', $solicitacao->usuario_id)->first();

        \App\Jobs\emailSolicitacaoAprovada::dispatch($usuario, $solicitacao);

        return redirect()->back()->with('success', 'Solicitação Aprovada com sucesso!');
    }

    public function listSolicitacoesRequerente()
    {
        $solicitacoes = Solicitacao::where('usuario_id', '=', Auth::user()->id)->get();
        $historicoStatus = HistoricoStatus::whereIn('solicitacao_id', array_column($solicitacoes->toArray(), 'id'))->orderBy('id', 'desc')->get();

        $solicitacoesID = array_column($historicoStatus->toArray(), 'solicitacao_id');
        $materiaisPreview = [];

        if (!empty($solicitacoesID)) {
            $materiaisPreview = $this->getMateriaisPreview($solicitacoesID, 'solicitacao_id');
        }

        return view('solicitacao.minha_solicitacao_requerente', [
            'status' => $historicoStatus, 'materiaisPreview' => $materiaisPreview,
        ]);
    }

    public function listSolicitacoesAnalise()
    {
        $consulta = DB::select('select status.status, status.created_at, status.solicitacao_id, u.nome
            from historico_statuses status, usuarios u, solicitacaos soli
            where status.data_aprovado IS NULL and status.data_finalizado IS NULL and status.solicitacao_id = soli.id
            and soli.usuario_id = u.id and u.cargo_id != 2 order by status.id desc');

        $solicitacoesID = array_column($consulta, 'solicitacao_id');
        $materiaisPreview = [];

        if (!empty($solicitacoesID)) {
            $materiaisPreview = $this->getMateriaisPreview($solicitacoesID);
        }

        return view('solicitacao.analise_solicitacoes', [
            'dados' => $consulta, 'materiaisPreview' => $materiaisPreview,
        ]);
    }

    public function listSolicitacoesAprovadas()
    {
        $consulta = DB::select('select status.status, status.created_at, status.solicitacao_id, u.nome
            from historico_statuses status, usuarios u, solicitacaos soli
            where status.data_aprovado IS NOT NULL and status.data_finalizado IS NULL and status.solicitacao_id = soli.id
            and soli.usuario_id = u.id and u.cargo_id != 2 order by status.id desc');

        $solicitacoesID = array_column($consulta, 'solicitacao_id');
        $materiaisPreview = [];

        if (!empty($solicitacoesID)) {
            $materiaisPreview = $this->getMateriaisPreview($solicitacoesID);
        }

        return view('solicitacao.entrega_materiais', [
            'dados' => $consulta, 'materiaisPreview' => $materiaisPreview,
        ]);
    }

    public function listTodasSolicitacoes()
    {
        $consulta = DB::select('select status.status, status.created_at, status.solicitacao_id, u.nome
            from historico_statuses status, usuarios u, solicitacaos soli
            where status.data_finalizado IS NOT NULL and status.solicitacao_id = soli.id
            and soli.usuario_id = u.id and u.cargo_id != 2 order by status.id desc');

        $solicitacoesID = array_column($consulta, 'solicitacao_id');
        $materiaisPreview = [];

        if (!empty($solicitacoesID)) {
            $materiaisPreview = $this->getMateriaisPreview($solicitacoesID);
        }

        return view('solicitacao.todas_solicitacao', [
            'dados' => $consulta, 'materiaisPreview' => $materiaisPreview,
        ]);
    }

    public function checkEntregarMateriais(Request $request)
    {
        if ('aprovar_entrega' == $request->action) {
            return $this->entregarMateriais($request->solicitacaoID);
        }
        if ('cancelar_entrega' == $request->action) {
            return $this->cancelarEntregaMataeriais($request->solicitacaoID);
        }
    }

    public function entregarMateriais($id)
    {
        $itens = ItemSolicitacao::where('solicitacao_id', '=', $id)->where('quantidade_aprovada', '!=', null)->get();
        $materiaisID = array_column($itens->toArray(), 'material_id');
        $quantAprovadas = array_column($itens->toArray(), 'quantidade_aprovada');

        $estoque = Estoque::wherein('material_id', $materiaisID)->where('deposito_id', 1)->orderBy('material_id', 'asc')->get();

        $checkQuant = true;
        $errorMessage = [];

        foreach($itens as $item){
            $estoqueItem = Estoque::where('material_id', $item->material_id)->where('deposito_id', 1)->first();
            $materialNome = Material::where('id', $item->material_id)->first();

            if(($estoqueItem->quantidade - $item->quantidade_aprovada) < 0){
                $checkQuant = false;
                $message = $materialNome->nome.' quantidade disponível('.$estoqueItem->quantidade.')'. ' - quantidade aprovada('.$item->quantidade_aprovada.')';
                array_push($errorMessage, $message);
            }
        }



        if ($checkQuant) {
            $materiais = Material::all();
            $usuarios = Usuario::all();

            for ($i = 0; $i < count($materiaisID); ++$i) {
                DB::update('update estoques set quantidade = quantidade - ? where material_id = ? and deposito_id = 1', [$quantAprovadas[$i], $materiaisID[$i]]);

                $material = $materiais->find($materiaisID[$i]);
                $estoque = DB::table('estoques')->where('material_id', '=', $materiaisID[$i])->first();
                if (($estoque->quantidade - $quantAprovadas[$i]) <= $material->quantidade_minima) {
                    foreach ($usuarios as $usuario){
                        if ($usuario->cargo_id == 2) {
                            \App\Jobs\emailMaterialEsgotando::dispatch($usuario, $material);

                            $mensagem = $material->nome.' em estado critico.';
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
            }

            DB::update(
                'update historico_statuses set status = ?, data_finalizado = now() where solicitacao_id = ?',
                ['Entregue', $id]
            );

            return redirect()->back()->with('success', 'Material(is) entregue(s) com sucesso!');
        }
        array_push($errorMessage, 'Reabasteça o estoque do depósito de atendimento para realizar a entrega!');

        return redirect()->back()->withErrors($errorMessage);
    }

    public function cancelarEntregaMataeriais($id)
    {
        DB::update(
            'update historico_statuses set status = ?, data_finalizado = now() where solicitacao_id = ?',
            ['Cancelado', $id]
        );

        return redirect()->back()->with('success', 'Material(is) cancelado(s) com sucesso!');
    }

    public function getItemSolicitacaoRequerente($id)
    {
        $usuarioID = Solicitacao::select('usuario_id')->where('id', '=', $id)->get();

        if (Auth::user()->id != $usuarioID[0]->usuario_id) {
            return json_encode('');
        }

        $consulta = DB::select('select item.quantidade_solicitada, item.quantidade_aprovada, mat.nome, mat.descricao
            from item_solicitacaos item, materials mat where item.solicitacao_id = ? and mat.id = item.material_id', [$id]);

        return json_encode($consulta);
    }

    public function getItemSolicitacaoAdmin($id)
    {
        if (session()->exists('itemSolicitacoes')) {
            session()->forget('itemSolicitacoes');
        }

        $consulta = DB::select('select item.quantidade_solicitada, item.material_id, mat.nome, mat.corredor, mat.prateleira, mat.coluna, mat.descricao, mat.unidade, item.quantidade_aprovada, item.id, item.quantidade_solicitada, est.quantidade
            from item_solicitacaos item, materials mat, estoques est where item.solicitacao_id = ? and mat.id = item.material_id and est.material_id = item.material_id and est.deposito_id = 1', [$id]);

        session(['itemSolicitacoes' => $consulta]);

        return json_encode($consulta);


    }

    public function getObservacaoSolicitacao($id)
    {
        $usuarioID = Solicitacao::select('usuario_id')->where('id', '=', $id)->get();
        if (1 == Auth::user()->cargo_id && Auth::user()->id != $usuarioID[0]->usuario_id) {
            return json_encode('');
        }

        $consulta = DB::select('select observacao_requerente, observacao_admin, receptor_rg, receptor_tipo, receptor from solicitacaos where id = ?', [$id]);

        return json_encode($consulta);
    }

    public function getMateriaisPreview($solicitacoes_id)
    {
        $materiaisIDItem = ItemSolicitacao::select('material_id', 'solicitacao_id')->whereIn('solicitacao_id', $solicitacoes_id)->orderBy('solicitacao_id', 'desc')->get();
        $itensSolicitacaoID = array_values(array_unique(array_column($materiaisIDItem->toArray(), 'solicitacao_id')));

        $materiais = DB::select('select item.material_id, item.solicitacao_id, mat.nome
            from item_solicitacaos item, materials mat
            where item.solicitacao_id in ('.implode(',', $solicitacoes_id).') and item.material_id = mat.id');

        $materiaisPreview = [];
        $auxCountMaterial = 0;

        for ($i = 0; $i < count($itensSolicitacaoID); ++$i) {
            for ($b = 0; $b < count($materiais); ++$b) {
                if ($auxCountMaterial > 2) {
                    break;
                }
                if ($itensSolicitacaoID[$i] == $materiais[$b]->solicitacao_id) {
                    if ($auxCountMaterial > 0) {
                        $materiaisPreview[$i] .= ', '.$materiais[$b]->nome;
                    } else {
                        array_push($materiaisPreview, $materiais[$b]->nome);
                    }
                    ++$auxCountMaterial;
                }
            }
            $auxCountMaterial = 0;
        }

        return $materiaisPreview;
    }

    public function cancelarSolicitacaoReq($id)
    {
        $usuarioID = Solicitacao::select('usuario_id')->where('id', '=', $id)->get();

        if (Auth::user()->id != $usuarioID[0]->usuario_id) {
            return redirect()->back();
        }

        $solicitacao = HistoricoStatus::select('data_finalizado')->where('solicitacao_id', $id)->get();

        if (is_null($solicitacao[0]->data_finalizado)) {
            DB::update(
                'update historico_statuses set status = ?, data_finalizado = now() where solicitacao_id = ?',
                ['Cancelado', $id]
            );

            return redirect()->back()->with('success', 'A solicitação foi cancelada.');
        }

        return redirect()->back()->with('error', 'A solicitação não pode ser cancelada pois já foi finalizada.');
    }
}
