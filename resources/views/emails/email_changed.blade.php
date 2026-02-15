@extends('emails.base')

@section('content')

<h2 style="margin-top:0;">Yth. {{ $user->name }},</h2>

<p>
    Kami ingin memberitahu Anda bahwa email yang didaftarkan pada {{ env('EVENT_NAME') }} telah berhasil diubah.
</p>

<p>
    Seluruh komunikasi dan pemberitahuan akan kami kirimkan melalui email baru Anda berikut ini :
</p>

<div style="background: #eeeeee;color: #444444;padding: 10px;border-radius: 8px;text-align: center;padding-vertical: 10px;margin-bottom: 12px;font-size: 18px;">
    {{ $email }}
</div>

<p>
    Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di {{ env('EMAIL') }} atau {{ env('PHONE') }}.
</p>
<p>Terima kasih atas partisipasi Anda.</p>
<p>
    Hormat Kami,<br />
    Panitia {{ env('EVENT_NAME') }}
</p>

@endsection