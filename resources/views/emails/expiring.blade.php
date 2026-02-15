@extends('emails.base')

@section('content')

<h2 style="margin-top:0;">Yth. {{ $trx->user->name }},</h2>

<p>
    Kami dari panitia {{ env('EVENT_NAME') }} ingin menyampaikan terima kasih atas pendaftaran Anda.
</p>
<p>
    Namun, kami mohon maaf untuk memberitahukan bahwa pendaftaran Anda terpaksa kami batalkan karena telah melewati batas waktu pembayaran. Sesuai dengan ketentuan yang berlaku, pendaftaran yang tidak disertai pembayaran dalam batas waktu yang ditentukan akan otomatis dibatalkan oleh sistem.
</p>
<p>
    Kami memahami bahwa hal ini mungkin menimbulkan ketidaknyamanan. Jika Anda masih berminat untuk mengikuti {{ env('EVENT_NAME') }}, Anda dapat melakukan pendaftaran ulang.
</p>

<div style="text-align: center;padding: 10px;margin: 15px 0;">
    <a href="{{ url('/') }}" style="background: #B84F26;color: #fff;padding: 15px 25px;border-radius: 8px;text-decoration: none;">
        Ulangi Pendaftaran
    </a>
</div>

<p>
    Kami sangat menghargai minat Anda untuk berpartisipasi dalam acara ini dan berharap Anda dapat bergabung bersama kami di {{ env('EVENT_NAME') }} mendatang.
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