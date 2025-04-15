@extends('layouts.sidebarhsse')

@section('title', 'Kelola Akun | HSSE')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Kelola Akun</h3>
                    <h6 class="op-7 mb-2">Daftar akun pengguna di sistem</h6>
                </div>
            </div>
            {{-- 
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Akun</h4>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah
                        Akun</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="kelolaTable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>email</th>
                                    <th>No Telepon</th>
                                    <th>Role</th>
                                    <th>Image</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->no_telepon }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $user->role }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                onclick="showImage('{{ asset('storage/' . $user->image) }}')">Lihat
                                                Gambar</button>

                                        </td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal-{{ $user->id }}">Edit</button>

                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal-{{ $user->id }}">Hapus</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Akun -->
                                    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('hsse.kelolaakun.update', $user) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editUserModalLabel-{{ $user->id }}">Edit Akun</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif --}}

                                                        <div class="mb-3">
                                                            <label for="nama-{{ $user->id }}"
                                                                class="form-label">Nama</label>
                                                            <input type="text" class="form-control"
                                                                id="nama-{{ $user->id }}" name="nama"
                                                                value="{{ $user->nama }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="no_telepon-{{ $user->id }}"
                                                                class="form-label">No Telepon</label>
                                                            <input type="text" class="form-control"
                                                                id="no_telepon-{{ $user->id }}" name="no_telepon"
                                                                value="{{ $user->no_telepon }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email-{{ $user->id }}"
                                                                class="form-label">email</label>
                                                            <input type="text" class="form-control"
                                                                id="email-{{ $user->id }}" name="email"
                                                                value="{{ $user->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password-{{ $user->id }}"
                                                                class="form-label">Password</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    id="password-{{ $user->id }}" name="password">
                                                                <span class="input-group-text" style="cursor: pointer;"
                                                                    onclick="togglePasswordVisibility({{ $user->id }})">
                                                                    {{-- <i class="bi bi-eye"></i> --}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="role-{{ $user->id }}"
                                                                class="form-label">Role</label>
                                                            <select class="form-control" id="role-{{ $user->id }}"
                                                                name="role" required>
                                                                <option value="ManagerArea"
                                                                    {{ $user->role == 'ManagerArea' ? 'selected' : '' }}>
                                                                    Manager Area</option>
                                                                <option value="HSSE"
                                                                    {{ $user->role == 'HSSE' ? 'selected' : '' }}>HSSE
                                                                </option>
                                                                <option value="Driver"
                                                                    {{ $user->role == 'Driver' ? 'selected' : '' }}>Driver
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="image-{{ $user->id }}"
                                                                class="form-label">Foto</label>
                                                            <input type="file" class="form-control"
                                                                id="image-{{ $user->id }}" name="image">
                                                            <small class="text-muted">Kosongkan jika tidak ingin mengganti
                                                                foto.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
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
                                            <img id="modalImage" src="" alt="tidak ada gambar"
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

    <!-- Modal Hapus Akun -->
        <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" 
            aria-labelledby="deleteModalLabel-{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $user->id }}">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus akun <strong>{{ $user->nama }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('hsse.kelolaakun.destroy', $user) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        </div>


    <!-- Modal Tambah Akun -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('hsse.kelolaakun.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah Akun Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="ManagerArea">Manager Area</option>
                                <option value="HSSE">HSSE</option>
                                <option value="Driver">Driver</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000
            });
        </script>
    @endif

    @if (session('errors'))
        <script>
            var errors = {!! html_entity_decode(session('errors')) !!};
            var errorMessage = '';

            // Loop through the errors object and concatenate all error messages
            for (var key in errors) {
                errorMessage += errors[key][0] + '<br>';
            }

            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: errorMessage
            });
        </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menghapus!',
            text: '{{ session('error') }}',
            timer: 3000
        });
    </script>
@endif


    <script>
        function showImage(imageUrl) {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
        }

        $(document).ready(function() {
            $('#kelolaTable').DataTable({
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
