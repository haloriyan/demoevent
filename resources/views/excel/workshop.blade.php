@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        <tr>
            <th colspan="4" style="text-align: center; font-size: 24px; font-weight: medium;">DATA PESERTA WORKSHOP</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($workshops as $ws)
            <tr>
                <th colspan="4" style="text-align: center;font-weight: medium;font-size: 18px;">{{ $ws->title }}</th>
            </tr>
            <tr>
                <th style="font-weight: medium;">Nama</th>
                <th style="font-weight: medium;">Instansi</th>
                <th style="font-weight: medium;">Email</th>
                <th style="font-weight: medium;">No. Telepon</th>
            </tr>
            @foreach ($ws->users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->instansi ?? "-" }}</td>
                    <td>{{ $user->email ?? "-" }}</td>
                    <td>{{ $user->whatsapp ?? "-" }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>