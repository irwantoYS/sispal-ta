@extends('layouts.sidebardriver') {{-- Sesuaikan dengan nama layout yang Anda gunakan --}}

@section('title', 'Detail Inspeksi')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h1>Detail Inspeksi Kendaraan</h1>
                </div>
            </div>
           

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Inspeksi Tanggal: {{ $inspeksi->tanggal_inspeksi }}</h5>
                    <p>Kendaraan: {{ $inspeksi->kendaraan->no_kendaraan }} - {{ $inspeksi->kendaraan->tipe_kendaraan }}</p>
                    <p>Driver: {{ $inspeksi->user->nama }}</p> {{-- Tampilkan nama driver --}}
                    <p>Status Kendaraan:
                        @if ($inspeksi->status === 'ready')
                            <span class="badge bg-success">Ready</span>
                        @elseif ($inspeksi->status === 'in_use')
                            <span class="badge bg-info">In Use</span>
                        @elseif ($inspeksi->status === 'perlu_perbaikan')
                            <span class="badge bg-warning">Perlu Perbaikan</span>
                        @else
                            {{ $inspeksi->status }}
                        @endif
                    </p>
                    <p>Catatan: {{ $inspeksi->catatan ?? '-' }}</p>

                    <hr>

                    <h3>Hasil Inspeksi:</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Kondisi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Bagian Kendaraan --}}
                            <tr>
                                <td>Body</td>
                                <td>{{ $inspeksi->body_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->body_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Ban</td>
                                <td>{{ $inspeksi->ban_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->ban_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Stir</td>
                                <td>{{ $inspeksi->stir_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->stir_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Rem kaki dan rem tangan</td>
                                <td>{{ $inspeksi->rem_kaki_tangan_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->rem_kaki_tangan_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pedal Kopling, Gas, Rem</td>
                                <td>{{ $inspeksi->pedal_kopling_gas_rem_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->pedal_kopling_gas_rem_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Starter</td>
                                <td>{{ $inspeksi->starter_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->starter_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Oli Mesin</td>
                                <td>{{ $inspeksi->oli_mesin_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->oli_mesin_keterangan ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td>Tangki BBM dan Pompa</td>
                                <td>{{ $inspeksi->tangki_bb_pompa_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->tangki_bb_pompa_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Radiator, Pompa, Fanbelt</td>
                                <td>{{ $inspeksi->radiator_pompa_fanbelt_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->radiator_pompa_fanbelt_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Transmisi</td>
                                <td>{{ $inspeksi->transmisi_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->transmisi_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Knalpot</td>
                                <td>{{ $inspeksi->knalpot_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->knalpot_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Klakson</td>
                                <td>{{ $inspeksi->klakson_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->klakson_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alarm Mundur</td>
                                <td>{{ $inspeksi->alarm_mundur_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->alarm_mundur_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lampu Depan</td>
                                <td>{{ $inspeksi->lampu_depan_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_depan_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lampu Sign</td>
                                <td>{{ $inspeksi->lampu_sign_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_sign_keterangan ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td>Lampu Kabin dan Pintu</td>
                                <td>{{ $inspeksi->lampu_kabin_pintu_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_kabin_pintu_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lampu Rem</td>
                                <td>{{ $inspeksi->lampu_rem_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_rem_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lampu Mundur</td>
                                <td>{{ $inspeksi->lampu_mundur_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_mundur_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lampu DRL</td>
                                <td>{{ $inspeksi->lampu_drl_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_drl_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Indikator Kecepatan</td>
                                <td>{{ $inspeksi->indikator_kecepatan_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->indikator_kecepatan_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Indikator Bahan Bakar</td>
                                <td>{{ $inspeksi->indikator_bb_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->indikator_bb_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Indikator Temperatur</td>
                                <td>{{ $inspeksi->indikator_temperatur_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->indikator_temperatur_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lampu Depan dan Lampu Belakang</td>
                                <td>{{ $inspeksi->lampu_depan_belakang_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_depan_belakang_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lampu Rem</td>
                                <td>{{ $inspeksi->lampu_rem2_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lampu_rem2_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Baut Roda</td>
                                <td>{{ $inspeksi->baut_roda_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->baut_roda_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jendela</td>
                                <td>{{ $inspeksi->jendela_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->jendela_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Wiper Washer</td>
                                <td>{{ $inspeksi->wiper_washer_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->wiper_washer_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Spion</td>
                                <td>{{ $inspeksi->spion_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->spion_keterangan ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td>Kunci Pintu</td>
                                <td>{{ $inspeksi->kunci_pintu_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->kunci_pintu_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Kursi</td>
                                <td>{{ $inspeksi->kursi_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->kursi_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Sabuk Keselamatan</td>
                                <td>{{ $inspeksi->sabuk_keselamatan_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->sabuk_keselamatan_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Apar</td>
                                <td>{{ $inspeksi->apar_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->apar_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Perlengkapan Kebocoran</td>
                                <td>{{ $inspeksi->perlengkapan_kebocoran_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->perlengkapan_kebocoran_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Segitiga Pengaman</td>
                                <td>{{ $inspeksi->segitiga_pengaman_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->segitiga_pengaman_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Kotak P3K</td>
                                <td>{{ $inspeksi->kotak_p3k_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->kotak_p3k_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Lap Majun</td>
                                <td>{{ $inspeksi->lap_majun_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->lap_majun_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Safety Boots</td>
                                <td>{{ $inspeksi->safety_boots_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->safety_boots_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Safety Helmet</td>
                                <td>{{ $inspeksi->safety_helmet_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->safety_helmet_keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Sarung Tangan</td>
                                <td>{{ $inspeksi->sarung_tangan_baik ? 'Baik' : 'Tidak Baik' }}</td>
                                <td>{{ $inspeksi->sarung_tangan_keterangan ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('driver.kendaraan') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
