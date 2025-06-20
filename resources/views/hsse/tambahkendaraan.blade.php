@section('title', 'Tambah Kendaraan | HSSE')
@extends('layouts.sidebarhsse')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Tambah Kendaraan</h3>
                    <h6 class="op-7 mb-2">Tambah Kendaraan</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Tabel Tambah Kendaraan</h4>
                            <a href="{{ route('hsse.kendaraan.nonaktif') }}" class="btn btn-warning btn-round ms-auto">
                                <i class="fa fa-car-side"></i>
                                Nonaktif
                            </a>
                            <button class="btn btn-success btn-round ms-2" data-bs-toggle="modal"
                                data-bs-target="#laporanModal">
                                <i class="fa fa-file-alt"></i>
                                Inspeksi
                            </button>
                            <button class="btn btn-primary btn-round ms-2" data-bs-toggle="modal"
                                data-bs-target="#addRowModal">
                                <i class="fa fa-plus"></i>
                                Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Modal -->
                        <!-- Modal for Adding Kendaraan Data -->
                        <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold"> Tambah</span>
                                            <span class="fw-light"> Kendaraan </span>
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="small">
                                            From Tambah Kendaaan Baru. Pastikan Untuk Mengisi Seluruh Data yang Diperlukan
                                        </p>
                                        <form id="addKendaraanForm" enctype="multipart/form-data">
                                            @csrf <!-- CSRF token for Laravel -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>No Kendaraan</label>
                                                        <input type="text" class="form-control" id="noKendaraan"
                                                            name="no_kendaraan" placeholder="BE 1000 AA" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Merk Kendaraan</label>
                                                        <input type="text" class="form-control" id="merkKendaraan"
                                                            name="merk_kendaraan" placeholder="Contoh: Toyota" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Model Mobil</label>
                                                        <input type="text" class="form-control" id="modelMobil"
                                                            name="model_mobil" placeholder="Contoh: Avanza" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>KM/L</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="kmPerLiter" name="km_per_liter" placeholder="KM per Liter"
                                                            required />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Gambar</label>
                                                        <input type="file" class="form-control" id=""
                                                            name="image" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" id="addKendaraanButton"
                                            class="btn btn-primary">Tambah</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table id="kendaraanTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kendaraan</th>
                                        <th>Merk Kendaraan</th>
                                        <th>Model Mobil</th>
                                        <th>KM/L</th>
                                        <th>Status</th>
                                        <th>Gambar</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tambahkendaraan as $key => $tambahkendaraan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $tambahkendaraan->no_kendaraan }}</td>
                                            @php
                                                $tipe = explode(' || ', $tambahkendaraan->tipe_kendaraan);
                                                $merk = $tipe[0] ?? '';
                                                $model = $tipe[1] ?? '';
                                            @endphp
                                            <td>{{ $merk }}</td>
                                            <td>{{ $model }}</td>
                                            <td>{{ $tambahkendaraan->km_per_liter }}</td>
                                            <td>
                                                @if ($tambahkendaraan->status === 'ready')
                                                    <span class="badge bg-success">Ready</span>
                                                @elseif ($tambahkendaraan->status === 'in_use')
                                                    <span class="badge bg-info">Digunakan</span>
                                                @elseif ($tambahkendaraan->status === 'perlu_perbaikan')
                                                    <span class="badge bg-warning">Perlu Perbaikan</span>
                                                @else
                                                    {{ $tambahkendaraan->status }} {{-- Tampilkan apa adanya jika tidak ada yang cocok --}}
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal"
                                                    onclick="showImage('{{ asset('storage/' . $tambahkendaraan->image) }}')">Lihat
                                                    Gambar</button>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Riwayat Button -->
                                                    <a href="{{ route('hsse.kendaraan.history', $tambahkendaraan->id) }}"
                                                        class="btn btn-warning btn-sm" title="Lihat Riwayat Inspeksi">
                                                        Riwayat
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        onclick="openEditModal({{ $tambahkendaraan->id }}, '{{ $tambahkendaraan->no_kendaraan }}', '{{ $merk }}', '{{ $model }}', {{ $tambahkendaraan->km_per_liter }})">
                                                        Edit
                                                    </button>

                                                    <!-- Deactivate Button -->
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                                        onclick="openDeactivateModal({{ $tambahkendaraan->id }})">
                                                        Nonaktifkan
                                                    </button>

                                                </div>
                                            </td>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Edit Kendaraan</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="editKendaraanForm" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" id="editKendaraanId"
                                                                    name="id">
                                                                <div class="form-group">
                                                                    <label>No Kendaraan</label>
                                                                    <input type="text" class="form-control"
                                                                        id="editNoKendaraan" name="no_kendaraan" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Merk Kendaraan</label>
                                                                    <input type="text" class="form-control"
                                                                        id="editMerkKendaraan" name="merk_kendaraan"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Model Mobil</label>
                                                                    <input type="text" class="form-control"
                                                                        id="editModelMobil" name="model_mobil" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>KM/L</label>
                                                                    <input type="number" class="form-control"
                                                                        id="editKmPerLiter" name="km_per_liter" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Gambar (Optional)</label>
                                                                    <input type="file" class="form-control"
                                                                        id="editImage" name="image" accept="image/*">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="updateKendaraan()">Save Changes</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Deactivate Confirmation Modal -->
                                            <div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Konfirmasi Nonaktifkan</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menonaktifkan kendaraan ini?</p>
                                                            <input type="hidden" id="deactivateKendaraanId">
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="confirmDeactivate()">Nonaktifkan</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Gambar Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Kendaraan Image" style="width: 100%; height: auto;" />
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Laporan -->
    <div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporanModalLabel">Laporan Inspeksi Pengemudi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('hsse.kendaraan') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-control">
                                        @foreach ($allMonths as $month)
                                            <option value="{{ $month }}"
                                                {{ $selectedMonth == $month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-control">
                                        @forelse ($availableYears as $year)
                                            <option value="{{ $year }}"
                                                {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}
                                            </option>
                                        @empty
                                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="summaryTable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengemudi</th>
                                    <th>Total Inspeksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inspeksiSummary as $index => $summary)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $summary->nama_pengemudi }}</td>
                                        <td>{{ $summary->total_inspeksi }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data inspeksi untuk periode yang
                                            dipilih.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // SweetAlert to confirm deactivation
        function openDeactivateModal(id) {
            $('#deactivateKendaraanId').val(id);
            $('#deactivateModal').modal('show');
        }

        function confirmDeactivate() {
            let id = $('#deactivateKendaraanId').val();

            $.ajax({
                url: '{{ route('hsse.tambahkendaraan.deactivate', '') }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Dinonaktifkan!',
                        'Kendaraan Berhasil Dinonaktifkan.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire(
                        'Gagal!',
                        response.responseJSON.message || 'Kendaraan tidak dapat dinonaktifkan.',
                        'error'
                    );
                }
            });
        }

        // SweetAlert for adding kendaraan
        $('#addKendaraanButton').click(function() {
            let formData = new FormData($('#addKendaraanForm')[0]);

            $.ajax({
                url: '{{ route('hsse.tambahkendaraan.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#addRowModal').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Berhasil Menambahkan Data Kendaraan Baru.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire(
                        'Gagal!',
                        'Tidak Dapat Menambahkan Data Kendaraan Baru. Periksa data yang anda masukkan kembali',
                        'error'
                    );
                }
            });
        });

        // Function to show image in modal
        function showImage(imageUrl) {
            $('#modalImage').attr('src', imageUrl);
        }

        // SweetAlert for updating kendaraan
        function updateKendaraan() {
            let id = $('#editKendaraanId').val();
            let formData = new FormData($('#editKendaraanForm')[0]);

            $.ajax({
                url: '{{ route('hsse.tambahkendaraan.update', '') }}/' + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Data Kendaraan Berhasil Di Update.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire(
                        'Gagal!',
                        'Tidak Dapat Mengedit Data Kendaraan',
                        'error'
                    );
                }
            });
        }

        // Function to open edit modal with pre-filled data
        function openEditModal(id, noKendaraan, merkKendaraan, modelMobil, kmPerLiter) {
            $('#editKendaraanId').val(id);
            $('#editNoKendaraan').val(noKendaraan);
            $('#editMerkKendaraan').val(merkKendaraan);
            $('#editModelMobil').val(modelMobil);
            $('#editKmPerLiter').val(kmPerLiter);
        }

        // Inisialisasi DataTable untuk modal hanya saat modal tersebut ditampilkan
        $('#laporanModal').on('shown.bs.modal', function() {
            if (!$.fn.DataTable.isDataTable('#summaryTable')) {
                $('#summaryTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                    "language": {
                        "paginate": {
                            "previous": "&laquo;",
                            "next": "&raquo;"
                        }
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#kendaraanTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
                "language": {
                    "paginate": {
                        "previous": "&laquo;",
                        "next": "&raquo;"
                    }
                }
            });
        });
    </script>

@endsection
