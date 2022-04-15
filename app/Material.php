<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    protected $fillable = ['nome', 'codigo', 'descricao', 'quantidade_minima', 'imagem', 'corredor', 'prateleira', 'coluna', 'unidade'];

    public static $rules = [
        'nome' => 'bail|min:3|required|max:50',
        'codigo' => 'bail|min:1|required|max:20',
        'quantidade_minima' => 'required|integer|min:1',
        'descricao' => 'bail|min:5|required|max:255',
        'imagem' => 'image'
    ];

    public static $messages = [
        'nome.required' => 'O nome do material é obrigatório',
        'nome.min' => 'O nome do material deve ter no mínimo 3 caracteres.',
        'nome.max' => 'O nome do material deve ter no máximo 50 caracteres.',
        'codigo.required' => 'O código do material é obrigatório',
        'codigo.min' => 'O código do material deve ter no mínimo 1 caractere.',
        'codigo.max' => 'O código do material deve ter no máximo 20 caracteres.',
        'quantidade_minima.required' => 'A quantidade mínima é obrigatória',
        'quantidade_minima.min' => 'A quantidade mínima deve ser maior que 0',
        'descricao.required' => 'A descrição do material é obrigatória',
        'descricao.min' => 'A descrição do material deve ter no mínimo 5 caracteres.',
        'descricao.max' => 'A descrição do material deve ter no máximo 255 caracteres.',
    ];
}
