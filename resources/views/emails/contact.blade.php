@component("mail::message")
{{-- Greeting --}}
# @lang(':name sent a message.', ['name'=>$name])

@component('mail::panel')
{{ $message }}
@endcomponent

{{-- Salutation --}}
@lang('Regards'),<br>
{{ config('app.name') }}
@endcomponent
