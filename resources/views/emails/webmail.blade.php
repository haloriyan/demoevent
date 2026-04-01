@extends('emails.base')

@section('content')

<h2 style="margin-top:0;">{{ $subject }}</h2>

@foreach ($bodies as $body)
    <p>{{ $body }}</p>
@endforeach

@endsection