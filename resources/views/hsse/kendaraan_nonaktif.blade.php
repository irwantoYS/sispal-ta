@section('title', 'Kendaraan Nonaktif | HSSE')
@extends('layouts.sidebarhsse')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Kendaraan Nonaktif</h3>
                    <h6 class="op-7 mb-2">Daftar kendaraan yang telah dinonaktifkan.</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Tabel Kendaraan Nonaktif</h4>
                            <a href="{{ route('hsse.kendaraan') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="deactivatedKendaraanTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kendaraan</th>
                                        <th>Tipe Kendaraan</th>
                                        <th>KM/L</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kendaraan as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->no_kendaraan }}</td>
                                            <td>{{ $item->tipe_kendaraan }}</td>
                                            <td>{{ $item->km_per_liter }}</td>
                                            <td>
                                                <form action="{{ route('hsse.kendaraan.activate', $item->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali kendaraan ini?')">
                                                        Aktifkan
                                                    </button>
                                                </form>
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

    <script>
        $(document).ready(function() {
            $('#deactivatedKendaraanTable').DataTable({
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
