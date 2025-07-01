<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
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
        <h3>LAPORAN INSPEKSI KENDARAAN</h3>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td>Nomor Kendaraan</td>
                <td>: {{ $kendaraan->no_kendaraan }}</td>
            </tr>
            <tr>
                <td>Tipe Kendaraan</td>
                <td>: {{ $kendaraan->tipe_kendaraan }}</td>
            </tr>
            <tr>
                <td>Tanggal Inspeksi</td>
                <td>: {{ $tanggal_inspeksi }}</td>
            </tr>

        </table>
    </div>

    <div class="inspeksi-section">
        <h3>Hasil Inspeksi</h3>

        <table>
            <tr>
                <th>Komponen</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td>Body Kendaraan</td>
                <td class="{{ $inspeksi->body_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->body_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->body_keterangan }}</td>
            </tr>
            <tr>
                <td>Ban</td>
                <td class="{{ $inspeksi->ban_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->ban_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->ban_keterangan }}</td>
            </tr>
            <tr>
                <td>Stir</td>
                <td class="{{ $inspeksi->stir_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->stir_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->stir_keterangan }}</td>
            </tr>
            <tr>
                <td>Rem (Kaki & Tangan)</td>
                <td class="{{ $inspeksi->rem_kaki_tangan_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->rem_kaki_tangan_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->rem_kaki_tangan_keterangan }}</td>
            </tr>
            <tr>
                <td>Pedal (Kopling, Gas, Rem)</td>
                <td class="{{ $inspeksi->pedal_kopling_gas_rem_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->pedal_kopling_gas_rem_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->pedal_kopling_gas_rem_keterangan }}</td>
            </tr>
            <tr>
                <td>Starter</td>
                <td class="{{ $inspeksi->starter_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->starter_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->starter_keterangan }}</td>
            </tr>
            <tr>
                <td>Oli Mesin</td>
                <td class="{{ $inspeksi->oli_mesin_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->oli_mesin_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->oli_mesin_keterangan }}</td>
            </tr>
            <tr>
                <td>Tangki BBM & Pompa</td>
                <td class="{{ $inspeksi->tangki_bb_pompa_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->tangki_bb_pompa_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->tangki_bb_pompa_keterangan }}</td>
            </tr>
            <tr>
                <td>Radiator, Pompa & Fanbelt</td>
                <td class="{{ $inspeksi->radiator_pompa_fanbelt_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->radiator_pompa_fanbelt_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->radiator_pompa_fanbelt_keterangan }}</td>
            </tr>
            <tr>
                <td>Transmisi</td>
                <td class="{{ $inspeksi->transmisi_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->transmisi_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->transmisi_keterangan }}</td>
            </tr>
            <tr>
                <td>Knalpot</td>
                <td class="{{ $inspeksi->knalpot_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->knalpot_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->knalpot_keterangan }}</td>
            </tr>
            <tr>
                <td>Klakson</td>
                <td class="{{ $inspeksi->klakson_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->klakson_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->klakson_keterangan }}</td>
            </tr>
            <tr>
                <td>Alarm Mundur</td>
                <td class="{{ $inspeksi->alarm_mundur_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->alarm_mundur_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->alarm_mundur_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu Depan</td>
                <td class="{{ $inspeksi->lampu_depan_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_depan_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_depan_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu Sign</td>
                <td class="{{ $inspeksi->lampu_sign_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_sign_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_sign_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu Kabin & Pintu</td>
                <td class="{{ $inspeksi->lampu_kabin_pintu_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_kabin_pintu_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_kabin_pintu_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu Rem</td>
                <td class="{{ $inspeksi->lampu_rem_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_rem_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_rem_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu Mundur</td>
                <td class="{{ $inspeksi->lampu_mundur_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_mundur_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_mundur_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu DRL</td>
                <td class="{{ $inspeksi->lampu_drl_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_drl_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_drl_keterangan }}</td>
            </tr>
            <tr>
                <td>Indikator Kecepatan</td>
                <td class="{{ $inspeksi->indikator_kecepatan_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->indikator_kecepatan_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->indikator_kecepatan_keterangan }}</td>
            </tr>
            <tr>
                <td>Indikator BBM</td>
                <td class="{{ $inspeksi->indikator_bb_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->indikator_bb_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->indikator_bb_keterangan }}</td>
            </tr>
            <tr>
                <td>Indikator Temperatur</td>
                <td class="{{ $inspeksi->indikator_temperatur_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->indikator_temperatur_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->indikator_temperatur_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu Depan & Belakang</td>
                <td class="{{ $inspeksi->lampu_depan_belakang_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_depan_belakang_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_depan_belakang_keterangan }}</td>
            </tr>
            <tr>
                <td>Lampu Rem</td>
                <td class="{{ $inspeksi->lampu_rem2_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->lampu_rem2_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->lampu_rem2_keterangan }}</td>
            </tr>
            <tr>
                <td>Baut Roda</td>
                <td class="{{ $inspeksi->baut_roda_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->baut_roda_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->baut_roda_keterangan }}</td>
            </tr>
            <tr>
                <td>Jendela</td>
                <td class="{{ $inspeksi->jendela_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->jendela_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->jendela_keterangan }}</td>
            </tr>
            <tr>
                <td>Wiper & Washer</td>
                <td class="{{ $inspeksi->wiper_washer_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->wiper_washer_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->wiper_washer_keterangan }}</td>
            </tr>
            <tr>
                <td>Spion</td>
                <td class="{{ $inspeksi->spion_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->spion_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->spion_keterangan }}</td>
            </tr>
            <tr>
                <td>Kunci Pintu</td>
                <td class="{{ $inspeksi->kunci_pintu_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->kunci_pintu_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->kunci_pintu_keterangan }}</td>
            </tr>
            <tr>
                <td>Kursi</td>
                <td class="{{ $inspeksi->kursi_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->kursi_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->kursi_keterangan }}</td>
            </tr>
            <tr>
                <td>Sabuk Keselamatan</td>
                <td class="{{ $inspeksi->sabuk_keselamatan_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->sabuk_keselamatan_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->sabuk_keselamatan_keterangan }}</td>
            </tr>
            <tr>
                <td>APAR</td>
                <td class="{{ $inspeksi->apar_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->apar_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->apar_keterangan }}</td>
            </tr>
            <tr>
                <td>Perlengkapan Kebocoran</td>
                <td class="{{ $inspeksi->perlengkapan_kebocoran_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->perlengkapan_kebocoran_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->perlengkapan_kebocoran_keterangan }}</td>
            </tr>
            <tr>
                <td>Segitiga Pengaman</td>
                <td class="{{ $inspeksi->segitiga_pengaman_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->segitiga_pengaman_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->segitiga_pengaman_keterangan }}</td>
            </tr>
            <tr>
                <td>Safety Cone</td>
                <td class="{{ $inspeksi->safety_cone_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->safety_cone_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->safety_cone_keterangan }}</td>
            </tr>
            <tr>
                <td>Dongkrak & Kunci</td>
                <td class="{{ $inspeksi->dongkrak_kunci_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->dongkrak_kunci_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->dongkrak_kunci_keterangan }}</td>
            </tr>
            <tr>
                <td>Ganjal Ban</td>
                <td class="{{ $inspeksi->ganjal_ban_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->ganjal_ban_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->ganjal_ban_keterangan }}</td>
            </tr>
            <tr>
                <td>Kotak P3K</td>
                <td class="{{ $inspeksi->kotak_p3k_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->kotak_p3k_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->kotak_p3k_keterangan }}</td>
            </tr>
            <tr>
                <td>Dokumen Rutin</td>
                <td class="{{ $inspeksi->dokumen_rutin_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->dokumen_rutin_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->dokumen_rutin_keterangan }}</td>
            </tr>
            <tr>
                <td>Dokumen Service</td>
                <td class="{{ $inspeksi->dokumen_service_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->dokumen_service_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->dokumen_service_keterangan }}</td>
            </tr>
        </table>

        <h3>Kondisi Pengemudi</h3>
        <table>
            <tr>
                <th>Aspek</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td>Kondisi Sehat</td>
                <td class="{{ $inspeksi->pengemudi_sehat_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->pengemudi_sehat_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->pengemudi_sehat_keterangan }}</td>
            </tr>
            <tr>
                <td>Istirahat Cukup</td>
                <td class="{{ $inspeksi->pengemudi_istirahat_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->pengemudi_istirahat_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->pengemudi_istirahat_keterangan }}</td>
            </tr>
            <tr>
                <td>Kondisi Mabuk</td>
                <td class="{{ $inspeksi->pengemudi_mabuk_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->pengemudi_mabuk_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->pengemudi_mabuk_keterangan }}</td>
            </tr>
            <tr>
                <td>Konsumsi Obat</td>
                <td class="{{ $inspeksi->pengemudi_obat_baik ? 'status-baik' : 'status-tidak-baik' }}">
                    {{ $inspeksi->pengemudi_obat_baik ? 'Baik' : 'Tidak Baik' }}
                </td>
                <td>{{ $inspeksi->pengemudi_obat_keterangan }}</td>
            </tr>
        </table>

        @if ($inspeksi->catatan)
            <div style="margin-top: 20px;">
                <h3>Catatan Tambahan</h3>
                <p>{{ $inspeksi->catatan }}</p>
            </div>
        @endif
    </div>

    <div class="footer">
        <table>
            <tr>
                <td style="text-align: right;">
                    <p>Bandar Lampung, {{ \Carbon\Carbon::parse($inspeksi->tanggal_inspeksi)->format('d F Y') }}</p>
                    <br><br><br>
                    <p>( {{ $user->nama }} )</p>
                </td>
            </tr>
        </table>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
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
            font-size: 14px;
            font-weight: bold;
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

        .info-section {
            margin-bottom: 20px;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-section td {
            padding: 5px;
        }

        .info-section td:first-child {
            width: 200px;
            font-weight: bold;
        }

        .inspeksi-section {
            margin-top: 20px;
        }

        .inspeksi-section table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .inspeksi-section th,
        .inspeksi-section td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .inspeksi-section th {
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .footer table {
            width: 100%;
        }

        .footer td {
            padding: 5px;
        }

        .status-baik {
            color: green;
        }

        .status-tidak-baik {
            color: red;
        }
    </style>
</body>

</html>
