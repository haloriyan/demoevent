@php
    use Carbon\Carbon;
    $colors = [
        'PAID' => "green",
        'PENDING' => "yellow"
    ];
@endphp
<table>
    <thead>
        <tr>
            <th colspan="5" style="font-size: 24px; font-weight: medium; text-align: center;">TIKET RAMAYANA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Nama</th>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Email</th>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Jumlah Tiket</th>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Total Pembayaran</th>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trx)
            @php
                $color = $colors[$trx->payment_status];
            @endphp
            <tr>
                <td>{{ $trx->name }}</td>
                <td>{{ $trx->email }}</td>
                <td>{{ $trx->quantity }}</td>
                <td>{{ $trx->total_pay }}</td>
                <td style="background-color: {{ $color }};">{{ strtoupper($trx->payment_status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>