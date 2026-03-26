@extends('emails.base')

@section('content')

<h2 style="margin-top:0;">Kepada Yth. {{ $data->name }},</h2>

<p>
    Anda telah membeli tiket untuk acara Nonton Bareng Sendratari Ramayana yang merupakan bagian dari rangkaian acara {{ env('EVENT_NAME') }}.
</p>

<table border="0" style="border-width: 0;width: 100%;">
    <tr>
        <td>Lokasi</td>
        <td>: {{ env('RAMAYANA_PLACE') }}</td>
    </tr>
    <tr>
        <td>Waktu</td>
        <td>: {{ env('RAMAYANA_TIME') }}</td>
    </tr>
</table>

<p>
    Hormat Kami,<br />
    Panitia {{ env('EVENT_NAME') }}
</p>

@endsection