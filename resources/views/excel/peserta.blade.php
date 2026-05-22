@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        <tr>
            <th colspan="9" style="text-align: center; font-size: 24px; font-weight: medium;">DATA PESERTA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">No.</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Nama</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Instansi</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Email</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">No. Telepon</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">NIK</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Keikutsertaan</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Status Pembayaran</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Timestamp</th>
        </tr>
        @if (!empty($filters))
        <tr>
            <th colspan="9">Filter: {{ implode(' | ', $filters) }}</th>
        </tr>
        @endif
    </thead>
    <tbody>
        @foreach ($peserta as $user)
            @php
                $paymentStatus = $user->transaction->payment_status;
                $statusColor = "#e6be10";
                if ($paymentStatus == 'PAID') {
                    $statusColor = "#2ecc71";
                }
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->instansi ?? '-' }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td>{{ (string) $user->whatsapp ?? '-' }}</td>
                <td >{{ (string) $user->nik }}</td>
                <td>
                    {{ $user->transaction->ticket->name }}
                </td>
                <td style="background-color: {{ $statusColor }};color: #fff">
                    {{ $user->transaction->payment_status }}
                </td>
                <td>{{ Carbon::parse($user->created_at)->isoFormat('DD MMM YYYY, HH:mm') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>