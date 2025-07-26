<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perjalanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


<body>
    <div class="container">
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
                        // Opsional: log error jika perlu
                        // \Log::error("Error processing logo for PDF: " . $e->getMessage());
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
                        // Opsional: log error jika perlu
                        // \Log::error("Error processing logo for PDF: " . $e->getMessage());
                    }
                }
            @endphp
            <table style="width: 100%; border-collapse: collapse;">
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
                                <img src="{{ $logoDataUri2 }}" alt="Logo Pertamina"
                                    style="max-width: 150px; height: auto;">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>

        <h2>History Laporan Perjalanan Pengguna</h2>

        <div class="mb-4">
            <p><strong>Total Estimasi Jarak:</strong> {{ number_format($totalEstimasiJarak, 2, '.', '') }} KM</p>
            <p><strong>Total KM Manual:</strong> {{ number_format($totalKmManual, 2, '.', '') }} KM</p>
            <p><strong>Total Estimasi BBM:</strong> {{ number_format($totalEstimasiBBM, 2, '.', '') }} Liter</p>
            <p><strong>Total Estimasi Waktu:</strong> {{ $totalDurasiFormat }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengemudi</th>
                    <th>Nama Pegawai</th>
                    <th>Tujuan Perjalanan</th>
                    <th>Tipe Kendaraan</th>
                    <th>No Kendaraan</th>
                    <th>Estimasi Jarak</th>
                    <th>KM Awal (M)</th>
                    <th>KM Akhir (M)</th>
                    <th>Total KM (M)</th>
                    <th>Jam Pergi</th>
                    <th>Jam Kembali</th>
                    <th>Divalidasi Oleh</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $nomor = 1; // Inisialisasi variabel nomor di luar loop
                @endphp

                @foreach ($perjalanan as $item)
                    <tr>
                        <td>{{ $nomor++ }}</td> {{-- Increment nomor untuk setiap baris --}}
                        <td>{{ $item->user->nama ?? '-' }}</td>
                        <td>
                            @php
                                $namaPegawaiString = $item->nama_pegawai ?? '-';
                                $namaPegawaiDecoded = html_entity_decode($namaPegawaiString);
                                $namaArray = json_decode($namaPegawaiDecoded);
                                if (is_array($namaArray)) {
                                    echo e(implode(', ', $namaArray));
                                } else {
                                    echo e($namaPegawaiDecoded);
                                }
                            @endphp
                        </td>
                        <td>{{ $item->tujuan_perjalanan ?? '-' }}</td>
                        <td>{{ $item->Kendaraan->tipe_kendaraan ?? 'N/A' }}</td>
                        <td>{{ $item->Kendaraan->no_kendaraan ?? 'N/A' }}</td>
                        <td>{{ $item->km_akhir ? number_format((float) $item->km_akhir, 2, ',', '.') . ' KM' : '-' }}
                        </td>
                        <td>{{ $item->km_awal_manual ? number_format($item->km_awal_manual) . ' KM' : '-' }}</td>
                        <td>{{ $item->km_akhir_manual ? number_format($item->km_akhir_manual) . ' KM' : '-' }}</td>
                        <td>{{ $item->total_km_manual ? number_format($item->total_km_manual) . ' KM' : '-' }}</td>
                        <td>{{ $item->jam_pergi_formatted ?? '-' }}</td>
                        <td>{{ $item->jam_kembali ? \Carbon\Carbon::parse($item->jam_kembali)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td>{{ $item->validator->nama ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <p>Mengetahui,</p>
            <div class="signature-line"></div>
            <p class="signature-name">Ade Irawan</p>
            <p class="signature-title">Manager Area</p>
        </div>
    </div>

    <footer>
        <p>© {{ date('Y') }} PT. PGAS Telekomunikasi Nusantara. Semua Hak Dilindungi.</p>
    </footer>

    <script type="text/javascript">
        // Script untuk memicu dialog print saat PDF dibuka
        try {
            this.print();
        } catch (e) {
            // Fallback jika this.print() tidak didukung atau diblokir
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>


<style>
    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 11px;
        margin: 0;
        /* Hapus margin default body */
        padding: 0;
        /* Hapus padding default body */
    }

    .container {
        padding: 20px;
    }

    header {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid black;
        width: 100%;
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

    h2 {
        font-size: 14px;
        margin-top: 20px;
        text-align: center;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 10px;
        color: #777;
        border-top: 1px solid black;
        padding-top: 5px;
    }

    .signature {
        margin-top: 40px;
        text-align: center;
        page-break-inside: avoid;
    }

    .signature-line {
        border-bottom: 1px solid black;
        width: 200px;
        margin: 0 auto;
    }

    .signature-name {
        margin-top: 60px;
        font-size: 12px;
    }

    .signature-title {
        font-size: 12px;
    }
</style>
</head>

</html>
