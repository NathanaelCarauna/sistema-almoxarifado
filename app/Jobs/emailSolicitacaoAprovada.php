<?php

namespace App\Jobs;

use App\Solicitacao;
use App\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class emailSolicitacaoAprovada implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $usuario, $solicitacao;
    public $tries = 10;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Usuario $usuario, Solicitacao $solicitacao)
    {
        $this->usuario = $usuario;
        $this->solicitacao = $solicitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Illuminate\Support\Facades\Mail::send(new \App\Mail\emailSolicitacaoAprovada($this->usuario, $this->solicitacao));
    }
}
