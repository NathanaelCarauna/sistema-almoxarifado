<?php

namespace App\Http\Controllers;

use App\Estoque;
use App\Material;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estoques = Estoque::all()->sortByDesc('id');
        $materials = Material::all()->sortByDesc('id');

        return view('material.material_consult', ['materials' => $materials, 'estoques' => $estoques]);
    }

    public function indexEdit()
    {

        $materials = Material::all()->sortByDesc('id');
        return view('material.material_index_edit', ['materials' => $materials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("material.material_create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Material::$rules, Material::$messages)->validate();

        if (($request->hasFile('imagem') && $request->file('imagem')->isValid())) {

            $imgExtension = $request->imagem->extension();
            $imgName = Img::nameNewImage(Material::all(), $request->nome, $imgExtension);

            $request->imagem->storeAs(Img::materiaisDir(), $imgName);
            $request->imagem = $imgName;
        }

        $data = [
            'nome' => $request->nome,
            'codigo' => $request->codigo,
            'descricao' => $request->descricao,
            'quantidade_minima' => $request->quantidade_minima,
            'imagem' => $request->imagem,
            'corredor' => $request->corredor,
            'prateleira' => $request->prateleira,
            'coluna' => $request->coluna
        ];

        $material = Material::create($data);
        $material->save();

        return redirect(route('material.indexEdit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('material.material_edit', ['material' => Material::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $rules = array_slice(Material::$rules, 0, 4);
        $messages = array_slice(Material::$messages, 0, 10);

        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $data = [
            'nome' => $request->nome,
            'codigo' => $request->codigo,
            'descricao' => $request->descricao,
            'quantidade_minima' => $request->quantidade_minima,
            'corredor' => $request->corredor,
            'prateleira' => $request->prateleira,
            'coluna' => $request->coluna
        ];

        if (($request->hasFile('imagem') && $request->file('imagem')->isValid())) {

            $rules = array_slice(Material::$rules, 4);
            $messages = array_slice(Material::$messages, 10);

            $validator = Validator::make($request->all(), $rules, $messages)->validate();

            $imgExtension = $request->imagem->extension();
            $imgName = Img::nameNewImage(Material::all(), $request->nome, $imgExtension);

            $request->imagem->storeAs(Img::materiaisDir(), $imgName);
            $request->imagem = $imgName;
            $data['imagem'] = $request->imagem;
        }

        $material->fill($data);
        $material->save();
        return redirect()->route('material.indexEdit')->with('sucess', 'Material atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $material = Material::all()->find($id);
        $estoque = Estoque::all()->where('material_id', '=', $id)->first();
        if (empty($estoque)) {
            $material->forceDelete();
            return redirect()->route('material.indexEdit')->with('sucess', 'Material removido com sucesso!');
        } elseif ($estoque->quantidade == 0) {
            $estoque->delete();
            $material->delete();
            return redirect()->route('material.indexEdit')->with('sucess', 'Material removido com sucesso!');
        } else {
            return redirect()->back()->with('fail', 'Esse material não pode ser removido, ainda há material em estoque!');
        }
    }
}
