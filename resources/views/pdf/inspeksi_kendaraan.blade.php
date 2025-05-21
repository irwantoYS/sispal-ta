<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
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
</head>

<body>
    <div class="header">
        <h2>LAPORAN INSPEKSI KENDARAAN</h2>
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
                    <p>Jakarta, {{ \Carbon\Carbon::parse($inspeksi->tanggal_inspeksi)->format('d F Y') }}</p>
                    <br><br><br>
                    <p>( {{ $user->name }} )</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
