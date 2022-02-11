@component('mail::message')
# introdução

Corpo da mensagem

@component('mail::button', ['url' => ''])
texto do botao
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
