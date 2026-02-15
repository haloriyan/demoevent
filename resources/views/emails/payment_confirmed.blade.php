@extends('emails.base')

@php
    $qrString = base64_encode(json_encode([
        'trx_id' => $trx->id,
        'user_id' => $trx->user_id,
    ]));
@endphp

@section('content')

<h2 style="margin-top:0;">Yth. {{ $trx->user->name }},</h2>

<p>
    Kami ingin mengkonfirmasi bahwa pembayaran Anda untuk {{ env('EVENT_NAME') }} telah berhasil.
</p>
<p>
    Sebagai bukti transaksi, kami lampirkan kode QR yang akan digunakan saat registrasi ulang di lokasi acara. Mohon simpan kode QR ini dengan baik dan tunjukkan kepada petugas registrasi saat kedatangan.
</p>

<div style="text-align: center;padding-top: 20px;padding-bottom: 35px;">
    <img src="https://api.qrserver.com/v1/create-qr-code/?data='.$qrString.'&size=256x256" width="256">
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