@extends('emails.base')

@section('content')

<h2 style="margin-top:0;font-size: 20px;font-weight: 700;">{{ $subject }}</h2>

@foreach ($bodies as $body)
    <p>{{ $body }}</p>
@endforeach

@endsection