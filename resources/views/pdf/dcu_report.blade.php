<!DOCTYPE html>
<html>

<head>
    <title>Laporan DCU</title>
</head>

<body>
    <header>
        @php
            // Logo Kiri
            $logoPath1 = public_path('kai/assets/img/kaiadmin/pgncom-logo.png');
            $logoDataUri1 = null;
            if (file_exists($logoPath1)) {
                try {
                    $logoContent1 = file_get_contents($logoPath1);
                    $logoBase64_1 = base64_encode($logoContent1);
                    $logoMime1 = mime_content_type($logoPath1);
                    if ($logoMime1) {
                        $logoDataUri1 = 'data:' . $logoMime1 . ';base64,' . $logoBase64_1;
                    }
                } catch (\Exception $e) {
                }
            }

            // Logo Kanan
            $logoPath2 = public_path('kai/assets/img/kaiadmin/pertamina-logo.png');
            $logoDataUri2 = null;
            if (file_exists($logoPath2)) {
                try {
                    $logoContent2 = file_get_contents($logoPath2);
                    $logoBase64_2 = base64_encode($logoContent2);
                    $logoMime2 = mime_content_type($logoPath2);
                    if ($logoMime2) {
                        $logoDataUri2 = 'data:' . $logoMime2 . ';base64,' . $logoBase64_2;
                    }
                } catch (\Exception $e) {
                }
            }
        @endphp
        <table style="width: 100%; border-collapse: collapse; border: none;">
            <tbody>
                <tr>
                    <td style="width: 25%; text-align: left; vertical-align: middle; border: none; padding: 0;">
                        @if ($logoDataUri1)
                            <img src="{{ $logoDataUri1 }}" alt="Logo PGNCOM" style="max-width: 150px; height: auto;">
                        @endif
                    </td>
                    <td style="width: 50%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                        <div class="header-center">
                            <h1>PT. PGAS Telekomunikasi Nusantara</h1>
                            <p>35125, Jl. Sam Ratulangi No.15, Penengahan, Kec. Tj. Karang Pusat, Kota Bandar
                                Lampung, Lampung 35126</p>
                            <p>Telp. (0721) 7626359</p>
                            <p>Email: sales@pgncom.co.id</p>
                        </div>
                    </td>
                    <td style="width: 25%; text-align: right; vertical-align: middle; border: none; padding: 0;">
                        @if ($logoDataUri2)
                            <img src="{{ $logoDataUri2 }}" alt="Logo Pertamina" style="max-width: 150px; height: auto;">
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </header>

    <div class="title">
        <h3>DAILY CHECK UP (DCU)</h3>
        <h4>BULAN {{ strtoupper($dcu->created_at->translatedFormat('F Y')) }}</h4>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Nama Pekerja</td>
            <td width="35%">: {{ $dcu->user->nama }}</td>
            <td width="15%">Lokasi</td>
            <td width="35%">: 35125, Jl. Sam Ratulangi No.15, Penengahan, Kec. Tj. Karang Pusat, Kota Bandar Lampung,
                Lampung 35126</td>
        </tr>
        <tr>
            <td>Status Pekerja</td>
            <td>: -</td>
            <td>Pekerjaan</td>
            <td>: {{ $dcu->user->role }}</td>
        </tr>
    </table>

    <table class="table-bordered content-table">
        <thead>
            <tr>
                <th class="text-center">Tgl</th>
                <th class="text-center">Jam</th>
                <th class="text-center">Shift</th>
                <th colspan="2" class="text-center">Tekanan Darah</th>
                <th class="text-center">Nadi</th>
                <th class="text-center">Frekuensi Napas</th>
                <th class="text-center">SpO2</th>
                <th class="text-center">Suhu</th>
                <th class="text-center">Mata</th>
                <th class="text-center">Kesimpulan (Fit/Unfit)</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th class="text-center">Sys</th>
                <th class="text-center">Dias</th>
                <th colspan="6"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">{{ $dcu->created_at->format('d') }}</td>
                <td class="text-center">{{ $dcu->created_at->format('H:i') }}</td>
                <td class="text-center">{{ $dcu->shift }}</td>
                <td class="text-center">{{ $dcu->sistolik }}</td>
                <td class="text-center">{{ $dcu->diastolik }}</td>
                <td class="text-center">{{ $dcu->nadi }}</td>
                <td class="text-center">{{ $dcu->pernapasan }}</td>
                <td class="text-center">{{ $dcu->spo2 }}</td>
                <td class="text-center">{{ $dcu->suhu_tubuh }}</td>
                <td class="text-center">{{ $dcu->mata }}</td>
                <td class="text-center">{{ $dcu->kesimpulan }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Paraf Petugas</p>
        <br><br><br>
        <p>(.....................)</p>
    </div>

    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid black;
            width: 100%;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .title h3 {
            margin-bottom: 2px;
        }

        .title h4 {
            margin-top: 0;
            font-weight: normal;
        }

        .header-center {
            text-align: center;
        }

        .header-center h1 {
            font-size: 16px;
            margin: 0 0 5px;
            font-weight: bold;
        }

        .header-center p {
            font-size: 10px;
            color: #666;
            margin: 0;
        }

        .table-bordered {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .content-table {
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature p {
            margin: 0;
        }
    </style>
</body>

</html>
