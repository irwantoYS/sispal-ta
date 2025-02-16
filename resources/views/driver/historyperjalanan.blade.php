@section('title', 'History | Driver')
@extends('layouts.sidebardriver')
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
                        <form action="{{ route('driver.history') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="date" id="startDate" name="startDate" class="form-control"
                                    placeholder="Tanggal Awal">
                                <input type="date" id="endDate" name="endDate" class="form-control"
                                    placeholder="Tanggal Akhir">
                                <button class="btn btn-primary" type="submit">Cari</button>
                                <button class="btn btn-secondary" type="button" id="resetSearch">Reset</button>
                            </div>
                        </form>
                    </div>

                    <a class="btn btn-success btn-round ms-auto"
                        href="{{ route('cetak.pdf', ['role' => 'Driver', 'startDate' => request('startDate'), 'endDate' => request('endDate')]) }}">
                        <i class="fa-solid fa-print"></i> PDF
                    </a>

                </div>

                <div class="card-body">
                    {{-- Tambahkan baris ini untuk menampilkan total --}}
                        <div class="mb-4">
                            <div class="text-center"><strong>
                                Total seluruh Perjalanan 
                                @if ($startDate && $endDate)
                                    dari {{ $startDate->translatedFormat('d F Y') }} hingga {{ $endDate->translatedFormat('d F Y') }}
                                @endif
                                </strong>
                            </div>
                            <p><strong>Total Estimasi Jarak:</strong> {{ number_format($totalEstimasiJarak, 2, '.', '') }} KM</p>
                            <p><strong>Total Estimasi BBM:</strong> {{ number_format($totalEstimasiBBM, 2, '.', '') }} Liter</p>
                            <p><strong>Total Estimasi Waktu:</strong> {{ $totalDurasiFormat }}</p>
                        </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="historyTable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Titik Akhir</th>
                                    <th>Tujuan Perjalanan</th>
                                    <th>Jam Pergi</th>
                                    <th>Jam Kembali</th>
                                    <th>Estimasi Waktu</th> {{-- Ganti header menjadi Durasi --}}
                                    <th>KM & BBM Awal</th>
                                    <th>KM & BBM Akhir</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Detail</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($perjalanan as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->nama_pegawai }}</td>
                                    {{-- <td>{{ $item->titik_awal }}</td> --}}
                                    <td>{{ $item->titik_akhir }}</td>
                                    <td>{{ $item->tujuan_perjalanan }}</td>
                                    <td>{{ $item->jam_pergi }}</td>
                                    <td>{{ $item->jam_kembali }}</td>
                                    <td>{{ $item->estimasi_waktu}}</td>
                                    
                                    <td>
                                        @if ($item->foto_awal)
                                        <button class="btn btn-info btn-sm foto-link" data-bs-toggle="modal"
                                            data-bs-target="#fotoModal"
                                            data-foto="{{ asset('storage/' . $item->foto_awal) }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @else
                                        <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->foto_akhir)
                                        <button class="btn btn-info btn-sm foto-link" data-bs-toggle="modal"
                                            data-bs-target="#fotoModal"
                                            data-foto="{{ asset('storage/' . $item->foto_akhir) }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @else
                                        <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <span class="badge bg-primary">Selesai</span>
                                    </td> --}}
                                    <td>
                                        <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                            data-bs-target="#detailModal"
                                            data-nama-pengemudi="{{ $item->user->nama }}"
                                            data-nama-pegawai="{{ $item->nama_pegawai }}"
                                            data-titik-awal="{{ $item->titik_awal }}"
                                            data-titik-akhir="{{ $item->titik_akhir }}"
                                            data-tujuan="{{ $item->tujuan_perjalanan }}"
                                            data-no-kendaraan="{{ $item->Kendaraan->no_kendaraan ?? '-' }}"
                                            data-tipe-kendaraan="{{ $item->Kendaraan->tipe_kendaraan ?? '-' }}"
                                            {{-- data-km-awal="{{ $item->km_awal }}" --}}
                                            data-km-akhir="{{ $item->km_akhir }}"
                                            data-bbm-awal="{{ $item->bbm_awal }}"
                                            data-bbm-akhir="{{ $item->bbm_akhir }}"
                                            data-jam-pergi="{{ $item->jam_pergi}}"
                                            data-jam-kembali="{{ $item->jam_kembali}}"
                                            data-estimasi-waktu="{{ $item->estimasi_waktu}}"
                                            data-estimasi-bbm="{{ $item->estimasi_bbm }}">
                                            Detail
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
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Perjalanan yang Telah Selesai</h5>
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
                    {{-- <tr>
                        <th>KM Awal</th>
                        <td id="detailKmAwal"></td>
                    </tr> --}}
                    <tr>
                        <th>BBM Awal</th>
                        <td>
                            <div class="progress" style="height: 25px;">
                                <div id="detailBbmAwalBar" class="progress-bar" role="progressbar"
                                    style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="8">
                                    <span id="detailBbmAwalValue">0</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>BBM Akhir</th>
                        <td>
                            <div class="progress" style="height: 25px;">
                                <div id="detailBbmAkhirBar" class="progress-bar" role="progressbar"
                                    style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="8">
                                    <span id="detailBbmAkhirValue">0</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Jam Pergi</th>
                        <td id="detailJamPergi"></td>
                    </tr>
                    <tr>
                        <th>Jam Kembali</th>
                        <td id="detailJamKembali"></td>
                    </tr>
                    <tr>
                        <th>Estimasi Total Jarak Tempuh</th>
                        <td id="detailKmAkhir"></td>
                    </tr>
                    <tr>
                        <th>Estimasi Waktu</th>
                        <td id="detailEstimasiWaktu"></td>
                    </tr>
                    <tr>
                        <th>Estimasi BBM</th>
                        <td id="detailEstimasiBBM"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel">Foto KM & BBM Awal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="fotoPreview" src="" alt="Foto Perjalanan" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua link dengan class 'foto-link'
        const fotoLinks = document.querySelectorAll('.foto-link');

        fotoLinks.forEach(link => {
            link.addEventListener('click', function() {
                const fotoSrc = this.getAttribute('data-foto');
                document.getElementById('fotoPreview').setAttribute('src', fotoSrc);
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation untuk klik tombol detail dan update
        document.addEventListener('click', function(event) {
            // Tombol Detail
            if (event.target.matches('.detail-button')) {
                const button = event.target;
                // Ambil data dari atribut data-*
                document.getElementById('detailNamaPengemudi').textContent = button.getAttribute(
                    'data-nama-pengemudi') || '-';
                document.getElementById('detailNamaPegawai').textContent = button.getAttribute(
                    'data-nama-pegawai') || '-';
                document.getElementById('detailTitikAwal').textContent = button.getAttribute(
                    'data-titik-awal') || '-';
                document.getElementById('detailTitikAkhir').textContent = button.getAttribute(
                    'data-titik-akhir') || '-';
                document.getElementById('detailTujuan').textContent = button.getAttribute(
                    'data-tujuan') || '-';
                document.getElementById('detailNoKendaraan').textContent = button.getAttribute(
                    'data-no-kendaraan') || '-';
                document.getElementById('detailTipeKendaraan').textContent = button.getAttribute(
                    'data-tipe-kendaraan') || '-';
                // document.getElementById('detailKmAwal').textContent = button.getAttribute(
                //     'data-km-awal') || '-';
                let estimasiJarakTempuh = button.getAttribute ('data-km-akhir');
                document.getElementById('detailKmAkhir').textContent = estimasiJarakTempuh || '-';
                // document.getElementById('detailBbmAwal').textContent = button.getAttribute(
                //     'data-bbm-awal') || '-';
                // document.getElementById('detailBbmAkhir').textContent = button.getAttribute(
                //     'data-bbm-akhir') ? button.getAttribute('data-bbm-akhir') + '/8' : '0/8';
                document.getElementById('detailJamPergi').textContent = button.getAttribute(
                    'data-jam-pergi') || '-';
                document.getElementById('detailJamKembali').textContent = button.getAttribute(
                    'data-jam-kembali') || '-';
                document.getElementById('detailEstimasiWaktu').textContent = button.getAttribute(
                    'data-Estimasi-waktu') || '-';
                 // Update nilai estimasi bbm pada modal
                 let estimasiBBM = button.getAttribute('data-estimasi-bbm');
                document.getElementById('detailEstimasiBBM').textContent = estimasiBBM + " Liter";

                // // Hitung total jarak pergi-pulang
                // const estimasiJarak = parseFloat(button.getAttribute('data-estimasi-jarak'));
                // const totalJarak = estimasiJarak * 2; // Hitung total jarak pergi-pulang

                // Update progress bar BBM Awal
                const bbmAwal = button.getAttribute('data-bbm-awal') || 0;
                const bbmAwalPercentage = (bbmAwal / 8) * 100;
                const detailBbmAwalBar = document.getElementById('detailBbmAwalBar');
                const detailBbmAwalValue = document.getElementById('detailBbmAwalValue');

                detailBbmAwalBar.style.width = bbmAwalPercentage + '%';
                detailBbmAwalBar.setAttribute('aria-valuenow', bbmAwal);
                detailBbmAwalValue.textContent = bbmAwal + '/8';

                // Ubah warna bar BBM Awal
                if (bbmAwal >= 6) {
                    detailBbmAwalBar.classList.remove('bg-warning', 'bg-danger');
                    detailBbmAwalBar.classList.add('bg-success');
                } else if (bbmAwal >= 3) {
                    detailBbmAwalBar.classList.remove('bg-success', 'bg-danger');
                    detailBbmAwalBar.classList.add('bg-warning');
                } else {
                    detailBbmAwalBar.classList.remove('bg-success', 'bg-warning');
                    detailBbmAwalBar.classList.add('bg-danger');
                }

                // Update progress bar BBM Akhir
                const bbmAkhir = button.getAttribute('data-bbm-akhir') || 0;
                const bbmAkhirPercentage = (bbmAkhir / 8) * 100;
                const detailBbmAkhirBar = document.getElementById('detailBbmAkhirBar');
                const detailBbmAkhirValue = document.getElementById('detailBbmAkhirValue');

                detailBbmAkhirBar.style.width = bbmAkhirPercentage + '%';
                detailBbmAkhirBar.setAttribute('aria-valuenow', bbmAkhir);
                detailBbmAkhirValue.textContent = bbmAkhir + '/8';

                // Ubah warna bar BBM Akhir
                if (bbmAkhir >= 6) {
                    detailBbmAkhirBar.classList.remove('bg-warning', 'bg-danger');
                    detailBbmAkhirBar.classList.add('bg-success');
                } else if (bbmAkhir >= 3) {
                    detailBbmAkhirBar.classList.remove('bg-success', 'bg-danger');
                    detailBbmAkhirBar.classList.add('bg-warning');
                } else {
                    detailBbmAkhirBar.classList.remove('bg-success', 'bg-warning');
                    detailBbmAkhirBar.classList.add('bg-danger');
                }
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update URL untuk tombol cetak PDF
        const table = $('#historyTable').DataTable({
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
            const url = `{{ route('cetak.pdf', ['role' => 'Driver']) }}?${params}`;
            window.open(url, '_blank');
        });
    });

     // Reset pencarian
        const resetSearchButton = document.getElementById('resetSearch');
        resetSearchButton.addEventListener('click', function() {
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            window.location.href = '{{ route('driver.history') }}';
        });
    
</script>



@endsection