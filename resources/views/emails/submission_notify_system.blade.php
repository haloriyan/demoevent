@extends('emails.base')

@section('content')

<p>
    Berikut adalah detail dari Submission {{ ucwords($submission->type) }} yang baru saja dikirim :
</p>

<table border="0" style="border-width: 0;width: 100%;">
    <tr>
        <td>Nama</td>
        <td>: {{ $submission->name }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>: {{ $submission->email }}</td>
    </tr>
    <tr>
        <td>Submission</td>
        <td>: {{ ucwords($submission->type) }} ( File Terlampir )</td>
    </tr>
</table>

@endsection