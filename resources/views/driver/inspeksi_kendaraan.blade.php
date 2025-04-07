@extends('layouts.sidebardriver')  {{-- Ganti ini sesuai layout Anda --}}

@section('title', 'Inspeksi Kendaraan | Driver')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Inspeksi Kendaraan</h3>
                <h6 class="op-7 mb-2">Formulir Inspeksi Kendaraan</h6>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Inspeksi Kendaraan: {{ $kendaraan->no_kendaraan }} - {{ $kendaraan->tipe_kendaraan }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('driver.storeinspeksi', $kendaraan->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tanggal_inspeksi" class="form-label">Tanggal Inspeksi</label>
                            <input type="date" class="form-control" id="tanggal_inspeksi" name="tanggal_inspeksi" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <p class="fw-bold">Kondisi Kendaraan</p>

                         <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Body</label>
                                        <div>
                                            <input type="radio" id="body_baik_ya" name="body_baik" value="1" required
                                                checked> {{-- Default checked --}}
                                            <label for="body_baik_ya">Ya</label>

                                            <input type="radio" id="body_baik_tidak" name="body_baik" value="0">
                                            <label for="body_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="body_keterangan"
                                            name="body_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ban</label>
                                        <div>
                                            <input type="radio" id="ban_baik_ya" name="ban_baik" value="1" required
                                                checked>
                                            <label for="ban_baik_ya">Ya</label>

                                            <input type="radio" id="ban_baik_tidak" name="ban_baik" value="0">
                                            <label for="ban_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="ban_keterangan" name="ban_keterangan"
                                            placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Stir</label>
                                        <div>
                                            <input type="radio" id="stir_baik_ya" name="stir_baik" value="1" required
                                                checked>
                                            <label for="stir_baik_ya">Ya</label>
                                            <input type="radio" id="stir_baik_tidak" name="stir_baik" value="0">
                                            <label for="stir_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="stir_keterangan"
                                            name="stir_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">Rem Kaki dan Rem Tangan</label>
                                        <div>
                                            <input type="radio" id="rem_kaki_tangan_baik_ya" name="rem_kaki_tangan_baik" value="1" required
                                                checked>
                                            <label for="rem_kaki_tangan_baik_ya">Ya</label>

                                            <input type="radio" id="rem_kaki_tangan_baik_tidak" name="rem_kaki_tangan_baik" value="0">
                                            <label for="rem_kaki_tangan_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="rem_kaki_tangan_keterangan" name="rem_kaki_tangan_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">pedal kopling gas rem</label>
                                        <div>
                                            <input type="radio" id="pedal_kopling_gas_rem_baik_ya" name="pedal_kopling_gas_rem_baik" value="1" required
                                                checked>
                                            <label for="pedal_kopling_gas_rem_baik_ya">Ya</label>

                                            <input type="radio" id="pedal_kopling_gas_rem_baik_tidak" name="pedal_kopling_gas_rem_baik" value="0">
                                            <label for="pedal_kopling_gas_rem_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="pedal_kopling_gas_rem_keterangan" name="pedal_kopling_gas_rem_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">starter</label>
                                        <div>
                                            <input type="radio" id="starter_baik_ya" name="starter_baik" value="1" required
                                                checked>
                                            <label for="starter_baik_ya">Ya</label>

                                            <input type="radio" id="starter_baik_tidak" name="starter_baik" value="0">
                                            <label for="starter_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="starter_keterangan" name="starter_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">oli mesin</label>
                                        <div>
                                            <input type="radio" id="oli_mesin_baik_ya" name="oli_mesin_baik" value="1" required
                                                checked>
                                            <label for="oli_mesin_baik_ya">Ya</label>

                                            <input type="radio" id="oli_mesin_baik_tidak" name="oli_mesin_baik" value="0">
                                            <label for="oli_mesin_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="oli_mesin_keterangan" name="oli_mesin_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">tangki bbm pompa</label>
                                        <div>
                                            <input type="radio" id="tangki_bb_pompa_baik_ya" name="tangki_bb_pompa_baik" value="1" required
                                                checked>
                                            <label for="tangki_bb_pompa_baik_ya">Ya</label>

                                            <input type="radio" id="tangki_bb_pompa_baik_tidak" name="tangki_bb_pompa_baik" value="0">
                                            <label for="tangki_bb_pompa_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="tangki_bb_pompa_keterangan" name="tangki_bb_pompa_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">radiator pompa fanbelt</label>
                                        <div>
                                            <input type="radio" id="radiator_pompa_fanbelt_baik_ya" name="radiator_pompa_fanbelt_baik" value="1" required
                                                checked>
                                            <label for="radiator_pompa_fanbelt_baik_ya">Ya</label>

                                            <input type="radio" id="radiator_pompa_fanbelt_baik_tidak" name="radiator_pompa_fanbelt_baik" value="0">
                                            <label for="radiator_pompa_fanbelt_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="radiator_pompa_fanbelt_keterangan" name="radiator_pompa_fanbelt_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">transmisi</label>
                                        <div>
                                            <input type="radio" id="transmisi_baik_ya" name="transmisi_baik" value="1" required
                                                checked>
                                            <label for="transmisi_baik_ya">Ya</label>

                                            <input type="radio" id="transmisi_baik_tidak" name="transmisi_baik" value="0">
                                            <label for="transmisi_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="transmisi_keterangan" name="transmisi_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">knalpot</label>
                                        <div>
                                            <input type="radio" id="knalpot_baik_ya" name="knalpot_baik" value="1" required
                                                checked>
                                            <label for="knalpot_baik_ya">Ya</label>

                                            <input type="radio" id="knalpot_baik_tidak" name="knalpot_baik" value="0">
                                            <label for="knalpot_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="knalpot_keterangan" name="knalpot_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">klakson</label>
                                        <div>
                                            <input type="radio" id="klakson_baik_ya" name="klakson_baik" value="1" required
                                                checked>
                                            <label for="klakson_baik_ya">Ya</label>

                                            <input type="radio" id="klakson_baik_tidak" name="klakson_baik" value="0">
                                            <label for="klakson_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="klakson_keterangan" name="klakson_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">alarm mundur</label>
                                        <div>
                                            <input type="radio" id="alarm_mundur_baik_ya" name="alarm_mundur_baik" value="1" required
                                                checked>
                                            <label for="alarm_mundur_baik_ya">Ya</label>

                                            <input type="radio" id="alarm_mundur_baik_tidak" name="alarm_mundur_baik" value="0">
                                            <label for="alarm_mundur_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="alarm_mundur_keterangan" name="alarm_mundur_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">lampu depan</label>
                                        <div>
                                            <input type="radio" id="lampu_depan_baik_ya" name="lampu_depan_baik" value="1" required
                                                checked>
                                            <label for="lampu_depan_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_depan_baik_tidak" name="lampu_depan_baik" value="0">
                                            <label for="lampu_depan_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="lampu_depan_keterangan" name="lampu_depan_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">lampu sign</label>
                                        <div>
                                            <input type="radio" id="lampu_sign_baik_ya" name="lampu_sign_baik" value="1" required
                                                checked>
                                            <label for="lampu_sign_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_sign_baik_tidak" name="lampu_sign_baik" value="0">
                                            <label for="lampu_sign_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="lampu_sign_keterangan" name="lampu_sign_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">lampu kabin pintu</label>
                                        <div>
                                            <input type="radio" id="lampu_kabin_pintu_baik_ya" name="lampu_kabin_pintu_baik" value="1" required
                                                checked>
                                            <label for="lampu_kabin_pintu_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_kabin_pintu_baik_tidak" name="lampu_kabin_pintu_baik" value="0">
                                            <label for="lampu_kabin_pintu_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="lampu_kabin_pintu_keterangan"
                                            name="lampu_kabin_pintu_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lampu Rem</label>
                                        <div>
                                            <input type="radio" id="lampu_rem_baik_ya" name="lampu_rem_baik" value="1"
                                                required checked>
                                            <label for="lampu_rem_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_rem_baik_tidak" name="lampu_rem_baik"
                                                value="0">
                                            <label for="lampu_rem_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="lampu_rem_keterangan"
                                            name="lampu_rem_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lampu Mundur</label>
                                        <div>
                                            <input type="radio" id="lampu_mundur_baik_ya" name="lampu_mundur_baik"
                                                value="1" required checked>
                                            <label for="lampu_mundur_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_mundur_baik_tidak" name="lampu_mundur_baik"
                                                value="0">
                                            <label for="lampu_mundur_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="lampu_mundur_keterangan"
                                            name="lampu_mundur_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lampu DRL</label>
                                        <div>
                                            <input type="radio" id="lampu_drl_baik_ya" name="lampu_drl_baik" value="1"
                                                required checked>
                                            <label for="lampu_drl_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_drl_baik_tidak" name="lampu_drl_baik"
                                                value="0">
                                            <label for="lampu_drl_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="lampu_drl_keterangan"
                                            name="lampu_drl_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Indikator Kecepatan</label>
                                        <div>
                                            <input type="radio" id="indikator_kecepatan_baik_ya"
                                                name="indikator_kecepatan_baik" value="1" required checked>
                                            <label for="indikator_kecepatan_baik_ya">Ya</label>

                                            <input type="radio" id="indikator_kecepatan_baik_tidak"
                                                name="indikator_kecepatan_baik" value="0">
                                            <label for="indikator_kecepatan_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="indikator_kecepatan_keterangan"
                                            name="indikator_kecepatan_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Indikator Bahan Bakar</label>
                                        <div>
                                            <input type="radio" id="indikator_bb_baik_ya" name="indikator_bb_baik"
                                                value="1" required checked>
                                            <label for="indikator_bb_baik_ya">Ya</label>

                                            <input type="radio" id="indikator_bb_baik_tidak" name="indikator_bb_baik"
                                                value="0">
                                            <label for="indikator_bb_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="indikator_bb_keterangan"
                                            name="indikator_bb_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                 <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Indikator Temperatur</label>
                                        <div>
                                            <input type="radio" id="indikator_temperatur_baik_ya"
                                                name="indikator_temperatur_baik" value="1" required checked>
                                            <label for="indikator_temperatur_baik_ya">Ya</label>

                                            <input type="radio" id="indikator_temperatur_baik_tidak"
                                                name="indikator_temperatur_baik" value="0">
                                            <label for="indikator_temperatur_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="indikator_temperatur_keterangan"
                                            name="indikator_temperatur_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
</div>
                               <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lampu Depan dan Lampu Belakang</label>
                                        <div>
                                            <input type="radio" id="lampu_depan_belakang_baik_ya"
                                                name="lampu_depan_belakang_baik" value="1" required checked>
                                            <label for="lampu_depan_belakang_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_depan_belakang_baik_tidak"
                                                name="lampu_depan_belakang_baik" value="0">
                                            <label for="lampu_depan_belakang_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="lampu_depan_belakang_keterangan"
                                            name="lampu_depan_belakang_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lampu Rem</label>
                                        <div>
                                            <input type="radio" id="lampu_rem2_baik_ya" name="lampu_rem2_baik"
                                                value="1" required checked>
                                            <label for="lampu_rem2_baik_ya">Ya</label>

                                            <input type="radio" id="lampu_rem2_baik_tidak" name="lampu_rem2_baik"
                                                value="0">
                                            <label for="lampu_rem2_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="lampu_rem2_keterangan"
                                            name="lampu_rem2_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
</div>

                               <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                         <label class="form-label">Baut Roda</label>
                                        <div>
                                            <input type="radio" id="baut_roda_baik_ya" name="baut_roda_baik" value="1" required checked>
                                            <label for="baut_roda_baik_ya">Ya</label>
                                            <input type="radio" id="baut_roda_baik_tidak" name="baut_roda_baik" value="0">
                                            <label for="baut_roda_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="baut_roda_keterangan" name="baut_roda_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">Jendela</label>
                                        <div>
                                            <input type="radio" id="jendela_baik_ya" name="jendela_baik" value="1" required
                                                checked>
                                            <label for="jendela_baik_ya">Ya</label>

                                            <input type="radio" id="jendela_baik_tidak" name="jendela_baik" value="0">
                                            <label for="jendela_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="jendela_keterangan" name="jendela_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                               </div>

                               <div class="row">
                                    <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Wiper Washer</label>
                                        <div>
                                             <input type="radio" id="wiper_washer_baik_ya" name="wiper_washer_baik" value="1" required checked>
                                            <label for="wiper_washer_baik_ya">Ya</label>

                                            <input type="radio" id="wiper_washer_baik_tidak" name="wiper_washer_baik" value="0">
                                            <label for="wiper_washer_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="wiper_washer_keterangan" name="wiper_washer_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Spion</label>
                                        <div>
                                          <input type="radio" id="spion_baik_ya" name="spion_baik" value="1" required checked>
                                            <label for="spion_baik_ya">Ya</label>
                                            <input type="radio" id="spion_baik_tidak" name="spion_baik" value="0">
                                            <label for="spion_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="spion_keterangan" name="spion_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                               </div>

                                <div class="row">
                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">Kunci Pintu</label>
                                        <div>
                                            <input type="radio" id="kunci_pintu_baik_ya" name="kunci_pintu_baik" value="1" required
                                                checked>
                                            <label for="kunci_pintu_baik_ya">Ya</label>

                                            <input type="radio" id="kunci_pintu_baik_tidak" name="kunci_pintu_baik" value="0">
                                            <label for="kunci_pintu_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="kunci_pintu_keterangan" name="kunci_pintu_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Kursi</label>
                                        <div>
                                          <input type="radio" id="kursi_baik_ya" name="kursi_baik" value="1" required checked>
                                            <label for="kursi_baik_ya">Ya</label>
                                            <input type="radio" id="kursi_baik_tidak" name="kursi_baik" value="0">
                                            <label for="kursi_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="kursi_keterangan" name="kursi_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                                </div>

                                <div class='row'>
                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">Sabuk Keselamatan</label>
                                        <div>
                                            <input type="radio" id="sabuk_keselamatan_baik_ya" name="sabuk_keselamatan_baik" value="1" required
                                                checked>
                                            <label for="sabuk_keselamatan_baik_ya">Ya</label>

                                            <input type="radio" id="sabuk_keselamatan_baik_tidak" name="sabuk_keselamatan_baik" value="0">
                                            <label for="sabuk_keselamatan_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="sabuk_keselamatan_keterangan" name="sabuk_keselamatan_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Apar</label>
                                        <div>
                                          <input type="radio" id="apar_baik_ya" name="apar_baik" value="1" required checked>
                                            <label for="apar_baik_ya">Ya</label>
                                            <input type="radio" id="apar_baik_tidak" name="apar_baik" value="0">
                                            <label for="apar_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="apar_keterangan" name="apar_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                                </div>

                                <div class="row">
                                     <div class="mb-3">
                                        <label class="form-label">Perlengkapan Kebocoran</label>
                                        <div>
                                            <input type="radio" id="perlengkapan_kebocoran_baik_ya" name="perlengkapan_kebocoran_baik" value="1" required
                                                checked>
                                            <label for="perlengkapan_kebocoran_baik_ya">Ya</label>

                                            <input type="radio" id="perlengkapan_kebocoran_baik_tidak" name="perlengkapan_kebocoran_baik" value="0">
                                            <label for="perlengkapan_kebocoran_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="perlengkapan_kebocoran_keterangan" name="perlengkapan_kebocoran_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Segitiga Pengaman</label>
                                        <div>
                                          <input type="radio" id="segitiga_pengaman_baik_ya" name="segitiga_pengaman_baik" value="1" required checked>
                                            <label for="segitiga_pengaman_baik_ya">Ya</label>
                                            <input type="radio" id="segitiga_pengaman_baik_tidak" name="segitiga_pengaman_baik" value="0">
                                            <label for="segitiga_pengaman_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="segitiga_pengaman_keterangan" name="segitiga_pengaman_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                  <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">Safety Cone</label>
                                        <div>
                                            <input type="radio" id="safety_cone_baik_ya" name="safety_cone_baik" value="1" required
                                                checked>
                                            <label for="safety_cone_baik_ya">Ya</label>

                                            <input type="radio" id="safety_cone_baik_tidak" name="safety_cone_baik" value="0">
                                            <label for="safety_cone_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="safety_cone_keterangan" name="safety_cone_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                 <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Dongkrak dan Kunci</label>
                                        <div>
                                          <input type="radio" id="dongkrak_kunci_baik_ya" name="dongkrak_kunci_baik" value="1" required checked>
                                            <label for="dongkrak_kunci_baik_ya">Ya</label>
                                            <input type="radio" id="dongkrak_kunci_baik_tidak" name="dongkrak_kunci_baik" value="0">
                                            <label for="dongkrak_kunci_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="dongkrak_kunci_keterangan" name="dongkrak_kunci_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>
                            
                           

                            <div class="row">
                                
                                 <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">Ganjal Ban</label>
                                        <div>
                                            <input type="radio" id="ganjal_ban_baik_ya" name="ganjal_ban_baik" value="1" required
                                                checked>
                                            <label for="ganjal_ban_baik_ya">Ya</label>

                                            <input type="radio" id="ganjal_ban_baik_tidak" name="ganjal_ban_baik" value="0">
                                            <label for="ganjal_ban_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="ganjal_ban_keterangan" name="ganjal_ban_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Kotak P3K</label>
                                        <div>
                                          <input type="radio" id="kotak_p3k_baik_ya" name="kotak_p3k_baik" value="1" required checked>
                                            <label for="kotak_p3k_baik_ya">Ya</label>
                                            <input type="radio" id="kotak_p3k_baik_tidak" name="kotak_p3k_baik" value="0">
                                            <label for="kotak_p3k_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="kotak_p3k_keterangan" name="kotak_p3k_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>
                            
                            <div class='row'>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dokumen Pengecekan Rutin</label>
                                        <div>
                                            <input type="radio" id="dokumen_rutin_baik_ya" name="dokumen_rutin_baik" value="1" required
                                                checked>
                                            <label for="dokumen_rutin_baik_ya">Ya</label>

                                            <input type="radio" id="dokumen_rutin_baik_tidak" name="dokumen_rutin_baik" value="0">
                                            <label for="dokumen_rutin_baik_tidak">Tidak</label>
                                        </div>
                                         <input type="text" class="form-control" id="dokumen_rutin_keterangan" name="dokumen_rutin_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                     <div class="mb-3">
                                        <label class="form-label">Dokumen Service Record Terakhir</label>
                                        <div>
                                           <input type="radio" id="dokumen_service_baik_ya" name="dokumen_service_baik" value="1" required checked>
                                            <label for="dokumen_service_baik_ya">Ya</label>

                                            <input type="radio" id="dokumen_service_baik_tidak" name="dokumen_service_baik" value="0">
                                            <label for="dokumen_service_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="dokumen_service_keterangan" name="dokumen_service_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                 </div>

                            </div>
                           

                            <p class="fw-bold">Kondisi Pengemudi</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pengemudi dalam Keadaan Sehat</label>
                                        <div>
                                            <input type="radio" id="pengemudi_sehat_baik_ya" name="pengemudi_sehat_baik"
                                                value="1" required checked>
                                            <label for="pengemudi_sehat_baik_ya">Ya</label>

                                            <input type="radio" id="pengemudi_sehat_baik_tidak"
                                                name="pengemudi_sehat_baik" value="0">
                                            <label for="pengemudi_sehat_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="pengemudi_sehat_keterangan"
                                            name="pengemudi_sehat_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pengemudi Cukup Istirahat</label>
                                        <div>
                                            <input type="radio" id="pengemudi_istirahat_baik_ya"
                                                name="pengemudi_istirahat_baik" value="1" required checked>
                                            <label for="pengemudi_istirahat_baik_ya">Ya</label>

                                            <input type="radio" id="pengemudi_istirahat_baik_tidak"
                                                name="pengemudi_istirahat_baik" value="0">
                                            <label for="pengemudi_istirahat_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="pengemudi_istirahat_keterangan"
                                            name="pengemudi_istirahat_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tidak dalam Kondisi Mabuk</label>
                                        <div>
                                            <input type="radio" id="pengemudi_mabuk_baik_ya" name="pengemudi_mabuk_baik"
                                                value="1" required checked>
                                            <label for="pengemudi_mabuk_baik_ya">Ya</label>

                                            <input type="radio" id="pengemudi_mabuk_baik_tidak"
                                                name="pengemudi_mabuk_baik" value="0">
                                            <label for="pengemudi_mabuk_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="pengemudi_mabuk_keterangan"
                                            name="pengemudi_mabuk_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="mb-3">
                                        <label class="form-label">Tidak dalam Konsumsi Obat yang Menyebabkan
                                            Kantuk</label>
                                        <div>
                                            <input type="radio" id="pengemudi_obat_baik_ya" name="pengemudi_obat_baik"
                                                value="1" required checked>
                                            <label for="pengemudi_obat_baik_ya">Ya</label>

                                            <input type="radio" id="pengemudi_obat_baik_tidak" name="pengemudi_obat_baik"
                                                value="0">
                                            <label for="pengemudi_obat_baik_tidak">Tidak</label>
                                        </div>
                                        <input type="text" class="form-control" id="pengemudi_obat_keterangan"
                                            name="pengemudi_obat_keterangan" placeholder="Keterangan (opsional)">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Inspeksi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection