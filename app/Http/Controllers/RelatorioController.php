<?php

namespace App\Http\Controllers;

use App\Estoque;
use App\ItemSolicitacao;
use App\Solicitacao;
use App\Material;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RelatorioController extends Controller
{
    public function relatorio_escolha()
    {
        $materiais = Material::all();
        return view('relatorio.relatorio_escolha', compact('materiais'));
    }

    public function gerarRelatorioMateriais(Request $request)
    {
        if ($request->tipo_relatorio != 4 && $request->tipo_relatorio != 6 && $request->tipo_relatorio != 7 && $request->tipo_relatorio != 8) {
            Validator::make(
                $request->all(),
                [
                    'data_inicio' => 'required', 'date',
                    'data_fim' => 'required', 'date',
                    'tipo_relatorio' => 'required',
                ],
                [
                    'data_inicio.required' => 'A data de início deve ser informada',
                    'data_fim.required' => 'A data de fim deve ser informada',
                    'tipo_relatorio.required' => 'Escolha um tipo de relatório',
                ]
            )->validate();
        } elseif($request->tipo_relatorio == 8)
        {
            Validator::make(
                $request->all(),
                [
                    'material_id' => 'required',
                    'data_inicio_item' => 'required', 'date',
                    'data_fim_item' => 'required', 'date',
                    'tipo_relatorio' => 'required',
                ],
                [
                    'material_id.required' => 'É necessário selecionar o material',
                    'data_inicio_item.required' => 'A data de início deve ser informada',
                    'data_fim_item.required' => 'A data de fim deve ser informada',
                    'tipo_relatorio.required' => 'Escolha um tipo de relatório',
                ]
            )->validate();
        }

        $datas = [$request->data_inicio, $request->data_fim];
        $datas_item = [$request->data_inicio_item, $request->data_fim_item];
        $data_inicio = date('Y-m-d H:i:s', strtotime($request->data_inicio));
        $data_inicio_item = date('Y-m-d H:i:s', strtotime($request->data_inicio_item));
        $data_fim = date('Y-m-d H:i:s', strtotime($request->data_fim . ' +1 day'));
        $data_fim_item = date('Y-m-d H:i:s', strtotime($request->data_fim_item . ' +1 day'));
        $materiais = '';
        $solicitacoes = '';
        $material = null;
        $quant_materiais_solicitados = 0;
        $quantidades = [];
        $estoques = '';
        if (8 == $request->tipo_relatorio) {
            $material = Material::find($request->material_id);
            $solicitacoes = ItemSolicitacao::join('solicitacaos', 'item_solicitacaos.solicitacao_id', '=', 'solicitacaos.id')
                ->join('historico_statuses', 'solicitacaos.id', '=', 'historico_statuses.solicitacao_id')
                ->where('historico_statuses.data_finalizado', '>=', $data_inicio_item)->where('historico_statuses.data_finalizado', '<=', $data_fim_item)
                ->where('item_solicitacaos.material_id', '=', $request->material_id)
                ->get();
            foreach ($solicitacoes as $item)
            {
                $quant_materiais_solicitados += $item->quantidade_aprovada;
            }
        } else if (7 == $request->tipo_relatorio) {
            $materiais = Material::all()->sortBy('id');
            $estoques = Estoque::all();
        } else if (6 == $request->tipo_relatorio) {
            $materiais = Material::join('estoques', 'materials.id', '=', 'estoques.material_id')
                ->where('estoques.deposito_id', '=', 1)->whereColumn('estoques.quantidade', '<=', 'materials.quantidade_minima')->get();
        } else if (5 == $request->tipo_relatorio) {
            $solicitacoes = Solicitacao::join('historico_statuses', 'solicitacaos.id', '=', 'historico_statuses.solicitacao_id')
                ->where('historico_statuses.data_finalizado', '>=', $data_inicio)->where('historico_statuses.data_finalizado', '<=', $data_fim)
                ->where('historico_statuses.status', '=', 'Entregue')->get();

            foreach ($solicitacoes as $solicitacao) {
                foreach ($solicitacao->itensSolicitacoes as $item) {
                    if (array_key_exists($item->material->nome, $quantidades)) {
                        $quantidades[$item->material->nome][1] += $item->quantidade_aprovada;
                    } else {
                        $quantidades[$item->material->nome] = [$item->material->unidade, $item->quantidade_aprovada];
                    }
                }
            }
            ksort($quantidades);
        } elseif (4 == $request->tipo_relatorio) {
            $materiais = DB::select("select mat.nome, mat.codigo, mat.descricao, mat.unidade, item.quantidade_solicitada, usuario.nome as nome_usuario, count(*)
            from materials mat, item_solicitacaos item, historico_statuses status, solicitacaos soli, usuarios usuario
            where (item.created_at >= now() - interval '7 days') and item.solicitacao_id = soli.id
            and status.solicitacao_id = soli.id and soli.usuario_id = usuario.id and status.data_aprovado is not null and status.data_finalizado is not null
            and status = 'Entregue' and mat.id = item.material_id group by mat.id,item.quantidade_solicitada, usuario.nome having count(*) >= 10 order by mat.id");
        } elseif (3 == $request->tipo_relatorio) {
            $materiais = DB::select("select mat.nome, mat.codigo, mat.descricao, mat.unidade, item.quantidade_aprovada, usuario.nome as nome_usuario
            from materials mat, item_solicitacaos item, historico_statuses status, solicitacaos soli, usuarios usuario
            where (status.data_finalizado between '" . $data_inicio . "' and '" . $data_fim . "') and item.solicitacao_id = soli.id
            and status.solicitacao_id = soli.id and soli.usuario_id = usuario.id and status.data_aprovado is not null and status.data_finalizado is not null
            and status = 'Entregue' and mat.id = item.material_id order by mat.id");
        } elseif (2 == $request->tipo_relatorio) {
            $materiais = DB::select("select mat.nome, mat.codigo, mat.descricao, mat.unidade, est.quantidade from materials mat, estoques est where mat.id = est.material_id
            except
            select mat.nome, mat.codigo, mat.descricao, mat.unidade, est.quantidade from materials mat, item_solicitacaos item, estoques est
            where (item.created_at between '" . $data_inicio . "' and '" . $data_fim . "')
            and mat.id = item.material_id and mat.id = est.material_id order by nome");
        } elseif (0 == $request->tipo_relatorio || 1 == $request->tipo_relatorio) {
            $materiais = DB::select("select dep.nome as nomeDep, mat.nome as nomeMat, mat.unidade, mat.descricao, mat.codigo, itensMov.quantidade
            from materials mat, depositos dep, item_movimentos itensMov, movimentos mov, estoques est
            where mov.created_at between '" . $data_inicio . "' and '" . $data_fim . "' and mov.operacao = ? and itensMov.movimento_id = mov.id and itensMov.material_id = mat.id and
            itensMov.estoque_id = est.id and est.deposito_id = dep.id", [$request->tipo_relatorio]);
        }

        $tipo_relatorio = $request->tipo_relatorio;
        $nomePDF = '';
        $pdf = null;

        $data_inicio = date('d/m/Y', strtotime($request->data_inicio));
        $data_fim = date('d/m/Y', strtotime($request->data_fim));

        if (8 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_material_especifico_entregue', compact('solicitacoes', 'quant_materiais_solicitados', 'material', 'datas_item'));
            $nomePDF = 'Relatório_Consultar_Materiais.pdf';
        }
        else if (7 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_consultar_materiais', compact('materiais', 'estoques'));
            $nomePDF = 'Relatório_Consultar_Materiais.pdf';
        }
        else if (6 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_materiais_em_estado_critico', compact('materiais', 'datas'));
            $nomePDF = 'Relatório_Materiais_Em_Estado_Critico.pdf';
        } else if (5 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_solicitacoes_entregues', compact('solicitacoes', 'datas', 'quantidades'));
            $nomePDF = 'Relatório_Solicitações_Entregues_De_' . $data_inicio . '_A_' . $data_fim . '.pdf';
        } elseif (4 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_materiais_mais_movimentados_solicitacoes', compact('materiais'));
            $nomePDF = 'Relatório_Materiais_Mais_Movimentados_Solicitação_Semana.pdf';
        } elseif (3 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_saida_materiais_solicitacoes', compact('materiais', 'datas'));
            $nomePDF = 'Relatório_Saída_Materiais_Solicitações_De_' . $data_inicio . '_A_' . $data_fim . '.pdf';
        } elseif (2 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_materiais_nao_movimentados', compact('materiais', 'datas'));
            $nomePDF = 'Relatório_Materiais_Não_Movimentados_De_' . $data_inicio . '_A_' . $data_fim . '.pdf';
        } elseif (0 == $request->tipo_relatorio || 1 == $request->tipo_relatorio) {
            $pdf = PDF::loadView('/relatorio/relatorio_entrada_saida_materiais', compact('materiais', 'datas', 'tipo_relatorio'));
            $nomePDF = 0 == $request->tipo_relatorio ? 'Relatório_Entrada_De_Materiais_De_' . $data_inicio . '_A_' . $data_fim . '.pdf' :
                'Relatório_Saida_De_Materiais_De_' . $data_inicio . '_A_' . $data_fim . '.pdf';
        }

        return $pdf->setPaper('a4')->stream($nomePDF);
    }
}
