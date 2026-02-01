@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        @if ($role == "ADMIN")
            <tr>
                <th colspan="{{ $role == "ADMIN" ? 8 : 2 }}" style="text-align: center; font-size: 24px; font-weight: medium;">DATA PESERTA</th>
            </tr>
        @endif
        <tr>
            @if ($role == "ADMIN")
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Booth</th>
                <th style="font-weight: bold; background-color: #eeeeee; color: #333;">NIK</th>
            @endif
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Nama</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Instansi</th>
            @if ($role == "ADMIN")
                <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Email</th>
                <th style="font-weight: bold; background-color: #eeeeee; color: #333;">No. Telepon</th>
                <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Keikutsertaan</th>
            @endif
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Timestamp</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($checkins as $check)
            <tr>
                @if ($role == "ADMIN")
                    <td>{{ $check->booth->name }}</td>
                    <td>{{ $check->user->nik }}</td>
                @endif
                <td>{{ $check->user->name }}</td>
                <td>{{ $check->user->instansi ?? '-' }}</td>
                @if ($role == "ADMIN")
                    <td>{{ $check->user->email ?? '-' }}</td>
                    <td>{{ $check->user->whatsapp ?? '-' }}</td>
                    <td>{{ $check->user->transaction->ticket->name }}</td>
                @endif
                <td>{{ Carbon::parse($check->created_at)->isoFormat('DD MMM YYYY, HH:mm') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>