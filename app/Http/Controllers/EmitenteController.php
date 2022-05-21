<?php

namespace App\Http\Controllers;

use App\Emitente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EmitenteController extends Controller
{
    public function index()
    {
        return view('emitente.index', ['emitentes' => Emitente::all()]);
    }

    public function edit($id)
    {
        $emitente = Emitente::find($id);
        return view('emitente.edit', ['emitente' => $emitente]);
    }

    public function update(Request $request)
    {
        $emitente = Emitente::find($request->emitente_id);
        $emitente->inscricao_estadual = $request->inscricao_estadual;
        $emitente->cnpj = $request->cnpj;
        $emitente->razao_social = $request->razao_social;
        $emitente->update();

        return redirect(route('emitente.index'))->with('success', 'Emitente Atualizado Com Sucesso!');
    }

    public function create()
    {
        return view('emitente.create');
    }

    public function salvar(Request $request){
        $emitente = new Emitente();
        $emitente->inscricao_estadual = $request->inscricao_estadual;
        $emitente->cnpj = $request->cnpj;
        $emitente->razao_social = $request->razao_social;
        $emitente->save();
        return redirect(route('emitente.index'))->with('success', 'Emitente Criado Com Sucesso!');
    }

    public function remover($id)
    {
        $emitente = Emitente::find($id);
        if($emitente->notasFiscais()->count() == 0){
            $emitente->delete();
            return redirect()->back()->with('success', 'Emitente Removido Com Sucesso!');
        }
        return redirect()->back()->with('fail', 'Emitente possui notas fiscais associadas!');
    }

}
