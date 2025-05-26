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
                $logoPath = public_path('kai/assets/img/kaiadmin/pgncom-logo.png');
                $logoDataUri = null;
                if (file_exists($logoPath)) {
                    try {
                        $logoContent = file_get_contents($logoPath);
                        $logoBase64 = base64_encode($logoContent);
                        $logoMime = mime_content_type($logoPath);
                        if ($logoMime) {
                            $logoDataUri = 'data:' . $logoMime . ';base64,' . $logoBase64;
                        }
                    } catch (\Exception $e) {
                        // Opsional: log error jika perlu
                        // \Log::error("Error processing logo for PDF: " . $e->getMessage());
                    }
                }
            @endphp
            <div class="header-left">
                @if ($logoDataUri)
                    <img src="{{ $logoDataUri }}" alt="Logo Perusahaan" style="max-width: 100px; height: auto;">
                @else
                    <p style="font-size: 10px;">Logo</p>
                @endif
            </div>
            <div class="header-right">
                <h1>PT. Perusahaan Gas Negara, Tbk</h1>
                <p>Jalan Raya Kota, No. 123, Kota Anda</p>
                <p>Telp. (0721) XXXXXX</p>
                <p>Email: info@pgnro4.com</p>
            </div>
        </header>

        <h2>History Laporan Perjalanan Pengguna</h2>

        <div class="mb-4">
            <p><strong>Total Estimasi Jarak:</strong> {{ number_format($totalEstimasiJarak, 2, '.', '') }} KM</p>
            <p><strong>Total Estimasi BBM:</strong> {{ number_format($totalEstimasiBBM, 2, '.', '') }} Liter</p>
            <p><strong>Total Estimasi Waktu:</strong> {{ $totalDurasiFormat }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengemudi</th>
                    <th>Nama Pegawai</th>
                    <th>Titik Awal</th>
                    <th>Titik Akhir</th>
                    <th>Tujuan Perjalanan</th>
                    <th>No Kendaraan</th>
                    <th>Tipe Kendaraan</th>
                    <th>Estimasi Jarak Tempuh</th>
                    <th>Estimasi Waktu</th>
                    <th>Estimasi BBM</th>
                    <th>BBM Awal</th>
                    <th>BBM Akhir</th>
                    <th>Jam Pergi</th>
                    <th>Jam Kembali</th>
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
                        <td>{{ $item->titik_awal ?? '-' }}</td>
                        <td>{{ $item->titik_akhir ?? '-' }}</td>
                        <td>{{ $item->tujuan_perjalanan ?? '-' }}</td>
                        <td>{{ $item->Kendaraan->no_kendaraan ?? '-' }}</td>
                        <td>{{ $item->Kendaraan->tipe_kendaraan ?? '-' }}</td>
                        <td>{{ $item->km_akhir ?? '-' }}</td>
                        <td>{{ $item->estimasi_waktu ?? '-' }}</td>
                        <td>{{ $item->estimasi_bbm ?? '-' }} Liter</td>
                        <td>{{ $item->bbm_awal ?? '-' }}</td>
                        <td>{{ $item->bbm_akhir ?? '-' }}</td>
                        <td>{{ $item->jam_pergi ? \Carbon\Carbon::parse($item->jam_pergi)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td>{{ $item->jam_kembali ? \Carbon\Carbon::parse($item->jam_kembali)->format('d/m/Y H:i') : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <p>Mengetahui,</p>
            <div class="signature-line"></div>
            <p class="signature-name">Nama Pejabat</p>
            <p class="signature-title">Jabatan</p>
        </div>
    </div>

    <footer>
        <p>© {{ date('Y') }} PT. Perusahaan Gas Negara, Tbk. Semua Hak Dilindungi.</p>
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
        display: flex;
        /* Menggunakan flexbox */
        justify-content: space-between;
        /* Menempatkan elemen di kedua ujung */
        align-items: center;
        /* Pusatkan secara vertikal */
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid black;
    }

    .header-left img {
        max-width: 100px;
        height: auto;
    }

    .header-right {
        text-align: right;
        /* Teks di sebelah kanan */
    }

    .header-right h1 {
        font-size: 16px;
        margin: 0 0 5px;
        font-weight: bold;
    }

    .header-right p {
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
        margin-top: 5px;
        font-size: 12px;
    }

    .signature-title {
        font-size: 12px;
    }
</style>
</head>

</html>
