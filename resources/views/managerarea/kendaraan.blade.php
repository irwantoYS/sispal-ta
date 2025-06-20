@extends('layouts.sidebarma')
@section('title', 'Kendaraan | Manager Area')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Data Kendaraan</h3>
                    <h6 class="op-7 mb-2">Pengelolaan dan Laporan Kendaraan</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar Kendaraan</h4>
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#laporanModal">
                                    <i class="fa fa-file-alt"></i>
                                    Laporan Inspeksi
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kendaraanTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kendaraan</th>
                                            <th>Tipe Kendaraan</th>
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
                                                <td>
                                                    @if ($k->status === 'ready')
                                                        <span class="badge bg-success">Ready</span>
                                                    @elseif ($k->status === 'in_use')
                                                        <span class="badge bg-info">Digunakan</span>
                                                    @elseif ($k->status === 'perlu_perbaikan')
                                                        <span class="badge bg-warning">Perlu Perbaikan</span>
                                                    @else
                                                        {{ $k->status }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#imageModal"
                                                        onclick="showImage('{{ asset('storage/' . $k->image) }}')">Lihat
                                                        Gambar</button>
                                                </td>
                                                <td>
                                                    <a href="{{ route('managerarea.kendaraan.history', $k->id) }}"
                                                        class="btn btn-warning btn-sm"
                                                        title="Lihat Riwayat Inspeksi">Riwayat</a>
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
                    <form method="GET" action="{{ route('managerarea.kendaraan') }}" class="mb-4">
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


    <!-- Modal Gambar -->
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#kendaraanTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true
            });

            $('#laporanModal').on('shown.bs.modal', function() {
                if (!$.fn.DataTable.isDataTable('#summaryTable')) {
                    $('#summaryTable').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "responsive": true
                    });
                }
            });
        });

        function showImage(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
        }
    </script>
@endpush
