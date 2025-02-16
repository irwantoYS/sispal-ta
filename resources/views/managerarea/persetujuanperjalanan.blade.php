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
                                        <th>Titik Awal</th>
                                        <th>Tujuan Perjalanan</th>
                                        <th>Jam Pergi</th>
                                        <th>Detail</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>

                                <div class="modal fade" id="modalAlasan" tabindex="-1" aria-labelledby="modalAlasanLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="formTolak" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalAlasanLabel">Alasan Penolakan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea name="alasan" id="alasan" class="form-control" rows="4" placeholder="Masukkan alasan penolakan"
                                                        required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <tbody>
                                    @foreach ($perjalanan as $key => $perjalanan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">Menunggu Validasi</span>
                                            </td>
                                            <td>{{ $perjalanan->user->nama }}</td>
                                            <td>{{ $perjalanan->nama_pegawai }}</td>
                                            <td>{{ $perjalanan->titik_awal }}</td>
                                            <td>{{ $perjalanan->tujuan_perjalanan }}</td>
                                            <td>{{ $perjalanan->jam_pergi }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal"
                                                    data-nama-pengemudi="{{ $perjalanan->user->nama }}"
                                                    data-nama-pegawai="{{ $perjalanan->nama_pegawai }}"
                                                    data-titik-awal="{{ $perjalanan->titik_awal }}"
                                                    data-titik-akhir="{{ $perjalanan->titik_akhir }}"
                                                    data-tujuan="{{ $perjalanan->tujuan_perjalanan }}"
                                                    data-no-kendaraan="{{ $perjalanan->Kendaraan->no_kendaraan ?? '-' }}"
                                                    data-tipe-kendaraan="{{ $perjalanan->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                    data-km-akhir="{{ $perjalanan->km_akhir }}"
                                                    data-bbm-awal="{{ $perjalanan->bbm_awal }}"
                                                    data-bbm-akhir="{{ $perjalanan->bbm_akhir }}"
                                                    data-jam-pergi="{{ $perjalanan->jam_pergi }}"
                                                    data-jam-kembali="{{ $perjalanan->jam_kembali }}">
                                                    Lihat Detail
                                                </button>
                                            </td>
                                            <td>
                                                @if ($perjalanan->status == 'menunggu validasi')
                                                    <div class="d-flex gap-2">
                                                        {{-- Tombol Validasi (SEKARANG HANYA TOMBOL) --}}
                                                        <button type="button" class="btn btn-success btn-sm btn-validasi"
                                                            data-id="{{ $perjalanan->id }}">Validasi</button>

                                                        {{-- Tombol Tolak --}}
                                                        <button type="button" class="btn btn-danger btn-sm btn-tolak"
                                                            data-id="{{ $perjalanan->id }}"
                                                            data-url="{{ route('perjalanan.tolak', $perjalanan->id) }}"
                                                            data-bs-toggle="modal" data-bs-target="#modalAlasan">
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

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Perjalanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            <th>KM Awal</th>
                            <td id="detailKmAwal"></td>
                        </tr>
                        <tr>
                            <th>KM Akhir</th>
                            <td id="detailKmAkhir"></td>
                        </tr>
                        <tr>
                            <th>BBM Awal</th>
                            <td id="detailBbmAwal"></td>
                        </tr>
                        <tr>
                            <th>BBM Akhir</th>
                            <td id="detailBbmAkhir"></td>
                        </tr>
                        <tr>
                            <th>Jam Pergi</th>
                            <td id="detailJamPergi"></td>
                        </tr>
                        <tr>
                            <th>jam Kembali</th>
                            <td id="detailJamKembali"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal Lihat Detail
            const detailButtons = document.querySelectorAll('.detail-button');

            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil data dari atribut data-*
                    document.getElementById('detailNamaPengemudi').textContent = this.getAttribute(
                        'data-nama-pengemudi') || '-';
                    document.getElementById('detailNamaPegawai').textContent = this.getAttribute(
                        'data-nama-pegawai') || '-';
                    document.getElementById('detailTitikAwal').textContent = this.getAttribute(
                        'data-titik-awal') || '-';
                    document.getElementById('detailTitikAkhir').textContent = this.getAttribute(
                        'data-titik-akhir') || '-';
                    document.getElementById('detailTujuan').textContent = this.getAttribute(
                        'data-tujuan') || '-';
                    document.getElementById('detailNoKendaraan').textContent = this.getAttribute(
                        'data-no-kendaraan') || '-';
                    document.getElementById('detailTipeKendaraan').textContent = this.getAttribute(
                        'data-tipe-kendaraan') || '-';
                    // document.getElementById('detailKmAwal').textContent = this.getAttribute(
                    //     'data-km-awal') || '-';
                    document.getElementById('detailKmAkhir').textContent = this.getAttribute(
                        'data-km-akhir') || '-';
                    document.getElementById('detailBbmAwal').textContent = this.getAttribute(
                        'data-bbm-awal') || '-';
                    document.getElementById('detailBbmAkhir').textContent = this.getAttribute(
                        'data-bbm-akhir') || '-';
                    document.getElementById('detailJamPergi').textContent = this.getAttribute(
                        'data-jam-pergi') || '-';
                    document.getElementById('detailJamKembali').textContent = this.getAttribute(
                        'data-jam-kembali') || '-';
                });
            });
        });
    </script>

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
                        const url = "{{ route('perjalanan.validasi', ['id' => ':id']) }}".replace(
                            ':id', id);
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            success: function(response) {
                                // Hapus .then() yang me-reload halaman di sini
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response
                                    .message, // Gunakan pesan dari respons JSON
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
                                    errorMessage =
                                        'Validasi gagal.  Periksa data yang dikirim.';
                                    const errors = xhr.responseJSON.errors;
                                    if (errors) {
                                        let errorMessages = '';
                                        for (const field in errors) {
                                            errorMessages += errors[field].join(
                                                '<br>') + '<br>';
                                        }
                                        errorMessage = errorMessages;
                                    }
                                } else if (xhr.status === 500) {
                                    errorMessage = 'Terjadi kesalahan server internal.';
                                }
                                Swal.fire('Gagal!', errorMessage, 'error');
                            }
                        });
                    }
                });
            });



            // SweetAlert untuk Konfirmasi Penolakan (saat tombol "Tolak" di dalam modal diklik)
            $('#formTolak').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const url = form.getAttribute('action');
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
                                // Error handling yang lebih baik
                                let errorMessage =
                                    'Terjadi kesalahan saat menolak pengajuan.';
                                if (xhr.status === 404) {
                                    errorMessage =
                                        'Route tidak ditemukan. Periksa routes/web.php Anda.';
                                } else if (xhr.status === 422) {
                                    errorMessage =
                                        'Validasi gagal. Periksa data yang dikirim.';
                                    const errors = xhr.responseJSON.errors;
                                    if (errors) {
                                        let errorMessages = '';
                                        for (const field in errors) {
                                            errorMessages += errors[field].join(
                                                '<br>') + '<br>';
                                        }
                                        errorMessage = errorMessages;
                                    }
                                } else if (xhr.status === 500) {
                                    errorMessage = 'Terjadi kesalahan server internal.';
                                }
                                Swal.fire('Gagal!', errorMessage, 'error');
                            }
                        });
                    }
                });
            });

            const tolakButtons = document.querySelectorAll('.btn-tolak');

            tolakButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const perjalananId = this.getAttribute('data-id');
                    const url = this.getAttribute('data-url');
                    const form = document.getElementById('formTolak');
                    form.setAttribute('action', url);
                    const alasanField = document.getElementById('alasan');
                    alasanField.value = '';
                });
            });
        });
    </script>

@endsection
