<?php

namespace App\Mail;

use App\Solicitacao;
use App\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailSolicitacaoAprovada extends Mailable
{
    use Queueable, SerializesModels;
    private $usuario;
    private $solicitacao;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Usuario $usuario, Solicitacao $solicitacao)
    {
        $this->usuario = $usuario;
        $this->msolicitacao = $solicitacao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Solicitação Aprovada');
        $this->to($this->usuario->email, $this->usuario->nome);
        return $this->markdown('mail.emailSolicitacaoAprovada', [
            'usuario' => $this->usuario,
            'solicitacao' => $this->solicitacao
        ]);
    }
}
