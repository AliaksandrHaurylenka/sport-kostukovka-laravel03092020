@component('mail::message')
<div>{{$data['text']}}</div><br>

{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent--}}

Спасибо,<br>
с уважением<br>
{{ $data['name'] }}<br>
<a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
@endcomponent