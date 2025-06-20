@extends('layouts.sidebarhsse')
@section('title', 'Riwayat Inspeksi Kendaraan')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Riwayat Inspeksi Kendaraan: {{ $kendaraan->no_kendaraan }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('hsse.kendaraan.history', $kendaraan->id) }}"
                            class="mb-4 border-bottom pb-4">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-5">
                                    <label for="startDate" class="form-label">Tanggal Awal</label>
                                    <input type="date" id="startDate" name="startDate" class="form-control"
                                        value="{{ $startDate ?? '' }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="endDate" class="form-label">Tanggal Akhir</label>
                                    <input type="date" id="endDate" name="endDate" class="form-control"
                                        value="{{ $endDate ?? '' }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    <a href="{{ route('hsse.kendaraan.history', $kendaraan->id) }}"
                                        class="btn btn-secondary ms-2 w-100">Reset</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table id="historyInspeksi" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Inspeksi</th>
                                        <th>Nama Pengemudi</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($inspections as $index => $inspeksi)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($inspeksi->tanggal_inspeksi)->format('d F Y') }}
                                            </td>
                                            <td>{{ $inspeksi->user->nama ?? 'Pengemudi tidak ditemukan' }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('hsse.showinspeksi', $inspeksi->id) }}"
                                                        class="btn btn-info btn-sm" title="Lihat Detail">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('inspeksi.pdf', $inspeksi->id) }}"
                                                        class="btn btn-danger btn-sm" title="Unduh PDF">
                                                        PDF
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data riwayat inspeksi yang
                                                cocok dengan filter.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <a href="{{ route('hsse.kendaraan') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#historyInspeksi').DataTable({
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
@endpush
