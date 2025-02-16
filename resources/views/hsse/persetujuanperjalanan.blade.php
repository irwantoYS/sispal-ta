@section('title', 'Persetujuan Perjalanan | HSSE')
@extends('layouts.sidebarhsse')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Persetujuan Perjalanan</h3>
                    <h6 class="op-7 mb-2">Persetujuan Perjalanan</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="persetujuanTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>status</th>
                                        <th>Nama Pengemudi</th>
                                        <th>Nama Pegawai</th>
                                        <th>Titik Awal</th>
                                        <th>Tujuan Perjalanan</th>
                                        <th>Jam Pergi</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($perjalanan as $key => $perjalanan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                            <span class="badge bg-warning text-dark">Menunggu Validasi</span>
                                            </td>
                                            <td>{{ $perjalanan->user->nama }}</td>
                                            <td>{{ $perjalanan->nama_pegawai }}</td>
                                            <td>{{ $perjalanan->titik_awal }}</td>
                                            <td>{{ $perjalanan->tujuan_perjalanan }}</td>
                                            <td>{{ $perjalanan->jam_pergi }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm detail-button" data-bs-toggle="modal"
                                                data-bs-target="#detailModal"
                                                data-nama-pengemudi="{{ $perjalanan->user->nama}}"
                                                data-nama-pegawai="{{ $perjalanan->nama_pegawai}}"
                                                data-titik-awal="{{ $perjalanan->titik_awal }}"
                                                data-titik-awal="{{ $perjalanan->titik_awal }}"
                                                data-titik-akhir="{{ $perjalanan->titik_akhir }}"
                                                data-tujuan="{{ $perjalanan->tujuan_perjalanan }}"
                                                data-no-kendaraan="{{ $perjalanan->Kendaraan->no_kendaraan ?? '-' }}"
                                                data-tipe-kendaraan="{{ $perjalanan->Kendaraan->tipe_kendaraan ?? '-' }}"
                                                data-km-awal="{{ $perjalanan->km_awal }}"
                                                data-km-akhir="{{ $perjalanan->km_akhir }}"
                                                data-bbm-awal="{{ $perjalanan->bbm_awal }}"
                                                data-bbm-akhir="{{ $perjalanan->bbm_akhir }}"
                                                data-jam-pergi="{{ $perjalanan->jam_pergi }}"
                                                data-jam-kembali="{{ $perjalanan->jam_kembali }}">
                                                Lihat Detail
                                                </button>
                                            </td>
                                            {{-- <td>
                                                @if ($perjalanan->status == 'menunggu validasi')
                                                    <div class="d-flex gap-2">
                                                        <!-- Tombol Validasi -->
                                                        <form action="{{ route('perjalanan.validasi', $perjalanan->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm">Validasi</button>
                                                        </form>
                                            
                                                        <!-- Tombol Tolak -->
                                                        <button type="button" class="btn btn-danger btn-sm btn-tolak" 
                                                            data-id="{{ $perjalanan->id }}" 
                                                            data-url="{{ route('perjalanan.tolak', $perjalanan->id) }}"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalAlasan">
                                                            Tolak
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Tidak ada aksi</span>
                                                @endif
                                            </td> --}}
                                            
                                        </tr>
                                    @endforeach

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Tangkap semua tombol dengan class 'btn-tolak'
                                            const tolakButtons = document.querySelectorAll('.btn-tolak');
                                    
                                            tolakButtons.forEach(button => {
                                                button.addEventListener('click', function () {
                                                    // Ambil data dari atribut tombol
                                                    const perjalananId = this.getAttribute('data-id');
                                                    const url = this.getAttribute('data-url');
                                    
                                                    // Set action URL form modal
                                                    const form = document.getElementById('formTolak');
                                                    form.setAttribute('action', url);
                                    
                                                    // Kosongkan alasan setiap kali modal dibuka
                                                    const alasanField = document.getElementById('alasan');
                                                    alasanField.value = '';
                                                });
                                            });
                                        });
                                    </script>
                                    
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Modal untuk Menampilkan Detail -->
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
});
</script>  

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#persetujuanTable').DataTable({
                    "paging": true, // Aktifkan pagination di DataTable
                    "searching": true, // Aktifkan kolom pencarian
                    "ordering": true, // Aktifkan pengurutan kolom
                    "lengthChange": true, // Aktifkan pengaturan jumlah data per halaman
                    "responsive": true, // Menyesuaikan ukuran tabel dengan lebar layar
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
