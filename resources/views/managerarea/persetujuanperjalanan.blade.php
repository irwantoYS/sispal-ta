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
                                            <td>{{ $item->nama_pegawai }}</td>
                                            <td>{{ $item->titik_awal }}</td>
                                            <td>{{ $item->tujuan_perjalanan }}</td>
                                            <td>{{ $item->jam_pergi }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal"
                                                    data-nama-pengemudi="{{ $item->user->nama }}"
                                                    data-nama-pegawai="{{ $item->nama_pegawai }}"
                                                    data-titik-awal="{{ $item->titik_awal }}"
                                                    data-titik-akhir="{{ $item->titik_akhir }}"
                                                    data-tujuan="{{ $item->tujuan_perjalanan }}"
                                                    data-no-kendaraan="{{ $item->Kendaraan->no_kendaraan ?? '-' }}"
                                                    data-tipe-kendaraan="{{ $item->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                    data-km-akhir="{{ $item->km_akhir }}"
                                                    data-bbm-awal="{{ $item->bbm_awal }}"
                                                    data-bbm-akhir="{{ $item->bbm_akhir }}"
                                                    data-jam-pergi="{{ $item->jam_pergi }}"
                                                    data-jam-kembali="{{ $item->jam_kembali }}">
                                                    Lihat Detail
                                                </button>
                                            </td>
                                             <td>
                                               @if ($item->status == 'menunggu validasi')
                                                <div class="d-flex gap-2">
                                                 {{-- Tombol Validasi --}}
                                                    <button type="button" class="btn btn-success btn-sm btn-validasi" data-id="{{ $item->id }}">Validasi</button>

                                                    {{-- Tombol Tolak --}}
                                                   <button type="button" class="btn btn-danger btn-sm btn-tolak" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#modalAlasan">
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
    {{-- Modal Alasan Penolakan --}}
    <div class="modal fade" id="modalAlasan" tabindex="-1" aria-labelledby="modalAlasanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formTolak" method="POST" action=""> {{-- action dikosongkan dulu --}}
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
                                      errorMessage = 'Route tidak ditemukan.  Periksa routes/web.php Anda.';
                                 } else if (xhr.status === 422) {
                                       errorMessage = xhr.responseJSON.message; // Ambil pesan dari response JSON
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
                                  let errorMessage = 'Terjadi kesalahan saat menolak pengajuan.';
                                   if (xhr.status === 404) {
                                    errorMessage = 'Route tidak ditemukan. Periksa routes/web.php Anda.';
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
                    const url = "{{ route('perjalanan.tolak', ['id' => ':id']) }}".replace(':id', perjalananId);
                    const form = document.getElementById('formTolak');
                    form.setAttribute('action', url);
                    const alasanField = document.getElementById('alasan');
                    alasanField.value = ''; // Kosongkan input alasan
                });
            });
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