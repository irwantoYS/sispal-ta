@section('title', 'Riwayat DCU | HSSE')
@extends('layouts.sidebarhsse')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Riwayat Daily Check Up (DCU)</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="dcu-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Driver</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Tekanan Darah</th>
                                <th>Nadi</th>
                                <th>Pernapasan</th>
                                <th>SpO2</th>
                                <th>Suhu</th>
                                <th>Mata</th>
                                <th>Kesimpulan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dcurecords as $index => $record)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $record->user->nama }}</td>
                                    <td>{{ $record->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $record->shift }}</td>
                                    <td>{{ $record->sistolik }}/{{ $record->diastolik }}</td>
                                    <td>{{ $record->nadi }}</td>
                                    <td>{{ $record->pernapasan }}</td>
                                    <td>{{ $record->spo2 }}</td>
                                    <td>{{ $record->suhu_tubuh }}</td>
                                    <td>{{ $record->mata }}</td>
                                    <td>
                                        <span class="badge {{ $record->kesimpulan == 'Fit' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $record->kesimpulan }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('hsse.dcu.pdf', $record->id) }}" class="btn btn-sm btn-info"
                                            target="_blank">
                                            <i class="fas fa-print"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">Tidak ada data riwayat DCU.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dcu-table').DataTable({
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'<'table-responsive'tr>>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    }
                }
            });
        });
    </script>
@endpush
