@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html>
<head>
	<style>
		body {
			font-family: sans-serif;
		}

		.page {
			page-break-after: always;
			width: 100%;
		}

		.grid {
			display: table;
			width: 100%;
		}

		.row {
			display: table-row;
		}

		.card {
            display: table-cell;
            width: 50%;
            height: 450px;
            border: 1px solid #ccc;
            /* vertical-align: middle; */
            text-align: center;
        }
        .card_inner {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            flex-grow: 1;
            flex-shrink: 1;
        }
        .card_content {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

		.qr {
			margin-bottom: 10px;
		}
        .name {
            margin: 20px 0 10px 0;
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
                            $svg = QrCode::size(200)->generate($qrString);
                            $qr = base64_encode($svg);
                        @endphp
                        <div class="card">
                            <img src="{{ public_path('images/kop_surat.jpg') }}" alt="Kop" style="width: 100%;">
                            <div class="card_inner">
                                <div style="height: 40px;"></div>
                                <img src="data:image/svg+xml;base64,{{ $qr }}" width="200" height="200">
                                <h2 class="name">{{ $page[$i]->name }}</h2>
                                <div class="instansi">{{ $page[$i]->instansi }}</div>
                            </div>
                        </div>
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
                                'user_id' => $user-> id,
                            ]));
                            $svg = QrCode::size(200)->generate($qrString);
                            $qr = base64_encode($svg);
                        @endphp
                        <div class="card">
                            <img src="{{ public_path('images/kop_surat.jpg') }}" alt="Kop" style="width: 100%;">
                            <div class="card_inner">
                                <div style="height: 40px;"></div>
                                <img src="data:image/svg+xml;base64,{{ $qr }}" width="200" height="200">
                                <h2 class="name">{{ $page[$i]->name }}</h2>
                                <div class="instansi">{{ $page[$i]->instansi }}</div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
@endforeach

</body>
</html>