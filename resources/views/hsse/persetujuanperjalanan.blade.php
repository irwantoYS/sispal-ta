@section('title', 'Persetujuan Perjalanan | HSSE')
@extends('layouts.sidebarhsse')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Persetujuan Perjalanan</h3>
                    <h6 class="op-7 mb-2">Persetujuan Perjalanan</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="persetujuanTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>status</th>
                                        <th>Nama Pengemudi</th>
                                        <th>Nama Pengguna</th>
                                        <th>Titik Akhir</th>
                                        <th>Tujuan Perjalanan</th>
                                        <th>Jam Pergi</th>
                                        <th style="width: 8%">Foto</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($perjalanan as $key => $perjalanan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">Menunggu Validasi</span>
                                            </td>
                                            <td>{{ $perjalanan->user->nama }}</td>
                                            <td>
                                                @php
                                                    $namaArray = json_decode($perjalanan->nama_pegawai);
                                                    if (is_array($namaArray)) {
                                                        echo e(implode(', ', $namaArray));
                                                    } else {
                                                        echo e($perjalanan->nama_pegawai);
                                                    }
                                                @endphp
                                            </td>
                                            <td>{{ $perjalanan->titik_akhir }}</td>
                                            <td>{{ $perjalanan->tujuan_perjalanan }}</td>
                                            <td>{{ $perjalanan->jam_pergi }}</td>
                                            <td>
                                                @if ($perjalanan->foto_awal)
                                                    <button class="btn btn-info btn-sm foto-link" data-bs-toggle="modal"
                                                        data-bs-target="#fotoModal"
                                                        data-foto="{{ asset('storage/' . $perjalanan->foto_awal) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal"
                                                    data-nama-pengemudi="{{ $perjalanan->user->nama ?? '-' }}"
                                                    data-nama-pegawai="{{ e($perjalanan->nama_pegawai ?? '') }}"
                                                    data-titik-awal="{{ $perjalanan->titik_awal ?? '-' }}"
                                                    data-titik-akhir="{{ $perjalanan->titik_akhir ?? '-' }}"
                                                    data-tujuan="{{ $perjalanan->tujuan_perjalanan ?? '-' }}"
                                                    data-no-kendaraan="{{ $perjalanan->Kendaraan->no_kendaraan ?? '-' }}"
                                                    data-tipe-kendaraan="{{ $perjalanan->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                    data-estimasi-jarak="{{ $perjalanan->estimasi_jarak ?? '-' }}"
                                                    data-bbm-awal="{{ $perjalanan->bbm_awal ?? '-' }}"
                                                    data-jam-pergi="{{ $perjalanan->jam_pergi ? \Carbon\Carbon::parse($perjalanan->jam_pergi)->format('d/m/Y H:i') : '-' }}"
                                                    data-kendaraan-status="{{ $perjalanan->Kendaraan->status ?? '' }}"
                                                    data-inspeksi-body_baik="{{ $perjalanan->Kendaraan->latestInspeksi->body_baik ?? '' }}"
                                                    data-inspeksi-ban_baik="{{ $perjalanan->Kendaraan->latestInspeksi->ban_baik ?? '' }}"
                                                    data-inspeksi-stir_baik="{{ $perjalanan->Kendaraan->latestInspeksi->stir_baik ?? '' }}"
                                                    data-inspeksi-rem_kaki_tangan_baik="{{ $perjalanan->Kendaraan->latestInspeksi->rem_kaki_tangan_baik ?? '' }}"
                                                    data-inspeksi-pedal_kopling_gas_rem_baik="{{ $perjalanan->Kendaraan->latestInspeksi->pedal_kopling_gas_rem_baik ?? '' }}"
                                                    data-inspeksi-starter_baik="{{ $perjalanan->Kendaraan->latestInspeksi->starter_baik ?? '' }}"
                                                    data-inspeksi-oli_mesin_baik="{{ $perjalanan->Kendaraan->latestInspeksi->oli_mesin_baik ?? '' }}"
                                                    data-inspeksi-tangki_bb_pompa_baik="{{ $perjalanan->Kendaraan->latestInspeksi->tangki_bb_pompa_baik ?? '' }}"
                                                    data-inspeksi-radiator_pompa_fanbelt_baik="{{ $perjalanan->Kendaraan->latestInspeksi->radiator_pompa_fanbelt_baik ?? '' }}"
                                                    data-inspeksi-transmisi_baik="{{ $perjalanan->Kendaraan->latestInspeksi->transmisi_baik ?? '' }}"
                                                    data-inspeksi-knalpot_baik="{{ $perjalanan->Kendaraan->latestInspeksi->knalpot_baik ?? '' }}"
                                                    data-inspeksi-klakson_baik="{{ $perjalanan->Kendaraan->latestInspeksi->klakson_baik ?? '' }}"
                                                    data-inspeksi-alarm_mundur_baik="{{ $perjalanan->Kendaraan->latestInspeksi->alarm_mundur_baik ?? '' }}"
                                                    data-inspeksi-lampu_depan_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_depan_baik ?? '' }}"
                                                    data-inspeksi-lampu_sign_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_sign_baik ?? '' }}"
                                                    data-inspeksi-lampu_kabin_pintu_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_kabin_pintu_baik ?? '' }}"
                                                    data-inspeksi-lampu_rem_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_rem_baik ?? '' }}"
                                                    data-inspeksi-lampu_mundur_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_mundur_baik ?? '' }}"
                                                    data-inspeksi-lampu_drl_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_drl_baik ?? '' }}"
                                                    data-inspeksi-indikator_kecepatan_baik="{{ $perjalanan->Kendaraan->latestInspeksi->indikator_kecepatan_baik ?? '' }}"
                                                    data-inspeksi-indikator_bb_baik="{{ $perjalanan->Kendaraan->latestInspeksi->indikator_bb_baik ?? '' }}"
                                                    data-inspeksi-indikator_temperatur_baik="{{ $perjalanan->Kendaraan->latestInspeksi->indikator_temperatur_baik ?? '' }}"
                                                    data-inspeksi-lampu_depan_belakang_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_depan_belakang_baik ?? '' }}"
                                                    data-inspeksi-lampu_rem2_baik="{{ $perjalanan->Kendaraan->latestInspeksi->lampu_rem2_baik ?? '' }}"
                                                    data-inspeksi-baut_roda_baik="{{ $perjalanan->Kendaraan->latestInspeksi->baut_roda_baik ?? '' }}"
                                                    data-inspeksi-jendela_baik="{{ $perjalanan->Kendaraan->latestInspeksi->jendela_baik ?? '' }}"
                                                    data-inspeksi-wiper_washer_baik="{{ $perjalanan->Kendaraan->latestInspeksi->wiper_washer_baik ?? '' }}"
                                                    data-inspeksi-spion_baik="{{ $perjalanan->Kendaraan->latestInspeksi->spion_baik ?? '' }}"
                                                    data-inspeksi-kunci_pintu_baik="{{ $perjalanan->Kendaraan->latestInspeksi->kunci_pintu_baik ?? '' }}"
                                                    data-inspeksi-kursi_baik="{{ $perjalanan->Kendaraan->latestInspeksi->kursi_baik ?? '' }}"
                                                    data-inspeksi-sabuk_keselamatan_baik="{{ $perjalanan->Kendaraan->latestInspeksi->sabuk_keselamatan_baik ?? '' }}"
                                                    data-inspeksi-apar_baik="{{ $perjalanan->Kendaraan->latestInspeksi->apar_baik ?? '' }}"
                                                    data-inspeksi-perlengkapan_kebocoran_baik="{{ $perjalanan->Kendaraan->latestInspeksi->perlengkapan_kebocoran_baik ?? '' }}"
                                                    data-inspeksi-segitiga_pengaman_baik="{{ $perjalanan->Kendaraan->latestInspeksi->segitiga_pengaman_baik ?? '' }}"
                                                    data-inspeksi-safety_cone_baik="{{ $perjalanan->Kendaraan->latestInspeksi->safety_cone_baik ?? '' }}"
                                                    data-inspeksi-dongkrak_kunci_baik="{{ $perjalanan->Kendaraan->latestInspeksi->dongkrak_kunci_baik ?? '' }}"
                                                    data-inspeksi-ganjal_ban_baik="{{ $perjalanan->Kendaraan->latestInspeksi->ganjal_ban_baik ?? '' }}"
                                                    data-inspeksi-kotak_p3k_baik="{{ $perjalanan->Kendaraan->latestInspeksi->kotak_p3k_baik ?? '' }}"
                                                    data-inspeksi-dokumen_rutin_baik="{{ $perjalanan->Kendaraan->latestInspeksi->dokumen_rutin_baik ?? '' }}"
                                                    data-inspeksi-dokumen_service_baik="{{ $perjalanan->Kendaraan->latestInspeksi->dokumen_service_baik ?? '' }}">
                                                    Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Tangkap semua tombol dengan class 'btn-tolak'
                                            const tolakButtons = document.querySelectorAll('.btn-tolak');

                                            tolakButtons.forEach(button => {
                                                button.addEventListener('click', function() {
                                                    // Ambil data dari atribut tombol
                                                    const perjalananId = this.getAttribute('data-id');
                                                    const url = this.getAttribute('data-url');

                                                    // Set action URL form modal
                                                    const form = document.getElementById('formTolak');
                                                    form.setAttribute('action', url);

                                                    // Kosongkan alasan setiap kali modal dibuka
                                                    const alasanField = document.getElementById('alasan');
                                                    alasanField.value = '';
                                                });
                                            });
                                        });
                                    </script>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Menampilkan Detail -->
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
                                <th>Nama Pengemudi</th>
                                <td id="detailNamaPengemudi"></td>
                            </tr>
                            <tr>
                                <th>Nama Pengguna</th>
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
                                <th>Jam Pergi</th>
                                <td id="detailJamPergi"></td>
                            </tr>
                            <tr>
                                <th>Status Kendaraan</th>
                                <td id="detailKendaraanStatus"></td>
                            </tr>
                            <tr>
                                <th>BBM Awal</th>
                                <td>
                                    <div class="progress" style="height: 25px;">
                                        <div id="detailBbmAwalBar" class="progress-bar bg-danger" role="progressbar"
                                            style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="8">
                                            <span id="detailBbmAwalValue">0/8</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="detailInspeksiSection" style="display: none; margin-top: 15px;">
                        <h5>Kendaraan yang Digunakan Perlu Perbaikan:</h5>
                        <ul id="detailInspeksiItems" class="list-group">
                            {{-- Item akan ditambahkan oleh JavaScript --}}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    {{-- Script SweetAlert tidak diperlukan lagi untuk HSSE --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    {{-- Gabungkan semua script di sini --}}
    <script>
        // Fungsi untuk memformat tampilan status kendaraan (harus di dalam scope yang benar)
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

        document.addEventListener('DOMContentLoaded', function() {

            // 1. Inisialisasi DataTable (menggunakan jQuery)
            $(document).ready(function() {
                $('#persetujuanTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "lengthChange": true,
                    "responsive": true,
                    "language": {
                        "paginate": {
                            "previous": "&laquo;",
                            "next": "&raquo;"
                        }
                    }
                });
            }); // Akhir dari $(document).ready untuk DataTable

            // 2. Event listener untuk tombol detail (Vanilla JS)
            document.addEventListener('click', function(event) {

                // --- Handle klik tombol foto ---
                if (event.target.matches('.foto-link')) {
                    const fotoSrc = event.target.getAttribute('data-foto');
                    document.getElementById('fotoPreview').setAttribute('src', fotoSrc);
                }


                if (event.target.matches('.detail-button')) {
                    const button = event.target;
                    // Isi data modal standar
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

                    // Handle BBM Awal Progress Bar
                    const bbmAwal = button.getAttribute('data-bbm-awal') || 0;
                    const bbmAwalPercentage = (bbmAwal / 8) * 100;
                    const detailBbmAwalBar = document.getElementById('detailBbmAwalBar');
                    const detailBbmAwalValue = document.getElementById('detailBbmAwalValue');

                    if (detailBbmAwalBar && detailBbmAwalValue) {
                        detailBbmAwalBar.style.width = bbmAwalPercentage + '%';
                        detailBbmAwalBar.setAttribute('aria-valuenow', bbmAwal);
                        detailBbmAwalValue.textContent = bbmAwal + '/8';

                        if (bbmAwal >= 6) {
                            detailBbmAwalBar.className = 'progress-bar bg-success';
                        } else if (bbmAwal >= 3) {
                            detailBbmAwalBar.className = 'progress-bar bg-warning';
                        } else {
                            detailBbmAwalBar.className = 'progress-bar bg-danger';
                        }
                    }

                    // Ambil dan tampilkan status kendaraan
                    const kendaraanStatus = button.getAttribute('data-kendaraan-status');
                    document.getElementById('detailKendaraanStatus').textContent = formatStatus(
                        kendaraanStatus);

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
                        if (itemStatus === '0') {
                            hasProblem = true;
                            const listItem = document.createElement('li');
                            listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between',
                                'align-items-center');
                            listItem.innerHTML = `
                                ${itemName}
                                <span class="badge bg-danger rounded-pill">Tidak Baik</span>
                            `;
                            detailInspeksiItemsList.appendChild(listItem);
                        }
                    }

                    // Tampilkan atau sembunyikan section berdasarkan flag hasProblem
                    if (hasProblem) {
                        detailInspeksiSection.style.display = 'block';
                    } else {
                        detailInspeksiSection.style.display = 'none';
                    }
                }
            }); // Akhir dari event listener click document

        }); // Akhir dari DOMContentLoaded
    </script>

@endsection
