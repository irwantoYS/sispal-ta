<!DOCTYPE html>
<html>

<head>
    <title>Status Perjalanan</title>

</head>

<body>
    <div class="header">
        <img src="{{ public_path('kai/assets/img/kaiadmin/pgncom-logo.png') }}" alt="Logo">
        <h2>PT. PGAS TELEKOMUNIKASI NUSANTARA</h2>
        <p>Bandar Lampung</p>
        <p>Telp: (021) xxx-xxxx, Email: info@namaperusahaan.com</p>
    </div>

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
                <th>Nama Pegawai</th>
                <th>Titik Awal</th>
                <th>Titik Akhir</th>
                <th>Tujuan Perjalanan</th>
                <th>No. Kendaraan</th>
                <th>Tipe Kendaraan</th>
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
                <td>{{ $perjalanan->estimasi_jarak }}</td>
                <td>{{ $perjalanan->bbm_awal }}/8</td>
                <td>{{ $perjalanan->jam_pergi }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Jakarta, {{ date('d F Y', strtotime($perjalanan->created_at)) }}</p>
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

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            /* Sesuaikan ukuran logo */
            height: auto;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header {
            display: flex;
            /* Menggunakan Flexbox */
            justify-content: space-between;
            /* Meletakkan logo dan info perusahaan di ujung */
            align-items: center;
            /* Memposisikan elemen secara vertikal di tengah */
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            /* Tambahkan garis pembatas di bawah header */
            padding-bottom: 10px;
            /* Beri sedikit ruang antara garis dan konten di bawahnya */
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
