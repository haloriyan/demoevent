@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 24px; font-weight: medium;">DATA SUBMISSIONS</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">ID</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Nama</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Email</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Submission</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">File</th>
            <th style="font-weight: bold; background-color: #eeeeee; color: #333;">Timestamp</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $sub)
            <tr>
                <td>#{{ $sub->id }}</td>
                <td>{{ $sub->name }}</td>
                <td>{{ $sub->email }}</td>
                <td>{{ strtoupper($sub->type) }}</td>
                <td>{{ request()->getSchemeAndHttpHost() }}/storage/submission_{{ $sub->type }}/{{ $sub->file }}</td>
                <td>{{ $sub->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
