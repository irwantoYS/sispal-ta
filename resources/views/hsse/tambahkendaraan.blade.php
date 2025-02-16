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
                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                data-bs-target="#addRowModal">
                                <i class="fa fa-plus"></i>
                                Tambah Data
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
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Tipe Kendaraan</label>
                                                        <input type="text" class="form-control" id="tipeKendaraan"
                                                            name="tipe_kendaraan"
                                                            placeholder="Merk Kendaraan || Model Mobil" required />
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
                                        <button type="button" id="addKendaraanButton" class="btn btn-primary">Tambah</button>
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
                                        <th>Tipe Kendaraan</th>
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
                                            <td>{{ $tambahkendaraan->tipe_kendaraan }}</td>
                                            <td>{{ $tambahkendaraan->km_per_liter }}</td>
                                            <td>{{ $tambahkendaraan->status }}</td>
                                            <td>
                                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal"
                                                    onclick="showImage('{{ asset('storage/' . $tambahkendaraan->image) }}')">Lihat
                                                    Gambar</button>
                                            </td>
                                            <!-- Action Buttons in Table -->

                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Edit Button -->
                                                    <button type="button" class="btn btn-link btn-primary btn-lg"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        onclick="openEditModal({{ $tambahkendaraan->id }}, '{{ $tambahkendaraan->no_kendaraan }}', '{{ $tambahkendaraan->tipe_kendaraan }}', {{ $tambahkendaraan->km_per_liter }})">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-link btn-danger"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        onclick="openDeleteModal({{ $tambahkendaraan->id }})">
                                                        <i class="fa fa-times"></i>
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
                                                                    <label>Tipe Kendaraan</label>
                                                                    <input type="text" class="form-control"
                                                                        id="editTipeKendaraan" name="tipe_kendaraan"
                                                                        required>
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

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Confirm Delete</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda Ingin Menghapus Kendaraan?</p>
                                                            <input type="hidden" id="deleteKendaraanId">
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="confirmDelete()">Delete</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </tbody>
                                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Gambar Kendaraan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img id="modalImage" src="" alt="Kendaraan Image"
                                                    style="width: 100%; height: auto;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // SweetAlert to confirm deletion
        function openDeleteModal(id) {
            $('#deleteKendaraanId').val(id);
            $('#deleteModal').modal('show');
        }

        function confirmDelete() {
            let id = $('#deleteKendaraanId').val();

            $.ajax({
                url: '{{ route('hsse.tambahkendaraan.destroy', '') }}/' + id,
                type: 'DELETE',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'Kendaraan Berhasil Dihapus.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire(
                        'Gagal!',
                        'kendaraan Tidak dapat dihapus, data kendaraan sudah digunakan pada Perjalanan.',
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
            $('#imageModal .modal-body img').attr('src', imageUrl);
            $('#imageModal').modal('show');
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
        function openEditModal(id, noKendaraan, tipeKendaraan, kmPerLiter) {
            $('#editKendaraanId').val(id);
            $('#editNoKendaraan').val(noKendaraan);
            $('#editTipeKendaraan').val(tipeKendaraan);
            $('#editKmPerLiter').val(kmPerLiter);
        }
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
