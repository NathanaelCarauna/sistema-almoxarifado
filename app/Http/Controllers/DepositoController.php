<?php

namespace App\Http\Controllers;

use App\Deposito;
use App\Estoque;
use App\itemMovimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepositoController extends Controller
{
    public function index()
    {
        return view('deposito/deposito_index', ['depositos' => Deposito::all(), 'estoques' => Estoque::all()]);
    }

    public function consultarDepositoView()
    {
        $depositos = new Deposito();
        $depositos = $depositos->all();
        $estoques = Estoque::all();

        return view('deposito.deposito_consult', compact('depositos', 'estoques'));
    }

    public function getEstoques($deposito_id)
    {
        $estoques = DB::select('Select mat.nome, e.quantidade, e.id from estoques e, Materials mat where e.deposito_id = ? and mat.id = e.material_id', [$deposito_id]);

        return response()->json($estoques);
    }

    public function deletarEstoque($id)
    {
        $estoque = Estoque::find($id);
        $itemMovimento = itemMovimento::where('estoque_id', '=', $estoque->id)->get();
        if($estoque->quantidade == 0){
            foreach ($itemMovimento as $item)
            {
                $item->delete();
            }
            $estoque->forceDelete();

            return redirect()->back()->with(['sucess' => 'Estoque deletado com sucesso!']);
        } else
        {
            return redirect()->back()->with(['fail' => 'Não é possivel deletar esse estoque, ele precisa estar zerado!']);
        }

    }

    public function create()
    {
        return view('deposito/deposito_create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Deposito::$rules, Deposito::$messages)->validate();

        $data = [
            'nome' => $request->nome,
            'codigo' => $request->codigo,
        ];

        $deposito = Deposito::create($data);
        $deposito->save();

        return redirect(route('deposito.index'));
    }

    public function show($id)
    {
        return view('deposito/deposito_show', ['deposito' => Deposito::find($id)]);
    }

    public function edit($id)
    {
        return view('deposito/deposito_edit', ['deposito' => Deposito::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Deposito::$rules, Deposito::$messages)->validate();
        $deposito = Deposito::find($id);

        $data = [
            'nome' => $request->nome,
            'codigo' => $request->codigo,
        ];

        $deposito->fill($data)->save();

        return redirect(route('deposito.index'))->with('sucess', 'Deposito alterado com sucesso!');
    }

    public function destroy($id)
    {
        $estoques = Estoque::all()->where('deposito_id', '=', $id)->first();
        if (empty($estoques)) {
            $deposito = Deposito::all()->find($id);
            $deposito->delete();

            return redirect(route('deposito.index'))->with('sucess', 'Desposito removido com sucesso!');
        }

        return redirect()->back()->with('fail', 'Deposito não vazio, não é possivel remover!');
    }
}
