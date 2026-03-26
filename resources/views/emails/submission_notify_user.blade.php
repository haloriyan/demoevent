@extends('emails.base')

@section('content')

<h2 style="margin-top:0;">Yth. {{ $submission->name }},</h2>

<p>
    Terima kasih telah mengirimkan submission {{ ucwords($submission->type) }} dalam rangkaian acara {{ env('EVENT_NAME') }}
</p>

<p>
    Dan perlu Kami sampaikan kembali bahwa kriteria dan hasil penilaian merupakan kewenangan para juri sepenuhnya dan tidak dapat diganggu-gugat.
</p>

<p>
    Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di {{ env('EMAIL') }} atau {{ env('PHONE') }}.
</p>
<p>Terima kasih atas partisipasi Anda.</p>
<p>
    Hormat Kami,<br />
    Panitia {{ env('EVENT_NAME') }}
</p>

@endsection