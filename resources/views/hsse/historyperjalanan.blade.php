@section('title', 'History Perjalanan | HSSE')
@extends('layouts.sidebarhsse')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">History Perjalanan</h3>
                <h6 class="op-7 mb-2">History Perjalanan</h6>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <label for="startDate" class="form-label fw-bold">Cari berdasarkan tanggal awal dan akhir:</label>
                        <form action="{{ route('hsse.history') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="date" id="startDate" name="startDate" class="form-control" placeholder="Tanggal Awal">
                                <input type="date" id="endDate" name="endDate" class="form-control" placeholder="Tanggal Akhir">
                                <button class="btn btn-primary" type="submit">Cari</button>
                                <button class="btn btn-secondary" type="button" id="resetSearch">Reset</button>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex">
                         <button type="button" class="btn btn-primary btn-round me-2" data-bs-toggle="modal" data-bs-target="#driverSummaryModal">
                           <i class="fas fa-chart-bar"></i>
                        </button>

                        <a class="btn btn-success btn-round ms-auto" href="{{ route('cetak.pdf', ['role' => 'HSSE', 'startDate' => request('startDate'), 'endDate' => request('endDate')]) }}">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <div class="text-center"><p><strong>Total Seluruh Perjalan {{ $rentangTanggal }}</strong></p></div>
                        <p><strong>Total Estimasi Jarak:</strong> {{ number_format($totalEstimasiJarak, 2, '.', '') }} KM</p>
                        <p><strong>Total Estimasi BBM:</strong> {{ number_format($totalEstimasiBBM, 2, '.', '') }} Liter</p>
                        <p><strong>Total Estimasi Waktu:</strong> {{ $totalDurasiFormat }}</p>
                    </div>

                    <div class="table-responsive">
                        <table id="allhistoryTable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengemudi</th>
                                    <th>Nama Pegawai</th>
                                    <th>Titik Awal</th>
                                    <th>Titik Akhir</th>
                                    <th>Tujuan Perjalanan</th>
                                    <th>Jam Pergi</th>
                                    <th>Jam Kembali</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perjalanan as $key => $perjalanan)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $perjalanan->user->nama }}</td>
                                    <td>{{ $perjalanan->nama_pegawai }}</td>
                                    <td>{{ $perjalanan->titik_awal }}</td>
                                    <td>{{ $perjalanan->titik_akhir }}</td>
                                    <td>{{ $perjalanan->tujuan_perjalanan }}</td>
                                    <td>{{ $perjalanan->jam_pergi }}</td>
                                    <td>{{ $perjalanan->jam_kembali }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal" data-bs-target="#detailModal" data-nama-pengemudi="{{ $perjalanan->user->nama }}" data-nama-pegawai="{{ $perjalanan->nama_pegawai }}" data-titik-awal="{{ $perjalanan->titik_awal }}" data-titik-akhir="{{ $perjalanan->titik_akhir }}" data-tujuan="{{ $perjalanan->tujuan_perjalanan }}" data-no-kendaraan="{{ $perjalanan->Kendaraan->no_kendaraan ?? '-' }}" data-tipe-kendaraan="{{ $perjalanan->Kendaraan->tipe_kendaraan ?? '-' }}" data-km-awal="{{ $perjalanan->km_awal }}" data-km-akhir="{{ $perjalanan->km_akhir }}" data-bbm-awal="{{ $perjalanan->bbm_awal }}" data-bbm-akhir="{{ $perjalanan->bbm_akhir }}" data-jam-pergi="{{ $perjalanan->jam_pergi }}" data-jam-kembali="{{ $perjalanan->jam_kembali }}">
                                            Lihat Detail
                                        </button>
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

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Perjalanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Pengemudi</th>
                            <td id="detailNamaPengemudi"></td>
                        </tr>
                        <tr>
                            <th>Nama Pegawai</th>
                            <td id="detailNamaPegawai"></td>
                        </tr>
                        <tr>
                            <th>Titik Awal</th>
                            <td id="detailTitikAwal"></td>
                        </tr>
                        <tr>
                            <th>Titik Akhir</th>
                            <td id="detailTitikAkhir"></td>
                        </tr>
                        <tr>
                            <th>Tujuan</th>
                            <td id="detailTujuan"></td>
                        </tr>
                        <tr>
                            <th>No Kendaraan</th>
                            <td id="detailNoKendaraan"></td>
                        </tr>
                        <tr>
                            <th>Tipe Kendaraan</th>
                            <td id="detailTipeKendaraan"></td>
                        </tr>
                        <tr>
                            <th>KM Awal</th>
                            <td id="detailKmAwal"></td>
                        </tr>
                        <tr>
                            <th>KM Akhir</th>
                            <td id="detailKmAkhir"></td>
                        </tr>
                        <tr>
                            <th>BBM Awal</th>
                            <td id="detailBbmAwal"></td>
                        </tr>
                        <tr>
                            <th>BBM Akhir</th>
                            <td id="detailBbmAkhir"></td>
                        </tr>
                        <tr>
                            <th>Jam Pergi</th>
                            <td id="detailJamPergi"></td>
                        </tr>
                        <tr>
                            <th>jam Kembali</th>
                            <td id="detailJamKembali"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="driverSummaryModal" tabindex="-1" aria-labelledby="driverSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="driverSummaryModalLabel">Ringkasan Perjalanan per Driver {{$rentangTanggal}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Driver</th>
                                    <th>Total Jarak Tempuh (KM)</th>
                                    <th>Total Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($driverSummary as $index => $driver)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $driver->user->nama }}</td>
                                    <td>{{ $driver->total_jarak}}</td>
                                    <td>{{ $driver->total_durasi_format }}</td>
                                </tr>
                                @endforeach
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal Lihat Detail
            const detailButtons = document.querySelectorAll('.detail-button');

            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil data dari atribut data-*
                    document.getElementById('detailNamaPengemudi').textContent = this.getAttribute('data-nama-pengemudi') || '-';
                    document.getElementById('detailNamaPegawai').textContent = this.getAttribute('data-nama-pegawai') || '-';
                    document.getElementById('detailTitikAwal').textContent = this.getAttribute('data-titik-awal') || '-';
                    document.getElementById('detailTitikAkhir').textContent = this.getAttribute('data-titik-akhir') || '-';
                    document.getElementById('detailTujuan').textContent = this.getAttribute('data-tujuan') || '-';
                    document.getElementById('detailNoKendaraan').textContent = this.getAttribute('data-no-kendaraan') || '-';
                    document.getElementById('detailTipeKendaraan').textContent = this.getAttribute('data-tipe-kendaraan') || '-';
                    document.getElementById('detailKmAwal').textContent = this.getAttribute('data-km-awal') || '-';
                    document.getElementById('detailKmAkhir').textContent = this.getAttribute('data-km-akhir') || '-';
                    document.getElementById('detailBbmAwal').textContent = this.getAttribute('data-bbm-awal') || '-';
                    document.getElementById('detailBbmAkhir').textContent = this.getAttribute('data-bbm-akhir') || '-';
                    document.getElementById('detailJamPergi').textContent = this.getAttribute('data-jam-pergi') || '-';
                    document.getElementById('detailJamKembali').textContent = this.getAttribute('data-jam-kembali') || '-';
                });
            });

            // Tambahkan pencarian berdasarkan rentang tanggal
            document.querySelector('form[action="{{ route('hsse.history') }}"]').addEventListener('submit', function(e) {
                e.preventDefault();
                var startDate = document.querySelector('input[name="startDate"]').value;
                var endDate = document.querySelector('input[name="endDate"]').value;

                if (startDate && endDate) {
                    window.location.href = "{{ route('hsse.history') }}?startDate=" + startDate + "&endDate=" +
                        endDate;
                }
            });

            //DataTable
            const table = $('#allhistoryTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "lengthChange": true,
                "responsive": true,
                "language": {
                    "paginate": {
                        "previous": "&laquo;",
                        "next": "&raquo;"
                    }
                }
            });

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                const search = $('#searchText').val();
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                table.search(search).draw(); // Pencarian kata kunci
                table.columns([0, 1, 2, 3, 4, 5, 6, 7, 8]).search(startDate)
                    .draw(); // Pencarian berdasarkan tanggal
                table.columns([0, 1, 2, 3, 4, 5, 6, 7, 8]).search(endDate)
                    .draw(); // Pencarian berdasarkan tanggal
            });

            // Tombol cetak PDF
            $('#cetakPDF').on('click', function() {
                const params = $.param({
                    search: table.search(), // Ambil kata kunci pencarian
                    startDate: $('input[name="startDate"]').val(), // Ambil tanggal awal
                    endDate: $('input[name="endDate"]').val(), // Ambil tanggal akhir
                });
                const url = `{{ route('cetak.pdf', ['role' => 'HSSE']) }}?${params}`;
                window.open(url, '_blank');
            });

            // Reset pencarian
            const resetSearchButton = document.getElementById('resetSearch');
            resetSearchButton.addEventListener('click', function() {
                document.getElementById('startDate').value = '';
                document.getElementById('endDate').value = '';
                window.location.href = '{{ route('hsse.history') }}';
            });
        });

       
    </script>

@endsection