@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
        }

        .ib {
            display: flex;
            flex-direction: row;
            gap: 4px;
        }

        .page {
            page-break-after: always;
            width: 180mm;
        }

        .grid {
            display: table;
            width: 180mm;
            border-collapse: collapse;
        }

        .row {
            display: table-row;
        }

        .card {
            display: table-cell;
            width: 90mm;
            height: 118mm;
            border: 1px solid #ccc;
            text-align: center;
            vertical-align: top;
            overflow: hidden;

            background-image: url("{{ public_path('images/kartu_bg.jpg') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: center;
        }

        .card_inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;

            padding-top: 50px;
            padding-bottom: 30px;
        }

        .spacer {
            height: 45mm;
            flex-shrink: 0;
        }

        .qr-img {
            width: 110px;
            height: 110px;
        }

        .name {
            font-size: 10pt;
            font-weight: bold;
            margin: 12px 6px 4px 6px;
            line-height: 1.2;
        }

        .instansi {
            font-size: 8.5pt;
            margin: 0 6px;
            line-height: 1.2;
        }

        .ws {
            font-size: 7pt;
            color: #89251c;
            margin-top: 4px;
        }

        .card--empty {
            border: none;
            background: none;
        }
    </style>
</head>

<body>

@foreach ($pages as $page)
    <div class="page">
        <div class="grid">

            <div class="row">
                @for ($i = 0; $i < 2; $i++)
                    @if (@$page[$i])
                        @php
                            $user = $page[$i];
                            $qrString = base64_encode(json_encode([
                                'trx_id' => $user->transaction->id,
                                'user_id' => $user->id,
                            ]));
                            $svg = QrCode::size(110)->generate($qrString);
                            $qr = base64_encode($svg);
                            $workshops = json_decode($user->transaction->workshops);
                        @endphp
                        <div class="card">
                            <div class="card_inner">
                                <div class="spacer"></div>
                                <img class="qr-img" src="data:image/svg+xml;base64,{{ $qr }}">
                                <h2 class="name">{{ $user->name }}</h2>
                                <div class="ib">
                                    @foreach ($workshops ?? [] as $ws)
                                        <div class="ws">{{ $ws->title }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card card--empty"></div>
                    @endif
                @endfor
            </div>

            <div class="row">
                @for ($i = 2; $i < 4; $i++)
                    @if (@$page[$i])
                        @php
                            $user = $page[$i];
                            $qrString = base64_encode(json_encode([
                                'trx_id' => $user->transaction->id,
                                'user_id' => $user->id,
                            ]));
                            $svg = QrCode::size(110)->generate($qrString);
                            $qr = base64_encode($svg);
                            $workshops = json_decode($user->transaction->workshops);
                        @endphp
                        <div class="card">
                            <div class="card_inner">
                                <div class="spacer"></div>
                                <img class="qr-img" src="data:image/svg+xml;base64,{{ $qr }}">
                                <h2 class="name">{{ $user->name }}</h2>
                                <div class="ib">
                                    @foreach ($workshops ?? [] as $ws)
                                        <div class="ws">{{ $ws->title }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card card--empty"></div>
                    @endif
                @endfor
            </div>

        </div>
    </div>
@endforeach

</body>
</html>