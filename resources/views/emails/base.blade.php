<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? config('app.name') }}</title>
    <style>
        /* Mobile Responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                margin: 0px !important;
                border-radius: 0px !important;
            }

            .content {
                padding: 20px !important;
            }

            .responsive-img {
                width: 100% !important;
                height: auto !important;
            }

            .button {
                display: block !important;
                width: 100% !important;
                text-align: center !important;
            }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4">
    <tr>
        <td align="center">

            <!-- Container -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container" style="background:#ffffff;margin:20px 0;border-radius:8px;overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#111827;padding:0px;text-align:center;">
                        <img src="{{ request()->getSchemeAndHttpHost() }}/images/kop_surat.jpg" alt="Kop Surat" style="width: 100%;">
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td class="content" style="padding:30px;color:#333333;font-size:14px;line-height:1.6;">
                        @yield('content')
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f9fafb;padding:20px;text-align:center;font-size:12px;color:#6b7280;">
                        {{ env('EVENT_NAME') }}
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>