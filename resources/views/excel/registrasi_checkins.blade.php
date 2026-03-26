@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        <tr>
            <th colspan="4" style="font-size: 24px; font-weight: medium; text-align: center;">CHECK-IN REGISTRASI</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Timestamp</th>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Nama</th>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Instansi</th>
            <th style="font-weight: bold; background-color: #eee; color: #333;">Keikutsertaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($checkins as $check)
            <tr>
                <td>{{ $check->created_at }}</td>
                <td>{{ $check->user->name }}</td>
                <td>{{ $check->user->instansi ?? '-' }}</td>
                <td>{{ $check->ticket->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>