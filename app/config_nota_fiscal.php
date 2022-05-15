<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class config_nota_fiscal extends Model
{
    public static $rules = [
        'nome' => 'bail|min:3|max:50',
        'cnpj' => 'min:14|max:14',
        'cep' => 'min:8|max:8',
        'fone' => 'min:10|max:11'
    ];

    public static $messages = [
        'nome.min' => 'O nome do material deve ter no mínimo 3 caracteres.',
        'nome.max' => 'O nome do material deve ter no máximo 50 caracteres.',
        'cnpj.*' => 'O cnpj deve possuir exatamente 14 caracteres',
        'cep.*' => 'O cep deve possuir exatamente 8 caracteres',
        'fone.*' => 'O fone deve possuir 10 ou 11 números'
    ];
}
