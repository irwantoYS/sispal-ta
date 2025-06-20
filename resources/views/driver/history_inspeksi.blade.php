@extends('layouts.sidebardriver')
@section('title', 'Riwayat Inspeksi Kendaraan')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs">
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Riwayat Inspeksi Kendaraan: {{ $kendaraan->no_kendaraan }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('driver.kendaraan.inspeksi.history', $kendaraan->id) }}"
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
                                    <a href="{{ route('driver.kendaraan.inspeksi.history', $kendaraan->id) }}"
                                        class="btn btn-secondary ms-2 w-100">Reset</a>
                                </div>
                            </div>
                        </form>

                        <!-- Card untuk Top Inspector -->
                        {{-- @if ($topInspector)
                            <div class="card card-stats card-info card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="flaticon-user-4"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-stats">
                                            <div class="numbers">
                                                <p class="card-category">Paling Sering Inspeksi</p>
                                                <h4 class="card-title">{{ $topInspector['user']->nama ?? 'N/A' }}</h4>
                                                <p class="card-category">{{ $topInspector['count'] }} kali inspeksi</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                Belum ada riwayat inspeksi untuk kendaraan ini.
                            </div>
                        @endif --}}

                        <!-- Tabel Riwayat Inspeksi -->
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
                                                    <a href="{{ route('driver.inspeksi.show', $inspeksi->id) }}"
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
                            <a href="{{ route('driver.kendaraan') }}" class="btn btn-secondary mt-3">Kembali</a>
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
