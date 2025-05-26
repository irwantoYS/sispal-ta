@section('title', 'Persetujuan | Manager Area')
@extends('layouts.sidebarma')
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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="persetujuanTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>status</th>
                                        <th>Nama Pengemudi</th>
                                        <th>Nama Pegawai</th>
                                        <th>Titik akhir</th>
                                        <th>Tujuan Perjalanan</th>
                                        <th style="width: 8%">Foto</th>
                                        <th>Detail</th>
                                        <th style="width: 10%">Action</th>
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
                                            <td>{{ $item->user->nama }}</td>
                                            <td>
                                                @php
                                                    $namaArray = json_decode($item->nama_pegawai);
                                                    if (is_array($namaArray)) {
                                                        echo e(implode(', ', $namaArray));
                                                    } else {
                                                        echo e($item->nama_pegawai);
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
                                                <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal"
                                                    data-nama-pengemudi="{{ $item->user->nama ?? '-' }}"
                                                    data-nama-pegawai="{{ e($item->nama_pegawai ?? '') }}"
                                                    data-titik-awal="{{ $item->titik_awal ?? '-' }}"
                                                    data-titik-akhir="{{ $item->titik_akhir ?? '-' }}"
                                                    data-tujuan="{{ $item->tujuan_perjalanan ?? '-' }}"
                                                    data-no-kendaraan="{{ $item->Kendaraan->no_kendaraan ?? '-' }}"
                                                    data-tipe-kendaraan="{{ $item->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                    data-estimasi-jarak="{{ $item->estimasi_jarak ?? '-' }}"
                                                    data-bbm-awal="{{ $item->bbm_awal ?? '-' }}"
                                                    data-bbm-akhir="{{ $item->bbm_akhir ?? '-' }}"
                                                    data-jam-pergi="{{ $item->jam_pergi ? \Carbon\Carbon::parse($item->jam_pergi)->format('d/m/Y H:i') : '-' }}"
                                                    data-jam-kembali="{{ $item->jam_kembali ? \Carbon\Carbon::parse($item->jam_kembali)->format('d/m/Y H:i') : '-' }}"
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
                                                    Lihat Detail
                                                </button>
                                            </td>
                                            <td>
                                                @if ($item->status == 'menunggu validasi')
                                                    <div class="d-flex gap-2">
                                                        {{-- Tombol Validasi --}}
                                                        <button type="button" class="btn btn-success btn-sm btn-validasi"
                                                            data-id="{{ $item->id }}">Validasi</button>

                                                        {{-- Tombol Tolak --}}
                                                        <button type="button" class="btn btn-danger btn-sm btn-tolak"
                                                            data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#modalAlasan">
                                                            Tolak
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Tidak ada aksi</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail (Tidak Berubah) --}}
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
                                            <span id="detailBbmAwalValue">0/8</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>Jam Pergi</th>
                                <td id="detailJamPergi"></td>
                            </tr>

                            {{-- Tambahkan Baris Status Kendaraan --}}
                            <tr>
                                <th>Status Kendaraan</th>
                                <td id="detailKendaraanStatus"></td>
                            </tr>
                        </table>
                    </div>
                    {{-- Tambahkan Area Detail Inspeksi (Tersembunyi) --}}
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
    {{-- Modal Alasan Penolakan --}}
    <div class="modal fade" id="modalAlasan" tabindex="-1" aria-labelledby="modalAlasanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formTolak" method="POST" action=""> {{-- action dikosongkan dulu --}}
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAlasanLabel">Alasan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea name="alasan" id="alasan" class="form-control" rows="4" placeholder="Masukkan alasan penolakan"
                            required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
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



    {{-- PENTING: Pastikan urutan script benar --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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

            // SweetAlert untuk Konfirmasi Validasi
            $('.btn-validasi').on('click', function() {
                const id = $(this).data('id');
                let url = "{{ route('perjalanan.validasi', ['id' => ':id']) }}".replace(':id', id);
                Swal.fire({
                    title: 'Konfirmasi Validasi',
                    text: "Apakah Anda yakin ingin memvalidasi perjalanan ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Validasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({ //Perbaikan disini
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500
                                }).then(function() { //tambahkan ini
                                    window.location.reload();
                                })

                            },
                            error: function(xhr) {
                                // ... (error handling, tidak berubah) ...
                                let errorMessage = 'Terjadi kesalahan saat validasi.';
                                if (xhr.status === 404) {
                                    errorMessage =
                                        'Route tidak ditemukan.  Periksa routes/web.php Anda.';
                                } else if (xhr.status === 422) {
                                    errorMessage = xhr.responseJSON
                                        .message; // Ambil pesan dari response JSON
                                } else if (xhr.status === 500) {
                                    errorMessage = 'Terjadi kesalahan server internal.';
                                }
                                Swal.fire('Gagal!', errorMessage, 'error');

                            }
                        });
                    }
                });
            });



            //  Penolakan (saat tombol "Tolak" di dalam modal diklik)
            $('#formTolak').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const url = form.getAttribute('action'); // Ambil URL dari form
                const alasan = $('#alasan').val();


                Swal.fire({
                    title: 'Konfirmasi Penolakan',
                    text: "Apakah Anda yakin ingin menolak pengajuan ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            data: $(form).serialize(), //  data form
                            success: function(response) {
                                $('#modalAlasan').modal('hide');
                                Swal.fire(
                                    'Berhasil!',
                                    'Pengajuan berhasil ditolak.',
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                // ... (error handling, tidak berubah) ...
                                let errorMessage =
                                    'Terjadi kesalahan saat menolak pengajuan.';
                                if (xhr.status === 404) {
                                    errorMessage =
                                        'Route tidak ditemukan. Periksa routes/web.php Anda.';
                                } else if (xhr.status === 422) { //Perbaikan disini
                                    errorMessage = xhr.responseJSON.message;
                                    //  const errors = xhr.responseJSON.errors; //ini di comment, karna sudah di handle di controller
                                    // if (errors) {
                                    //     let errorMessages = '';
                                    //     for (const field in errors) {
                                    //         errorMessages += errors[field].join('<br>') + '<br>';
                                    //     }
                                    //     errorMessage = errorMessages;
                                    // }
                                } else if (xhr.status === 500) {
                                    errorMessage = 'Terjadi kesalahan server internal.';
                                }
                                Swal.fire('Gagal!', errorMessage, 'error');
                            }
                        });
                    }
                });
            });

            // Menyiapkan modal tolak (mengisi action form)
            const tolakButtons = document.querySelectorAll('.btn-tolak');

            tolakButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const perjalananId = this.getAttribute('data-id');
                    const url = "{{ route('perjalanan.tolak', ['id' => ':id']) }}".replace(':id',
                        perjalananId);
                    const form = document.getElementById('formTolak');
                    form.setAttribute('action', url);
                    const alasanField = document.getElementById('alasan');
                    alasanField.value = ''; // Kosongkan input alasan
                });
            });
        });

        // Fungsi untuk memformat tampilan status kendaraan
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

        // Event listener untuk tombol detail (disalin dan disesuaikan dari statusperjalanan.blade.php)
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
                document.getElementById('detailTitikAwal').textContent = button.getAttribute('data-titik-awal') ||
                    '-';
                document.getElementById('detailTitikAkhir').textContent = button.getAttribute('data-titik-akhir') ||
                    '-';
                document.getElementById('detailTujuan').textContent = button.getAttribute('data-tujuan') || '-';
                document.getElementById('detailNoKendaraan').textContent = button.getAttribute(
                    'data-no-kendaraan') || '-';
                document.getElementById('detailTipeKendaraan').textContent = button.getAttribute(
                    'data-tipe-kendaraan') || '-';
                document.getElementById('detailEstimasiJarak').textContent = button.getAttribute(
                    'data-estimasi-jarak') || '-';
                document.getElementById('detailJamPergi').textContent = button.getAttribute('data-jam-pergi') ||
                    '-';


                // Handle BBM Awal Progress Bar
                const bbmAwal = button.getAttribute('data-bbm-awal') || 0;
                const bbmAwalPercentage = (bbmAwal / 8) * 100;
                const detailBbmAwalBar = document.getElementById('detailBbmAwalBar');
                const detailBbmAwalValue = document.getElementById('detailBbmAwalValue');

                if (detailBbmAwalBar && detailBbmAwalValue) { // Cek elemen ada
                    detailBbmAwalBar.style.width = bbmAwalPercentage + '%';
                    detailBbmAwalBar.setAttribute('aria-valuenow', bbmAwal);
                    detailBbmAwalValue.textContent = bbmAwal + '/8';

                    if (bbmAwal >= 6) {
                        detailBbmAwalBar.className = 'progress-bar bg-success'; // Ganti class langsung
                    } else if (bbmAwal >= 3) {
                        detailBbmAwalBar.className = 'progress-bar bg-warning';
                    } else {
                        detailBbmAwalBar.className = 'progress-bar bg-danger';
                    }
                }

                // Ambil dan tampilkan status kendaraan
                const kendaraanStatus = button.getAttribute('data-kendaraan-status');
                document.getElementById('detailKendaraanStatus').textContent = formatStatus(kendaraanStatus);

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
                }
            }
        });
    </script>

@endsection

<style>
    /* Style untuk tabel */
    #persetujuanTable {
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
    }
</style>
