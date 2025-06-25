<!DOCTYPE html>
<html>

<head>
    <title>Status Perjalanan</title>

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
                            <h1>PT. Perusahaan Gas Negara, Tbk</h1>
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
        <h3>FORUM PEMAKAIAN KENDARAAN</h3>
    </div>

    <div class="info">
        <p><b>Nama Pengemudi:</b> {{ $perjalanan->user->nama }}</p>
        <p><b>Role:</b> {{ $perjalanan->user->role }}</p>
    </div>

    <p style="margin-top: 20px">Dengan ini melaporkan perjalanan dinas yang dilakukan dengan rincian sebagai
        berikut:</p>

    <table>
        <thead>
            <tr>
                <th>Nama Pengguna</th>
                <th>Titik Awal</th>
                <th>Titik Akhir</th>
                <th>Tujuan Perjalanan</th>
                <th>No. Kendaraan</th>
                <th>Tipe Kendaraan</th>
                <th>Jenis BBM</th>
                <th>Estimasi Jarak Pergi</th>
                <th>BBM Awal</th>
                <th>Jam Pergi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @php
                        $namaPegawaiString = $perjalanan->nama_pegawai ?? '-';
                        $namaPegawaiDecoded = html_entity_decode($namaPegawaiString);
                        $namaArray = json_decode($namaPegawaiDecoded);
                        if (is_array($namaArray)) {
                            echo e(implode(', ', $namaArray));
                        } else {
                            echo e($namaPegawaiDecoded);
                        }
                    @endphp
                </td>
                <td>{{ $perjalanan->titik_awal }}</td>
                <td>{{ $perjalanan->titik_akhir }}</td>
                <td>{{ $perjalanan->tujuan_perjalanan }}</td>
                <td>{{ $perjalanan->kendaraan->no_kendaraan }}</td>
                <td>{{ $perjalanan->kendaraan->tipe_kendaraan }}</td>
                <td>{{ $perjalanan->jenis_bbm ?? '-' }}</td>
                <td>{{ $perjalanan->estimasi_jarak ?? '-' }} KM</td>
                <td>{{ $perjalanan->bbm_awal }}/8</td>
                <td>{{ $perjalanan->jam_pergi }}</td>
            </tr>
        </tbody>
    </table>

    <div class="status-section" style="margin-top: 20px;">
        <p>
            <strong>Status Perjalanan:</strong>
            <span
                style="
                    padding: 5px 10px;
                    border-radius: 5px;
                    color: white;
                    background-color: @if ($perjalanan->status == 'disetujui') #28a745
                                     @elseif($perjalanan->status == 'ditolak') #dc3545
                                     @else #ffc107 @endif;
                ">
                {{ ucfirst($perjalanan->status) }}
            </span>
        </p>
        @if ($perjalanan->validator)
            <p><strong>Divalidasi Oleh:</strong> {{ $perjalanan->validator->nama ?? '-' }}</p>
        @endif
        @if ($perjalanan->status == 'ditolak' && $perjalanan->alasan)
            <p><strong>Alasan Penolakan:</strong> {{ $perjalanan->alasan }}</p>
        @endif
    </div>

    <div class="signature">
        <p>Bandar Lampung, {{ date('d F Y', strtotime($perjalanan->created_at)) }}</p>
        <p>Hormat Saya,</p>
        <div class="signature-image">
            @if ($perjalanan->user->ttd)
                <img src="{{ public_path('storage/' . $perjalanan->user->ttd) }}" alt="Tanda Tangan" width="100px"
                    height="100px">
            @endif
        </div>
        <p>{{ $perjalanan->user->nama }}</p>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak pada {{ date('d-m-Y') }}</p>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #5c9abc;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
        }

        .signature-image {
            text-align: right;
        }

        .signature p {
            margin: 5px 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid black;
            padding-top: 5px;
        }
    </style>
</body>

</html>
