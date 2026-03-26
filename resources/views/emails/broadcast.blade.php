@extends('emails.base')

@php
    $messages = explode(PHP_EOL, )
@endphp

@section('content')

<h2 style="margin-top:0;">Yth. {{ $user->name }},</h2>

@foreach ($messages as $msg)
    <p>
        {{ $msg }}
    </p>
@endforeach

@endsection