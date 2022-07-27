<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    public function itensSolicitacoes(){
        return $this->hasMany('App\ItemSolicitacao');
    }
    public function historicoStatus(){
        return $this->hasMany('App\HistoricoStatus');
    }
}
