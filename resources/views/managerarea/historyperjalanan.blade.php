@section('title', 'History | Manager Area')
@extends('layouts.sidebarma')
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

                    <div class="card-header d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <label for="startDate" class="form-label fw-bold">Cari berdasarkan tanggal awal dan
                                akhir:</label>
                            <form action="{{ route('managerarea.history') }}" method="GET"
                                class="d-flex align-items-center">
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

                        <div class="d-flex mt-3 mt-md-0">
                            <button type="button" class="btn btn-primary btn-round me-2" data-bs-toggle="modal"
                                data-bs-target="#driverSummaryModal">
                                <i class="fas fa-chart-bar"></i>
                            </button>

                            <a class="btn btn-success btn-round"
                                href="{{ route('cetak.pdf', ['role' => 'ManagerArea', 'startDate' => request('startDate'), 'endDate' => request('endDate'), 'search' => request('search')]) }}">
                                <i class="fa-solid fa-print"></i>
                            </a>
                            <a class="btn btn-warning btn-round ms-2"
                                href="{{ route('cetak.csv', ['role' => 'ManagerArea', 'startDate' => request('startDate'), 'endDate' => request('endDate'), 'search' => request('search')]) }}">
                                <i class="fa-solid fa-file-csv"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <div class="text-center">
                                <p><strong>Total Seluruh Perjalan {{ $rentangTanggal }}</strong></p>
                            </div>
                            <p><strong>Total Estimasi Jarak:</strong> {{ number_format($totalEstimasiJarak, 2, '.', '') }}
                                KM</p>
                            <p><strong>Total KM Manual:</strong> {{ number_format($totalKmManual, 2, '.', '') }} KM</p>
                            <p><strong>Total Estimasi BBM:</strong> {{ number_format($totalEstimasiBBM, 2, '.', '') }} Liter
                            </p>
                            <p><strong>Total Estimasi Waktu:</strong> {{ $totalDurasiFormat }}</p>
                            <p><strong>Total Perjalanan:</strong> {{ count($perjalanan) }}</p>
                        </div>

                        <div class="table-responsive">
                            <table id="allhistoryTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengemudi</th>
                                        <th>Nama Pengguna</th>
                                        <th>Titik Akhir</th>
                                        <th>Tujuan Perjalanan</th>
                                        <th>Jam Pergi</th>
                                        <th>Jam Kembali</th>
                                        <th>KM & BBM Awal</th>
                                        <th>KM & BBM Akhir</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perjalanan as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if (in_array($item->status, ['dipinjam', 'selesai']))
                                                    <span class="badge bg-secondary">Dipinjamkan</span>
                                                @else
                                                    {{ $item->user->nama }}
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $namaArray = json_decode($item->nama_pegawai);
                                                    if (is_array($namaArray)) {
                                                        echo e(implode(', ', $namaArray));
                                                    } else {
                                                        echo e($item->nama_pegawai);
                                                    }
                                                @endphp
                                            </td>
                                            <td>{{ $item->titik_akhir }}</td>
                                            <td>{{ $item->tujuan_perjalanan }}</td>
                                            <td>{{ $item->jam_pergi }}</td>
                                            <td>{{ $item->jam_kembali }}</td>
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
                                            <td>
                                                <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal"
                                                    data-nama-pengemudi="{{ $item->user->nama }}"
                                                    data-nama-pegawai="{{ e($item->nama_pegawai ?? '') }}"
                                                    data-titik-awal="{{ $item->titik_awal }}"
                                                    data-titik-akhir="{{ $item->titik_akhir }}"
                                                    data-tujuan="{{ $item->tujuan_perjalanan ?? '-' }}"
                                                    data-no-kendaraan="{{ $item->Kendaraan->no_kendaraan ?? '-' }}"
                                                    data-tipe-kendaraan="{{ $item->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                    data-jenis-bbm="{{ $item->jenis_bbm ?? '-' }}"
                                                    data-estimasi-jarak="{{ $item->km_akhir ? number_format((float) $item->km_akhir, 2, ',', '.') . ' KM' : '-' }}"
                                                    data-km-awal-manual="{{ $item->km_awal_manual ? number_format($item->km_awal_manual) . ' KM' : '-' }}"
                                                    data-km-akhir-manual="{{ $item->km_akhir_manual ? number_format($item->km_akhir_manual) . ' KM' : '-' }}"
                                                    data-total-km-manual="{{ $item->total_km_manual ? number_format($item->total_km_manual) . ' KM' : '-' }}"
                                                    data-bbm-awal="{{ $item->bbm_awal ?? '-' }}"
                                                    data-bbm-akhir="{{ $item->bbm_akhir ?? '-' }}"
                                                    data-jam-pergi="{{ $item->jam_pergi }}"
                                                    data-jam-kembali="{{ $item->jam_kembali }}"
                                                    data-estimasi-waktu="{{ $item->estimasi_waktu ?? '-' }}"
                                                    data-estimasi-bbm="{{ $item->estimasi_bbm ?? '-' }}"
                                                    data-validator="{{ $item->validator->nama ?? '-' }}">
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
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Pengemudi</th>
                                    <td id="detailNamaPengemudi"></td>
                                </tr>
                                <tr>
                                    <th>Nama Pengguna</th>
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
                                    <th>Jenis BBM</th>
                                    <td id="detailJenisBbm"></td>
                                </tr>
                                <tr>
                                    <th>Total Estimasi Jarak Tempuh</th>
                                    <td id="detailEstimasiJarak"></td>
                                </tr>
                                <tr>
                                    <th>KM Awal Manual</th>
                                    <td id="detailKmAwalManual"></td>
                                </tr>
                                <tr>
                                    <th>KM Akhir Manual</th>
                                    <td id="detailKmAkhirManual"></td>
                                </tr>
                                <tr>
                                    <th>Total KM Manual</th>
                                    <td id="detailTotalKmManual"></td>
                                </tr>
                                <tr>
                                    <th>BBM Awal</th>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div id="detailBbmAwalBar" class="progress-bar" role="progressbar"
                                                style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="8">
                                                <span id="detailBbmAwalValue">0/8</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>BBM Akhir</th>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div id="detailBbmAkhirBar" class="progress-bar" role="progressbar"
                                                style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="8">
                                                <span id="detailBbmAkhirValue">0/8</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jam Pergi</th>
                                    <td id="detailJamPergi"></td>
                                </tr>
                                <tr>
                                    <th>jam Kembali</th>
                                    <td id="detailJamKembali"></td>
                                </tr>
                                <tr>
                                    <th>Estimasi Waktu</th>
                                    <td id="detailEstimasiWaktu"></td>
                                </tr>
                                <tr>
                                    <th>Estimasi BBM</th>
                                    <td id="detailEstimasiBBM"></td>
                                </tr>
                                <tr>
                                    <th>Divalidasi Oleh</th>
                                    <td id="detailValidator"></td>
                                </tr>
                            </table>
                        </div>
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
                        <h5 class="modal-title" id="fotoModalLabel">Foto KM & BBM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="fotoPreview" src="" alt="Foto Perjalanan" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="driverSummaryModal" tabindex="-1" aria-labelledby="driverSummaryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="driverSummaryModalLabel">Ringkasan Total Perjalanan per Driver</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (isset($driverSummary) && count($driverSummary) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Driver</th>
                                            <th>Jarak ( Manual)</th>
                                            <th>Jarak (Estimasi)</th>
                                            <th>Durasi</th>
                                            <th>Perjalanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($driverSummary as $index => $summary)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $summary->user->nama ?? 'N/A' }}</td>
                                                <td>{{ number_format($summary->total_km_manual, 2, ',', '.') }}</td>
                                                <td>{{ number_format($summary->total_jarak, 2, ',', '.') }}</td>
                                                <td>{{ $summary->total_durasi_format }}</td>
                                                <td>{{ $summary->total_perjalanan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Tidak ada data ringkasan untuk ditampilkan.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Inisialisasi DataTable
                if (window.jQuery) {
                    const table = $('#allhistoryTable').DataTable({
                        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                            "<'row'<'col-sm-12'<'table-responsive'tr>>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "language": {
                            "paginate": {
                                "previous": "<",
                                "next": ">"
                            },
                            "search": "Cari:",
                            "lengthMenu": "Tampilkan _MENU_ data",
                            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                            "infoFiltered": "(disaring dari _MAX_ total data)",
                            "zeroRecords": "Tidak ada data yang cocok ditemukan"
                        }
                    });
                } else {
                    console.error("jQuery is not loaded. DataTable cannot be initialized.");
                }

                // Event delegation untuk klik tombol detail dan foto
                document.addEventListener('click', function(event) {

                    // --- Handle klik tombol foto ---
                    if (event.target.matches('.foto-link')) {
                        const fotoSrc = event.target.getAttribute('data-foto');
                        const fotoPreview = document.getElementById('fotoPreview');
                        if (fotoPreview) {
                            fotoPreview.setAttribute('src', fotoSrc);
                        } else {
                            console.error("Element with ID 'fotoPreview' not found.");
                        }
                    }

                    // --- Handle klik tombol Detail ---
                    if (event.target.matches('.detail-button')) {
                        const button = event.target;
                        // Ambil data dari atribut data-*
                        document.getElementById('detailNamaPengemudi').textContent = button.getAttribute(
                            'data-nama-pengemudi') || '-';

                        // Format Nama Pegawai dari data attribute
                        const namaPegawaiDataEncoded = button.getAttribute('data-nama-pegawai');
                        let namaPegawaiDisplay = '-';
                        if (namaPegawaiDataEncoded) {
                            const textarea = document.createElement('textarea');
                            textarea.innerHTML = namaPegawaiDataEncoded;
                            const namaPegawaiDataDecoded = textarea.value;
                            try {
                                const namaArray = JSON.parse(namaPegawaiDataDecoded);
                                if (Array.isArray(namaArray)) {
                                    namaPegawaiDisplay = namaArray.join(', ');
                                } else {
                                    namaPegawaiDisplay = namaPegawaiDataDecoded;
                                }
                            } catch (e) {
                                namaPegawaiDisplay = namaPegawaiDataDecoded;
                            }
                        }
                        document.getElementById('detailNamaPegawai').textContent = namaPegawaiDisplay;

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
                        document.getElementById('detailJenisBbm').textContent = button.getAttribute(
                            'data-jenis-bbm') || '-';
                        document.getElementById('detailEstimasiJarak').textContent = button.getAttribute(
                            'data-estimasi-jarak') || '-';
                        document.getElementById('detailKmAwalManual').textContent = button.getAttribute(
                            'data-km-awal-manual') || '-';
                        document.getElementById('detailKmAkhirManual').textContent = button.getAttribute(
                            'data-km-akhir-manual') || '-';
                        document.getElementById('detailTotalKmManual').textContent = button.getAttribute(
                            'data-total-km-manual') || '-';
                        document.getElementById('detailJamPergi').textContent = button.getAttribute(
                            'data-jam-pergi') || '-';
                        document.getElementById('detailJamKembali').textContent = button.getAttribute(
                            'data-jam-kembali') || '-';

                        // Tambahkan pengambilan data estimasi
                        let estimasiWaktu = button.getAttribute('data-estimasi-waktu') || '-';
                        let estimasiBBM = button.getAttribute('data-estimasi-bbm') || '-';
                        document.getElementById('detailEstimasiWaktu').textContent = estimasiWaktu;
                        document.getElementById('detailEstimasiBBM').textContent = estimasiBBM !== '-' ?
                            estimasiBBM + ' Liter' : '-';
                        document.getElementById('detailValidator').textContent = button.getAttribute(
                            'data-validator') || '-';

                        // Update progress bar BBM Awal
                        const bbmAwal = button.getAttribute('data-bbm-awal') || 0;
                        const bbmAwalPercentage = (bbmAwal / 8) * 100;
                        const detailBbmAwalBar = document.getElementById('detailBbmAwalBar');
                        const detailBbmAwalValue = document.getElementById('detailBbmAwalValue');

                        if (detailBbmAwalBar && detailBbmAwalValue) {
                            detailBbmAwalBar.style.width = bbmAwalPercentage + '%';
                            detailBbmAwalBar.setAttribute('aria-valuenow', bbmAwal);
                            detailBbmAwalValue.textContent = bbmAwal + '/8';

                            // Ubah warna bar BBM Awal
                            detailBbmAwalBar.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                            if (bbmAwal >= 6) {
                                detailBbmAwalBar.classList.add('bg-success');
                            } else if (bbmAwal >= 3) {
                                detailBbmAwalBar.classList.add('bg-warning');
                            } else {
                                detailBbmAwalBar.classList.add('bg-danger');
                            }
                        }

                        // Update progress bar BBM Akhir
                        const bbmAkhir = button.getAttribute('data-bbm-akhir') || 0;
                        const bbmAkhirPercentage = (bbmAkhir / 8) * 100;
                        const detailBbmAkhirBar = document.getElementById('detailBbmAkhirBar');
                        const detailBbmAkhirValue = document.getElementById('detailBbmAkhirValue');

                        if (detailBbmAkhirBar && detailBbmAkhirValue) {
                            detailBbmAkhirBar.style.width = bbmAkhirPercentage + '%';
                            detailBbmAkhirBar.setAttribute('aria-valuenow', bbmAkhir);
                            detailBbmAkhirValue.textContent = bbmAkhir + '/8';

                            // Ubah warna bar BBM Akhir
                            detailBbmAkhirBar.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                            if (bbmAkhir >= 6) {
                                detailBbmAkhirBar.classList.add('bg-success');
                            } else if (bbmAkhir >= 3) {
                                detailBbmAkhirBar.classList.add('bg-warning');
                            } else {
                                detailBbmAkhirBar.classList.add('bg-danger');
                            }
                        }
                    }
                });

                // Logika pencarian tanggal (jika form submit dikelola oleh JS, jika tidak ini bisa dihapus)
                const dateSearchFormMA = document.querySelector('form[action="{{ route('managerarea.history') }}"]');
                if (dateSearchFormMA) {
                    dateSearchFormMA.addEventListener('submit', function(e) {
                        const startDate = document.querySelector('input[name="startDate"]').value;
                        const endDate = document.querySelector('input[name="endDate"]').value;
                        // Jika ingin validasi sebelum submit atau manipulasi URL
                        // Jika tidak, biarkan form submit biasa
                        if (!startDate || !endDate) {
                            // e.preventDefault(); 
                            // alert('Silakan pilih tanggal awal dan akhir.');
                        }
                    });
                }

                // Reset pencarian tanggal
                const resetSearchButtonMA = document.getElementById('resetSearch');
                if (resetSearchButtonMA) {
                    resetSearchButtonMA.addEventListener('click', function() {
                        const startDateInputMA = document.getElementById('startDate');
                        const endDateInputMA = document.getElementById('endDate');
                        if (startDateInputMA) startDateInputMA.value = '';
                        if (endDateInputMA) endDateInputMA.value = '';
                        window.location.href = '{{ route('managerarea.history') }}';
                    });
                }
            });
        </script>
    @endpush

@endsection
