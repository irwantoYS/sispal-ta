@section('title', 'Status Perjalanan | Driver')
@extends('layouts.sidebardriver')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Status Perjalanan</h3>
                    <h6 class="op-7 mb-2">Status Perjalanan</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="perjalananTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 8%">Status</th>
                                        <th style="width: 13%">Nama Pegawai</th>
                                        <th style="width: 10%">Titik Akhir</th>
                                        <th style="width: 13%">Tujuan</th>
                                        <th style="width: 8%">Foto</th>
                                        <th style="width: 12%">Alasan</th>
                                        <th style="width: 8%">Update</th>
                                        <th style="width: 5%">Detail</th>
                                        <th style="width: 7%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perjalanan as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if ($item->status == 'menunggu validasi')
                                                    <span class="badge bg-warning text-dark">Menunggu Validasi</span>
                                                @elseif($item->status == 'disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $namaArray = json_decode($item->nama_pegawai);
                                                    if (is_array($namaArray)) {
                                                        echo e(implode(', ', $namaArray));
                                                    } else {
                                                        echo e($item->nama_pegawai); // Tampilkan asli jika bukan array JSON
                                                    }
                                                @endphp
                                            </td>
                                            <td>{{ $item->titik_akhir }}</td>
                                            <td>{{ $item->tujuan_perjalanan }}</td>
                                            <td>
                                                @if ($item->foto_awal)
                                                    <button class="btn btn-info btn-sm foto-link" data-bs-toggle="modal"
                                                        data-bs-target="#fotoModal"
                                                        data-foto="{{ asset('storage/' . $item->foto_awal) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 'ditolak' && $item->alasan)
                                                    <button class="btn btn-danger btn-sm alasan-link" data-bs-toggle="modal"
                                                        data-bs-target="#modalAlasan-{{ $item->id }}"
                                                        data-alasan="{{ $item->alasan }}">
                                                        Lihat Alasan
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 'disetujui' && !$item->bbm_akhir && !$item->jam_kembali && !$item->foto_akhir)
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#updatePerjalananModal-{{ $item->id }}"
                                                        data-id="{{ $item->id }}">
                                                        Update
                                                    </button>
                                                @elseif($item->status == 'ditolak')
                                                    <button class="btn btn-danger btn-sm delete-button"
                                                        data-id="{{ $item->id }}"
                                                        data-nama-pegawai="{{ $item->nama_pegawai }}">
                                                        Hapus
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal"
                                                    data-nama-pengemudi="{{ $item->user->nama ?? '-' }}"
                                                    data-nama-pegawai="{{ e($item->nama_pegawai ?? '') }}"
                                                    data-titik-awal="{{ $item->titik_awal ?? '-' }} "
                                                    data-titik-akhir="{{ $item->titik_akhir ?? '-' }}"
                                                    data-tujuan="{{ $item->tujuan_perjalanan ?? '-' }}"
                                                    data-no-kendaraan="{{ $item->Kendaraan->no_kendaraan ?? '-' }}"
                                                    data-tipe-kendaraan="{{ $item->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                    data-estimasi-jarak="{{ $item->estimasi_jarak ?? '-' }}"
                                                    data-bbm-awal="{{ $item->bbm_awal ?? '-' }}"
                                                    data-jam-pergi="{{ $item->jam_pergi ? \Carbon\Carbon::parse($item->jam_pergi)->format('d/m/Y H:i') : '-' }}"
                                                    data-kendaraan-status="{{ $item->Kendaraan->status ?? '' }}"
                                                    data-inspeksi-body_baik="{{ $item->Kendaraan->latestInspeksi->body_baik ?? '' }}"
                                                    data-inspeksi-ban_baik="{{ $item->Kendaraan->latestInspeksi->ban_baik ?? '' }}"
                                                    data-inspeksi-stir_baik="{{ $item->Kendaraan->latestInspeksi->stir_baik ?? '' }}"
                                                    data-inspeksi-rem_kaki_tangan_baik="{{ $item->Kendaraan->latestInspeksi->rem_kaki_tangan_baik ?? '' }}"
                                                    data-inspeksi-pedal_kopling_gas_rem_baik="{{ $item->Kendaraan->latestInspeksi->pedal_kopling_gas_rem_baik ?? '' }}"
                                                    data-inspeksi-starter_baik="{{ $item->Kendaraan->latestInspeksi->starter_baik ?? '' }}"
                                                    data-inspeksi-oli_mesin_baik="{{ $item->Kendaraan->latestInspeksi->oli_mesin_baik ?? '' }}"
                                                    data-inspeksi-tangki_bb_pompa_baik="{{ $item->Kendaraan->latestInspeksi->tangki_bb_pompa_baik ?? '' }}"
                                                    data-inspeksi-radiator_pompa_fanbelt_baik="{{ $item->Kendaraan->latestInspeksi->radiator_pompa_fanbelt_baik ?? '' }}"
                                                    data-inspeksi-transmisi_baik="{{ $item->Kendaraan->latestInspeksi->transmisi_baik ?? '' }}"
                                                    data-inspeksi-knalpot_baik="{{ $item->Kendaraan->latestInspeksi->knalpot_baik ?? '' }}"
                                                    data-inspeksi-klakson_baik="{{ $item->Kendaraan->latestInspeksi->klakson_baik ?? '' }}"
                                                    data-inspeksi-alarm_mundur_baik="{{ $item->Kendaraan->latestInspeksi->alarm_mundur_baik ?? '' }}"
                                                    data-inspeksi-lampu_depan_baik="{{ $item->Kendaraan->latestInspeksi->lampu_depan_baik ?? '' }}"
                                                    data-inspeksi-lampu_sign_baik="{{ $item->Kendaraan->latestInspeksi->lampu_sign_baik ?? '' }}"
                                                    data-inspeksi-lampu_kabin_pintu_baik="{{ $item->Kendaraan->latestInspeksi->lampu_kabin_pintu_baik ?? '' }}"
                                                    data-inspeksi-lampu_rem_baik="{{ $item->Kendaraan->latestInspeksi->lampu_rem_baik ?? '' }}"
                                                    data-inspeksi-lampu_mundur_baik="{{ $item->Kendaraan->latestInspeksi->lampu_mundur_baik ?? '' }}"
                                                    data-inspeksi-lampu_drl_baik="{{ $item->Kendaraan->latestInspeksi->lampu_drl_baik ?? '' }}"
                                                    data-inspeksi-indikator_kecepatan_baik="{{ $item->Kendaraan->latestInspeksi->indikator_kecepatan_baik ?? '' }}"
                                                    data-inspeksi-indikator_bb_baik="{{ $item->Kendaraan->latestInspeksi->indikator_bb_baik ?? '' }}"
                                                    data-inspeksi-indikator_temperatur_baik="{{ $item->Kendaraan->latestInspeksi->indikator_temperatur_baik ?? '' }}"
                                                    data-inspeksi-lampu_depan_belakang_baik="{{ $item->Kendaraan->latestInspeksi->lampu_depan_belakang_baik ?? '' }}"
                                                    data-inspeksi-lampu_rem2_baik="{{ $item->Kendaraan->latestInspeksi->lampu_rem2_baik ?? '' }}"
                                                    data-inspeksi-baut_roda_baik="{{ $item->Kendaraan->latestInspeksi->baut_roda_baik ?? '' }}"
                                                    data-inspeksi-jendela_baik="{{ $item->Kendaraan->latestInspeksi->jendela_baik ?? '' }}"
                                                    data-inspeksi-wiper_washer_baik="{{ $item->Kendaraan->latestInspeksi->wiper_washer_baik ?? '' }}"
                                                    data-inspeksi-spion_baik="{{ $item->Kendaraan->latestInspeksi->spion_baik ?? '' }}"
                                                    data-inspeksi-kunci_pintu_baik="{{ $item->Kendaraan->latestInspeksi->kunci_pintu_baik ?? '' }}"
                                                    data-inspeksi-kursi_baik="{{ $item->Kendaraan->latestInspeksi->kursi_baik ?? '' }}"
                                                    data-inspeksi-sabuk_keselamatan_baik="{{ $item->Kendaraan->latestInspeksi->sabuk_keselamatan_baik ?? '' }}"
                                                    data-inspeksi-apar_baik="{{ $item->Kendaraan->latestInspeksi->apar_baik ?? '' }}"
                                                    data-inspeksi-perlengkapan_kebocoran_baik="{{ $item->Kendaraan->latestInspeksi->perlengkapan_kebocoran_baik ?? '' }}"
                                                    data-inspeksi-segitiga_pengaman_baik="{{ $item->Kendaraan->latestInspeksi->segitiga_pengaman_baik ?? '' }}"
                                                    data-inspeksi-safety_cone_baik="{{ $item->Kendaraan->latestInspeksi->safety_cone_baik ?? '' }}"
                                                    data-inspeksi-dongkrak_kunci_baik="{{ $item->Kendaraan->latestInspeksi->dongkrak_kunci_baik ?? '' }}"
                                                    data-inspeksi-ganjal_ban_baik="{{ $item->Kendaraan->latestInspeksi->ganjal_ban_baik ?? '' }}"
                                                    data-inspeksi-kotak_p3k_baik="{{ $item->Kendaraan->latestInspeksi->kotak_p3k_baik ?? '' }}"
                                                    data-inspeksi-dokumen_rutin_baik="{{ $item->Kendaraan->latestInspeksi->dokumen_rutin_baik ?? '' }}"
                                                    data-inspeksi-dokumen_service_baik="{{ $item->Kendaraan->latestInspeksi->dokumen_service_baik ?? '' }}">
                                                    Detail
                                                </button>
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-sm ms-auto"
                                                    href="{{ route('statusperjalanan.pdf', ['id' => $item->id]) }}">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="updatePerjalananModal-{{ $item->id }}"
                                            tabindex="-1"
                                            aria-labelledby="updatePerjalananModalLabel-{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('update.perjalanan', ['id' => $item->id]) }}"
                                                        id="updateForm-{{ $item->id }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="form-group form-group-default">
                                                                    <label for="bbm_akhir-{{ $item->id }}">BBM
                                                                        Akhir</label>
                                                                    <div class="progress" style="height: 25px;">
                                                                        <div id="bbm-akhir-bar-{{ $item->id }}"
                                                                            class="progress-bar bg-success"
                                                                            role="progressbar" style="width: 0%;"
                                                                            aria-valuenow="0" aria-valuemin="0"
                                                                            aria-valuemax="8">
                                                                            <span
                                                                                id="bbm-akhir-value-{{ $item->id }}">0</span>
                                                                        </div>
                                                                    </div>
                                                                    <input type="range" class="form-range"
                                                                        id="bbm_akhir-{{ $item->id }}"
                                                                        name="bbm_akhir" min="0" max="8"
                                                                        value="0" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="foto_akhir-{{ $item->id }}"
                                                                    class="form-label">Foto KM & BBM Akhir</label>
                                                                <input type="file" id="foto_akhir-{{ $item->id }}"
                                                                    name="foto_akhir" accept="image/*">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jam_kembali-{{ $item->id }}"
                                                                    class="form-label">Jam Kembali</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    id="jam_kembali-{{ $item->id }}"
                                                                    name="jam_kembali"
                                                                    value="{{ now()->format('Y-m-d\TH:i') }}" required
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modalAlasan-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="modalAlasanLabel-{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="modalAlasanLabel-{{ $item->id }}">Alasan
                                                            Penolakan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p id="alasanContent-{{ $item->id }}" class="text-dark"></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination" class="d-flex justify-content-end"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Perjalanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width:30%">Nama Pengemudi</th>
                                <td id="detailNamaPengemudi"></td>
                            </tr>
                            <tr>
                                <th>Nama Pegawai</th>
                                <td id="detailNamaPegawai"></td>
                            </tr>
                            <tr>
                                <th>Titik Awal</th>
                                <td id="detailTitikAwal"></td>
                            </tr>
                            <tr>
                                <th>Titik Akhir</th>
                                <td id="detailTitikAkhir"></td>
                            </tr>
                            <tr>
                                <th>Tujuan</th>
                                <td id="detailTujuan"></td>
                            </tr>
                            <tr>
                                <th>No Kendaraan</th>
                                <td id="detailNoKendaraan"></td>
                            </tr>
                            <tr>
                                <th>Tipe Kendaraan</th>
                                <td id="detailTipeKendaraan"></td>
                            </tr>
                            <tr>
                                <th>Estimasi Jarak Pergi</th>
                                <td id="detailEstimasiJarak"></td>
                            </tr>
                            <tr>
                                <th>BBM Awal</th>
                                <td>
                                    <div class="progress" style="height: 25px;">
                                        <div id="detailBbmAwalBar" class="progress-bar bg-danger" role="progressbar"
                                            style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="8">
                                            <span id="detailBbmAwalValue">0</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Jam Pergi</th>
                                <td id="detailJamPergi"></td>
                            </tr>
                            <tr>
                                <th>Status Kendaraan</th>
                                <td id="detailKendaraanStatus"></td>
                            </tr>
                        </table>
                    </div>
                    <div id="detailInspeksiSection" style="display: none; margin-top: 15px;">
                        <h5>Kendaraan yang Digunakan Perlu Perbaikan:</h5>
                        <ul id="detailInspeksiItems" class="list-group">
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModalLabel">Foto KM & BBM Awal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="fotoPreview" src="" alt="Foto Perjalanan" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Event delegation untuk semua event
            document.addEventListener('click', function(event) {

                // --- Handle klik tombol foto ---
                if (event.target.matches('.foto-link')) {
                    const fotoSrc = event.target.getAttribute('data-foto');
                    document.getElementById('fotoPreview').setAttribute('src', fotoSrc);
                }

                // --- Handle klik tombol alasan ---
                if (event.target.matches('.alasan-link')) {
                    event.preventDefault();
                    const alasan = event.target.getAttribute('data-alasan');
                    const targetModalId = event.target.getAttribute('data-bs-target');
                    const modalContent = document.querySelector(targetModalId + ' .modal-body p');
                    modalContent.textContent = alasan;
                }

                // --- Handle klik tombol detail --- (Modifikasi)
                if (event.target.matches('.detail-button')) {
                    const button = event.target;
                    document.getElementById('detailNamaPengemudi').textContent = button.getAttribute(
                        'data-nama-pengemudi') || '-';

                    // Format Nama Pegawai dari data attribute
                    const namaPegawaiDataEncoded = button.getAttribute('data-nama-pegawai');
                    let namaPegawaiDisplay = '-';
                    if (namaPegawaiDataEncoded) {
                        const textarea = document.createElement('textarea');
                        textarea.innerHTML = namaPegawaiDataEncoded;
                        const namaPegawaiDataDecoded = textarea.value;
                        try {
                            const namaArray = JSON.parse(namaPegawaiDataDecoded);
                            if (Array.isArray(namaArray)) {
                                namaPegawaiDisplay = namaArray.join(', ');
                            } else {
                                namaPegawaiDisplay = namaPegawaiDataDecoded;
                            }
                        } catch (e) {
                            namaPegawaiDisplay = namaPegawaiDataDecoded;
                        }
                    }
                    document.getElementById('detailNamaPegawai').textContent = namaPegawaiDisplay;
                    // --- End Format Nama Pegawai ---
                    document.getElementById('detailTitikAwal').textContent = button.getAttribute(
                        'data-titik-awal') || '-';
                    document.getElementById('detailTitikAkhir').textContent = button.getAttribute(
                        'data-titik-akhir') || '-';
                    document.getElementById('detailTujuan').textContent = button.getAttribute(
                        'data-tujuan') || '-';
                    document.getElementById('detailNoKendaraan').textContent = button.getAttribute(
                        'data-no-kendaraan') || '-';
                    document.getElementById('detailTipeKendaraan').textContent = button.getAttribute(
                        'data-tipe-kendaraan') || '-';
                    document.getElementById('detailEstimasiJarak').textContent = button.getAttribute(
                        'data-estimasi-jarak') || '-';
                    document.getElementById('detailJamPergi').textContent = button.getAttribute(
                        'data-jam-pergi') || '-';

                    // Ambil dan tampilkan status kendaraan
                    const kendaraanStatus = button.getAttribute('data-kendaraan-status');
                    document.getElementById('detailKendaraanStatus').textContent = formatStatus(
                        kendaraanStatus); // Gunakan fungsi format

                    // Ambil elemen-elemen inspeksi
                    const detailInspeksiSection = document.getElementById('detailInspeksiSection');
                    const detailInspeksiItemsList = document.getElementById('detailInspeksiItems');

                    // Bersihkan daftar item inspeksi sebelumnya
                    detailInspeksiItemsList.innerHTML = '';

                    // Definisikan item inspeksi yang akan diperiksa (Label => Atribut Data)
                    const inspectionChecks = {
                        'Body': 'data-inspeksi-body_baik',
                        'Ban': 'data-inspeksi-ban_baik',
                        'Stir': 'data-inspeksi-stir_baik',
                        'Rem Kaki & Tangan': 'data-inspeksi-rem_kaki_tangan_baik',
                        'Pedal Kopling/Gas/Rem': 'data-inspeksi-pedal_kopling_gas_rem_baik',
                        'Starter': 'data-inspeksi-starter_baik',
                        'Oli Mesin': 'data-inspeksi-oli_mesin_baik',
                        'Tangki BBM & Pompa': 'data-inspeksi-tangki_bb_pompa_baik',
                        'Radiator/Pompa/Fanbelt': 'data-inspeksi-radiator_pompa_fanbelt_baik',
                        'Transmisi': 'data-inspeksi-transmisi_baik',
                        'Knalpot': 'data-inspeksi-knalpot_baik',
                        'Klakson': 'data-inspeksi-klakson_baik',
                        'Alarm Mundur': 'data-inspeksi-alarm_mundur_baik',
                        'Lampu Depan': 'data-inspeksi-lampu_depan_baik',
                        'Lampu Sign': 'data-inspeksi-lampu_sign_baik',
                        'Lampu Kabin/Pintu': 'data-inspeksi-lampu_kabin_pintu_baik',
                        'Lampu Rem': 'data-inspeksi-lampu_rem_baik',
                        'Lampu Mundur': 'data-inspeksi-lampu_mundur_baik',
                        'Lampu DRL': 'data-inspeksi-lampu_drl_baik',
                        'Indikator Kecepatan': 'data-inspeksi-indikator_kecepatan_baik',
                        'Indikator BBM': 'data-inspeksi-indikator_bb_baik',
                        'Indikator Temperatur': 'data-inspeksi-indikator_temperatur_baik',
                        'Lampu Depan/Belakang': 'data-inspeksi-lampu_depan_belakang_baik',
                        'Lampu Rem (Tambahan)': 'data-inspeksi-lampu_rem2_baik',
                        'Baut Roda': 'data-inspeksi-baut_roda_baik',
                        'Jendela': 'data-inspeksi-jendela_baik',
                        'Wiper & Washer': 'data-inspeksi-wiper_washer_baik',
                        'Spion': 'data-inspeksi-spion_baik',
                        'Kunci Pintu': 'data-inspeksi-kunci_pintu_baik',
                        'Kursi': 'data-inspeksi-kursi_baik',
                        'Sabuk Keselamatan': 'data-inspeksi-sabuk_keselamatan_baik',
                        'APAR': 'data-inspeksi-apar_baik',
                        'Perlengkapan Kebocoran': 'data-inspeksi-perlengkapan_kebocoran_baik',
                        'Segitiga Pengaman': 'data-inspeksi-segitiga_pengaman_baik',
                        'Safety Cone': 'data-inspeksi-safety_cone_baik',
                        'Dongkrak & Kunci': 'data-inspeksi-dongkrak_kunci_baik',
                        'Ganjal Ban': 'data-inspeksi-ganjal_ban_baik',
                        'Kotak P3K': 'data-inspeksi-kotak_p3k_baik',
                        'Dokumen Rutin': 'data-inspeksi-dokumen_rutin_baik',
                        'Dokumen Service': 'data-inspeksi-dokumen_service_baik',
                    };

                    let hasProblem = false; // Flag untuk menandai jika ada item '0'
                    for (const [itemName, attributeName] of Object.entries(inspectionChecks)) {
                        const itemStatus = button.getAttribute(attributeName);
                        // Periksa apakah status item adalah '0' (string nol)
                        if (itemStatus === '0') {
                            hasProblem = true; // Set flag jika ditemukan masalah
                            const listItem = document.createElement('li');
                            listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between',
                                'align-items-center');
                            listItem.innerHTML = `
                                ${itemName}
                                <span class="badge bg-danger rounded-pill">Tidak Baik</span>
                            `;
                            detailInspeksiItemsList.appendChild(listItem); // Tambahkan item ke list
                        }
                    }

                    // Tampilkan atau sembunyikan section berdasarkan flag hasProblem
                    if (hasProblem) {
                        detailInspeksiSection.style.display = 'block';
                    } else {
                        detailInspeksiSection.style.display = 'none';
                        // Opsional: jika ingin menampilkan pesan "Tidak ada..." saat tidak ada masalah
                        /* 
                        detailInspeksiSection.style.display = 'block'; // Tetap tampilkan section
                        const listItem = document.createElement('li');
                        listItem.classList.add('list-group-item', 'text-muted');
                        listItem.textContent = 'Semua item inspeksi dalam kondisi baik.';
                        detailInspeksiItemsList.appendChild(listItem);
                        */
                    }

                    // ... (kode untuk BBM awal tetap sama) ...
                    const bbmAwal = button.getAttribute('data-bbm-awal') || 0;
                    const bbmAwalPercentage = (bbmAwal / 8) * 100;
                    const detailBbmAwalBar = document.getElementById('detailBbmAwalBar');
                    const detailBbmAwalValue = document.getElementById('detailBbmAwalValue');

                    detailBbmAwalBar.style.width = bbmAwalPercentage + '%';
                    detailBbmAwalBar.setAttribute('aria-valuenow', bbmAwal);
                    detailBbmAwalValue.textContent = bbmAwal + '/8';

                    // ... (kode warna BBM awal tetap sama) ...
                    if (bbmAwal >= 6) {
                        detailBbmAwalBar.classList.remove('bg-warning', 'bg-danger');
                        detailBbmAwalBar.classList.add('bg-success');
                    } else if (bbmAwal >= 3) {
                        detailBbmAwalBar.classList.remove('bg-success', 'bg-danger');
                        detailBbmAwalBar.classList.add('bg-warning');
                    } else {
                        detailBbmAwalBar.classList.remove('bg-success', 'bg-warning');
                        detailBbmAwalBar.classList.add('bg-danger');
                    }
                }

                // --- Handle klik tombol delete (SweetAlert) ---
                if (event.target.matches('.delete-button')) {
                    const perjalananId = event.target.getAttribute('data-id');
                    const namaPegawai = event.target.getAttribute('data-nama-pegawai');

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: `Anda akan menghapus laporan perjalanan ${namaPegawai}!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.action = `/perjalanan/delete/${perjalananId}`;
                            form.method = 'POST';
                            form.style.display = 'none';

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = "{{ csrf_token() }}";
                            form.appendChild(csrfToken);

                            const methodField = document.createElement('input');
                            methodField.type = 'hidden';
                            methodField.name = '_method';
                            methodField.value = 'DELETE';
                            form.appendChild(methodField);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });

            // --- Handle input range BBM Akhir (di luar event click) ---
            @foreach ($perjalanan as $item)
                const bbmAkhirInput{{ $item->id }} = document.getElementById('bbm_akhir-{{ $item->id }}');
                const bbmAkhirBar{{ $item->id }} = document.getElementById(
                    'bbm-akhir-bar-{{ $item->id }}');
                const bbmAkhirValue{{ $item->id }} = document.getElementById(
                    'bbm-akhir-value-{{ $item->id }}');

                if (bbmAkhirInput{{ $item->id }}) {
                    bbmAkhirInput{{ $item->id }}.addEventListener('input', function() {
                        const value = this.value;
                        const percentage = (value / 8) * 100;

                        bbmAkhirBar{{ $item->id }}.style.width = percentage + '%';
                        bbmAkhirBar{{ $item->id }}.setAttribute('aria-valuenow', value);
                        bbmAkhirValue{{ $item->id }}.textContent = value + '/8';

                        if (value >= 6) {
                            bbmAkhirBar{{ $item->id }}.classList.remove('bg-warning', 'bg-danger');
                            bbmAkhirBar{{ $item->id }}.classList.add('bg-success');
                        } else if (value >= 3) {
                            bbmAkhirBar{{ $item->id }}.classList.remove('bg-success', 'bg-danger');
                            bbmAkhirBar{{ $item->id }}.classList.add('bg-warning');
                        } else {
                            bbmAkhirBar{{ $item->id }}.classList.remove('bg-success', 'bg-warning');
                            bbmAkhirBar{{ $item->id }}.classList.add('bg-danger');
                        }
                    });
                }
            @endforeach
        });

        // Fungsi untuk memformat tampilan status
        function formatStatus(status) {
            if (!status) return '-';
            switch (status.toLowerCase()) {
                case 'ready':
                    return 'Ready';
                case 'in_use':
                    return 'Sedang Digunakan';
                case 'perlu_perbaikan':
                    return 'Perlu Perbaikan';
                default:
                    return status.charAt(0).toUpperCase() + status.slice(1).replace(/_/g, ' ');
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let table = $('#perjalananTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "lengthChange": true,
                "responsive": true,
                "fixedHeader": true,
                "language": {
                    "search": "Cari:", // Ubah label search
                    "lengthMenu": "Show _MENU_ Entries", // Ubah label show entries
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", // Ubah info
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data", // Ubah info empty
                    "infoFiltered": "(disaring dari _MAX_ total data)", // Ubah info filtered
                    "zeroRecords": "Tidak ada data yang ditemukan", // Ubah zero records
                    "paginate": {
                        "previous": "&laquo;",
                        "next": "&raquo;"
                    }
                },
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "columnDefs": [{
                        "width": "5%",
                        "targets": 0
                    }, // No
                    {
                        "width": "8%",
                        "targets": 1
                    }, // Status
                    {
                        "width": "13%",
                        "targets": 2
                    }, // Nama Pegawai
                    {
                        "width": "10%",
                        "targets": 3
                    }, // Titik Akhir
                    {
                        "width": "13%",
                        "targets": 4
                    }, // Tujuan
                    {
                        "width": "8%",
                        "targets": 5,
                        "orderable": false
                    }, // Foto (non-sortable)
                    {
                        "width": "12%",
                        "targets": 6
                    }, // Alasan
                    {
                        "width": "8%",
                        "targets": 7,
                        "orderable": false
                    }, // Update (non-sortable)
                    {
                        "width": "5%",
                        "targets": 8,
                        "orderable": false
                    }, // Detail (non-sortable)
                    {
                        "width": "7%",
                        "targets": 9,
                        "orderable": false
                    } // Action (non-sortable)
                ]
            });

            // Pindahkan elemen show entries ke dalam #tableFilter
            $('#tableFilter').append($('.dataTables_length'));

            // Pindahkan elemen search ke dalam #tableSearch
            $('#tableSearch').append($('.dataTables_filter'));

            // Pindahkan elemen pagination ke dalam #pagination
            $('#pagination').append($('.dataTables_paginate'));

            // Tambahkan class form-control ke dalam input search
            $('#tableSearch input').addClass('form-control');
            // Tambahkan class form-select ke dalam select length
            $('#tableFilter select').addClass('form-select');
        });
    </script>

    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>


@endsection

<style>
    /* Style untuk tabel */
    #perjalananTable {
        font-size: 13px;
        /* Ukuran font sedikit lebih kecil */
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0.5em;
        display: inline-block;
        width: auto;
    }

    /* Style untuk kontainer tabel */
    .table-responsive {
        overflow-x: auto;
        /* Aktifkan scrolling horizontal jika perlu */
        -webkit-overflow-scrolling: touch;
        /* Untuk smooth scrolling di iOS */
        width: 100%;
        /* Lebar tabel 100% dari card */
    }
</style>
