@section('title', 'Kendaraan | Manager Area')
@extends('layouts.sidebarma')
@section('content')


    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Data Kendaraan</h3>
                    <h6 class="op-7 mb-2">Data Kendaraan</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="kelolaTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kendaraan</th>
                                        <th>Tipe Kendaraan</th>
                                        <th>KM/L</th>
                                        <th>Status</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
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
                                                <a href="{{ route('managerarea.showinspeksi', ['inspeksi' => $k->riwayatInspeksi->sortByDesc('tanggal_inspeksi')->sortByDesc('id')->first()->id]) }}"
                                                    class="btn btn-info btn-sm">
                                                    Detail Inspeksi
                                                </a>
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
