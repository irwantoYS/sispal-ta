@extends('layouts.sidebarhsse')

@section('title', 'Kelola Nama Pengguna | HSSE')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Kelola Nama Pengguna</h3>
                    <h6 class="op-7 mb-2">Daftar Nama Pengguna</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Pengguna</h4>
                        <a href="{{ route('hsse.pegawai.create') }}" class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Pengguna
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="pegawaiTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pegawaiList as $index => $pegawai)
                                        <tr>
                                            <td>{{ $pegawaiList->firstItem() + $index }}</td> {{-- Penomoran pagination --}}
                                            <td>{{ $pegawai->nama }}</td>
                                            <td>
                                                <a href="{{ route('hsse.pegawai.edit', $pegawai->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm delete-button"
                                                    data-id="{{ $pegawai->id }}"
                                                    data-nama="{{ $pegawai->nama }}">Hapus</button>
                                                <form id="delete-form-{{ $pegawai->id }}"
                                                    action="{{ route('hsse.pegawai.destroy', $pegawai->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                                <td colspan="3" class="text-center">Tidak ada data pengguna.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination Links --}}
                        <div class="mt-3">
                            {{ $pegawaiList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Menggunakan stack 'scripts' jika layout Anda mendukungnya --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi DataTable (jika diperlukan)
            // $('#pegawaiTable').DataTable(); 

            // SweetAlert untuk tombol hapus
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pegawaiId = this.getAttribute('data-id');
                    const pegawaiNama = this.getAttribute('data-nama');
                    const form = document.getElementById(`delete-form-${pegawaiId}`);

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: `Anda akan menghapus pengguna "${pegawaiNama}"!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
