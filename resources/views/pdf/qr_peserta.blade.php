@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html>
<head>
    <style>
        @font-face {
            font-family: 'Bebas Regular';
            font-style: normal;
            font-weight: 400;
            src: url("{{ storage_path('fonts/Bebas-Regular.ttf') }}") format('truetype');
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .name {
            font-family: 'Bebas Regular', Arial, sans-serif;
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
            width: 80mm;
            height: 120mm;
            border: 1px solid #ccc;
            text-align: center;
            vertical-align: top;
            overflow: hidden;

            background-image: url("{{ public_path('images/id_card.jpg') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: center;
        }

        .card_inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;

            padding: 80px 25px 30px 25px;
        }

        .spacer {
            height: 24mm;
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
            /* font-weight: 700; */
        }

        .instansi {
            font-family: 'Bebas Regular', Arial, sans-serif;
            font-size: 7pt;
            /* font-weight: 500; */
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
                                <div style="height: 4mm;"></div>
                                <h2 class="name">{{ $user->name }}</h2>
                                @if ($user->instansi)
                                    <div style="height: 1mm;"></div>
                                    <h4 class="instansi">{{ @$user->instansi ?? '-' }}</h4>
                                    <div style="height: 2mm;"></div>
                                @endif
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