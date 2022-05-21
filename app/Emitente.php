<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emitente extends Model
{
    public function notasFiscais()
    {
        $this->hasMany('App\NotaFiscal');
    }
}
