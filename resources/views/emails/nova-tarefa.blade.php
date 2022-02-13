@component('mail::message')
# {{ $tarefa }}

data Limite Conclusão : {{ $data_limite_conclusao }}
@component('mail::button', ['url' => $url])
Verificar Tarefa
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
