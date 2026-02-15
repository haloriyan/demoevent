@extends('emails.base')

@section('content')

<h2 style="margin-top:0;">Yth. {{ $user->name }},</h2>

<p>
    Kami ingin mengkonfirmasi bahwa pendaftaran Anda untuk {{ env('EVENT_NAME') }} telah berhasil.
</p>

<p>
    Berikut adalah detail pendaftaran Anda :
</p>
<table border="0" style="border-width: 0;width: 100%;">
    <tr>
        <td>NIK</td>
        <td>: {{ $user->nik }}</td>
    </tr>
    <tr>
        <td>Nama Lengkap</td>
        <td>: {{ $user->name }}</td>
    </tr>
    <tr>
        <td>Alamat Email</td>
        <td>: {{ $user->email }}</td>
    </tr>
    <tr>
        <td>Nomor Telepon</td>
        <td>: 0{{ $user->whatsapp }}</td>
    </tr>
    <tr>
        <td>Kepesertaan</td>
        <td>: {{ $trx->ticket->name }}</td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>: {{ $trx->id }}</td>
    </tr>
</table>

<p>
    {{ env('EVENT_NAME') }} akan diselenggarakan pada :
</p>
<p>
    Tanggal : 
    @if (preg_match('/\d/', $trx->ticket->name) && strpos($trx->ticket->name, 'WS') >= 0)
        8 - 10 Oktober 2026
    @else
        9 - 10 Oktober 2026
    @endif
</p>

<p>
    Pembayaran dapat dilakukan dengan transfer ke rekening PIT PERABDIN
</p>
<table border="0" style="border-width: 0;width: 100%;">
    <tr>
        <td>Nominal</td>
        <td>: {{ currency_encode($trx->payment_amount) }}</td>
    </tr>
    <tr>
        <td>Bank</td>
        <td>: {{ env('BANK_NAME') }}</td>
    </tr>
    <tr>
        <td>No. Rekening</td>
        <td>: {{ env('BANK_NUMBER') }}</td>
    </tr>
</table>

<p>
    Kemudian mohon mengirim foto bukti transaksi pada link berikut :
</p>
<div style="text-align: center;padding: 10px;">
    <a href="{{ route('pembayaran', $trx->id) }}" style="background: #B84F26;color: #fff;padding: 15px 25px;border-radius: 8px;text-decoration: none;">
        Upload Bukti Pembayaran
    </a>
</div>

<p>
    Anda juga dapat melakukan pembayaran instan tanpa menunggu konfirmasi melalui tautan berikut
</p>

<p>
    <a href="{{ route('pembayaran.instan', $trx->id) }}">{{ route('pembayaran.instan', $trx->id) }}</a>
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