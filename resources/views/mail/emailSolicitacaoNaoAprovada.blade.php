@component('mail::message')

<h1>Olá {{$usuario->nome}}</h1>

<p>
  Sua solicitação de material não foi aprovada*.
</p>

<p>
  Motivo da não aprovação: {{$solicitacao->observacao_admin}}
</p>

<p>
  http://solicitamaterial.ufape.edu.br/login
</p>

@endcomponent