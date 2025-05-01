@extends('layouts.sidebarhsse')

@section('title', 'Akun Nonaktif | HSSE')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div class="flex-grow-1">
                    <h3 class="fw-bold mb-3">Daftar Akun Nonaktif</h3>
                    <h6 class="op-7 mb-2">Akun pengguna yang sudah tidak aktif</h6>
                </div>
                <div class="ms-md-auto py-2 py-md-0 mt-3 mt-md-0">
                    <a href="{{ route('hsse.kelolaakun') }}" class="btn btn-secondary btn-round">Kembali ke Kelola Akun
                        Aktif</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Daftar Akun Nonaktif</h4>
                </div>
                <div class="card-body">
                    @if ($users->isEmpty())
                        <p class="text-center">Tidak ada akun nonaktif saat ini.</p>
                    @else
                        <div class="table-responsive">
                            <table id="nonaktifTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Role</th>
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
                                                <span class="badge bg-secondary">{{ $user->role }}</span>
                                            </td>
                                            <td>
                                                <!-- Tombol Aktifkan -->
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#activateModal-{{ $user->id }}">Aktifkan</button>
                                            </td>
                                        </tr>

                                        <!-- Modal Konfirmasi Aktifkan -->
                                        <div class="modal fade" id="activateModal-{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="activateModalLabel-{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="activateModalLabel-{{ $user->id }}">
                                                            Konfirmasi Aktifkan Akun</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin mengaktifkan kembali akun
                                                        <strong>{{ $user->nama }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('hsse.kelolaakun.activate', $user) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('PATCH') {{-- Gunakan PATCH atau PUT untuk update status --}}
                                                            <button type="submit" class="btn btn-success">Ya,
                                                                Aktifkan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk SweetAlert dan DataTable (jika diperlukan) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Script SweetAlert untuk pesan success/error bisa ditambahkan di sini
        // mirip dengan yang ada di kelolaakun.blade.php
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000
            });
        @endif

        // Inisialisasi DataTable (opsional, sesuaikan jika perlu)
        // $(document).ready(function() {
        //     $('#nonaktifTable').DataTable();
        // });
    </script>
@endsection
