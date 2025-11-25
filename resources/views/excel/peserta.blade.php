@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        <tr>
            <th colspan="10" style="text-align: center; font-size: 24px; font-weight: medium;">DATA PESERTA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">No. Pendaftaran</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Nama</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Email</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">No. Telepon</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Instansi</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">NIK</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Keikutsertaan</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Timestamp</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peserta as $user)
            <tr>
                <td>{{ $user->transaction->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td>{{ $user->whatsapp ?? '-' }}</td>
                <td>{{ $user->instansi ?? '-' }}</td>
                <td>{{ $user->nik }}</td>
                <td>{{ $user->transaction->ticket->name }}</td>
                <td>{{ Carbon::parse($user->created_at)->isoFormat('DD MMM YYYY, HH:mm') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>