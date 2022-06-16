@component('mail::message')

<h1>Olá {{$usuario->nome}}</h1>

<p>
  Sua solicitação de material foi aprovada*. Favor dirigir-se ao Galpão de Almoxarifado nas Segundas, Quartas e    Sextas-feiras para retirada do material. 
</p>

<p>
  Informamos que o material ficará reservado durante 08 (oito) dias corridos a contar da data da aprovação da solicitação, após este período a solicitação será cancelada.
</p>

<p>
  *algumas solicitações são aprovadas parcialmente, gentileza verificar o campo observações do Administrador para saber o motivo.
</p>

<p>
  http://solicitamaterial.ufape.edu.br/login
</p>

@endcomponent