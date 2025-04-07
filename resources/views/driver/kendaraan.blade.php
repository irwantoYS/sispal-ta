@section('title', 'Kendaraan | Driver')
@extends('layouts.sidebardriver')
@section('content')


    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Daftar Kendaraan</h3>
                    <h6 class="op-7 mb-2">Informasi Kendaraan</h6>
                </div>
            </div>

            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tidak dapat melakukan inspeksi',
                            text: '{{ session('error') }}',
                            confirmButtonText: 'OK'
                        });
                    });
                </script>
            @endif

            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: '{{ session('success') }}',
                            confirmButtonText: 'OK'
                        });
                    });
                </script>
            @endif

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Kendaraan</h4>
                    </div>
                    <div class="card-body">
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
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kendaraan as $key => $k)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $k->no_kendaraan }}</td>
                                            <td>{{ $k->tipe_kendaraan }}</td>
                                            <td>{{ $k->km_per_liter }}</td>
                                            <td>
                                                @if ($k->status === 'ready')
                                                    <span class="badge bg-success">Ready</span>
                                                @elseif ($k->status === 'in_use')
                                                    <span class="badge bg-info">Digunakan</span>
                                                @elseif ($k->status === 'perlu_perbaikan')
                                                    <span class="badge bg-warning">Perlu Perbaikan</span>
                                                @else
                                                    {{ $k->status }} {{-- Tampilkan apa adanya jika tidak ada yang cocok --}}
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal"
                                                    onclick="showImage('{{ asset('storage/' . $k->image) }}')">Lihat
                                                    Gambar</button>
                                            </td>
                                            <td>
                                                {{-- Tombol Detail Inspeksi --}}
                                                @if ($k->riwayatInspeksi->isNotEmpty())
                                                    <a href="{{ route('driver.showinspeksi', ['inspeksi' => $k->riwayatInspeksi->sortByDesc('tanggal_inspeksi')->sortByDesc('id')->first()->id]) }}"
                                                        class="btn btn-info btn-sm">
                                                        Detail Inspeksi
                                                    </a>
                                                @else
                                                    Belum Pernah Diinspeksi
                                                @endif
                                                @if ($k->status !== 'in_use')
                                                    <a href="{{ route('driver.viewinspeksi', $k->id) }}"
                                                        class="btn btn-primary btn-sm">Inspeksi</a>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled>Sedang
                                                        Digunakan</button>
                                                @endif
                                            </td>
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
        // Function to show image in modal
        function showImage(imageUrl) {
            $('#imageModal .modal-body img').attr('src', imageUrl);
            $('#imageModal').modal('show');
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
