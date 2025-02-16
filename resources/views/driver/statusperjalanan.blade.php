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
                                            <td>{{ $item->nama_pegawai }}</td>
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
                                                    data-nama-pengemudi="{{ $item->user->nama }}"
                                                    data-nama-pegawai="{{ $item->nama_pegawai }}"
                                                    data-titik-awal="{{ $item->titik_awal }} "
                                                    data-titik-akhir="{{ $item->titik_akhir }}"
                                                    data-tujuan="{{ $item->tujuan_perjalanan }}"
                                                    data-no-kendaraan="{{ $item->Kendaraan->no_kendaraan ?? '-' }}"
                                                    data-tipe-kendaraan="{{ $item->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                    data-estimasi-jarak="{{ $item->estimasi_jarak }}"
                                                    data-bbm-awal="{{ $item->bbm_awal }}"
                                                    data-jam-pergi="{{ $item->jam_pergi }}">
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
                                            tabindex="-1" aria-labelledby="updatePerjalananModalLabel-{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('update.perjalanan', ['id' => $item->id]) }}"
                                                        id="updateForm-{{ $item->id }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            {{-- <div class="mb-3">
                                                                <label for="km_akhir-{{ $item->id }}"
                                                                    class="form-label">KM Akhir</label>
                                                                <input type="number" class="form-control"
                                                                    id="km_akhir-{{ $item->id }}" name="km_akhir"
                                                                    required>
                                                            </div> --}}
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
                                                                        id="bbm_akhir-{{ $item->id }}" name="bbm_akhir"
                                                                        min="0" max="8" value="0"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jam_kembali-{{ $item->id }}"
                                                                    class="form-label">Jam Kembali</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    id="jam_kembali-{{ $item->id }}"
                                                                    name="jam_kembali" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="foto_akhir-{{ $item->id }}"
                                                                    class="form-label">Foto KM & BBM Akhir</label>
                                                                <input type="file" id="foto_akhir-{{ $item->id }}"
                                                                    name="foto_akhir" accept="image/*">
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
                    </table>
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
            // Ambil semua link dengan class 'foto-link'
            const fotoLinks = document.querySelectorAll('.foto-link');

            fotoLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const fotoSrc = this.getAttribute('data-foto');
                    document.getElementById('fotoPreview').setAttribute('src', fotoSrc);
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen dengan class 'alasan-link'
            const alasanLinks = document.querySelectorAll('.alasan-link');

            alasanLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const alasan = this.getAttribute('data-alasan');
                    const targetModalId = this.getAttribute(
                        'data-bs-target'); // Ambil ID modal target dari tombol
                    const modalContent = document.querySelector(targetModalId +
                        ' .modal-body p'); // Select elemen <p> di dalam modal yang spesifik

                    modalContent.textContent = alasan;
                });
            });

            // Menangani penutupan modal
            const modalAlasan = document.getElementById('modalAlasan');
            modalAlasan.addEventListener('hidden.bs.modal', function(event) {
                // Hapus atau atur ulang konten modal di sini jika diperlukan
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event delegation untuk klik tombol detail dan update
            document.addEventListener('click', function(event) {
                // Tombol Detail
                if (event.target.matches('.detail-button')) {
                    const button = event.target;
                    // Ambil data dari atribut data-*
                    document.getElementById('detailNamaPengemudi').textContent = button.getAttribute(
                        'data-nama-pengemudi') || '-';
                    document.getElementById('detailNamaPegawai').textContent = button.getAttribute(
                        'data-nama-pegawai') || '-';
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

                    // Update progress bar BBM Awal
                    const bbmAwal = button.getAttribute('data-bbm-awal') || 0;
                    const bbmAwalPercentage = (bbmAwal / 8) * 100;
                    const detailBbmAwalBar = document.getElementById('detailBbmAwalBar');
                    const detailBbmAwalValue = document.getElementById('detailBbmAwalValue');

                    detailBbmAwalBar.style.width = bbmAwalPercentage + '%';
                    detailBbmAwalBar.setAttribute('aria-valuenow', bbmAwal);
                    detailBbmAwalValue.textContent = bbmAwal + '/8';

                    // Ubah warna bar BBM Awal
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
            });

            // Modal Update - Menampilkan progress bar BBM Awal dan BBM Akhir
            @foreach ($perjalanan as $item)
                // BBM Akhir
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

                        // Ubah warna bar berdasarkan value
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

        // Konfirmasi Hapus dengan SweetAlert2
        document.addEventListener('click', function(event) {
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
                        // Buat form untuk hapus
                        const form = document.createElement('form');
                        form.action = `/perjalanan/delete/${perjalananId}`;
                        form.method = 'POST';
                        form.style.display = 'none';

                        // CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = "{{ csrf_token() }}";
                        form.appendChild(csrfToken);

                        // Method spoofing untuk DELETE
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
