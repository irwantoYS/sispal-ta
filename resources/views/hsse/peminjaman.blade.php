@section('title', 'Peminjaman Kendaraan | HSSE')
@extends('layouts.sidebarhsse')

@push('styles')
    {{-- Tambahkan CSS Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Peminjaman Kendaraan oleh Pengguna</h3>
                    <h6 class="op-7 mb-2">Catat penggunaan kendaraan operasional oleh pengguna non-driver</h6>
                </div>
            </div>

            {{-- Form Peminjaman --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Peminjaman Kendaraan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('hsse.peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Nama Pengguna</label>
                                    <select class="form-select select2-multiple" name="pegawai_id[]" multiple="multiple"
                                        required style="width: 100%;">
                                        @foreach ($pegawaiList as $pegawai)
                                            <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Kendaraan Tersedia</label>
                                    <select class="form-select" name="kendaraan_id" required>
                                        <option value="" disabled selected>Pilih kendaraan</option>
                                        @foreach ($kendaraanTersedia as $k)
                                            <option value="{{ $k->id }}">
                                                {{ $k->tipe_kendaraan }} {{ $k->no_kendaraan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Titik Awal</label>
                                    <input type="text" class="form-control" id="titik_awal" name="titik_awal"
                                        value="35125, Jl. Sam Ratulangi No.15, Penengahan, Kec. Tj. Karang Pusat, Kota Bandar Lampung, Lampung 35126"
                                        required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Titik Akhir (Tujuan)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="titik_akhir" name="titik_akhir"
                                            placeholder="Ketik atau pilih dari peta" required>
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#mapModal">
                                            <i class="fas fa-map-marker-alt"></i> Peta
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Estimasi Jarak (KM)</label>
                                    <input type="text" class="form-control" id="estimasi_jarak" name="estimasi_jarak"
                                        placeholder="Terisi otomatis" readonly required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>KM Awal Manual</label>
                                    <input type="number" class="form-control" name="km_awal_manual"
                                        placeholder="Masukkan KM Awal Kendaraan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Tujuan Perjalanan</label>
                                    <input type="text" class="form-control" name="tujuan_perjalanan"
                                        placeholder="Contoh: Mengantar dokumen ke klien" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label for="bbm_awal">BBM Awal</label>
                                    <div class="progress" style="height: 25px;">
                                        <div id="bbm-awal-bar"
                                            class="progress-bar bg-success d-flex align-items-center justify-content-center"
                                            role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="8">
                                            <span id="bbm-awal-value">0/8</span>
                                        </div>
                                    </div>
                                    <input type="range" class="form-range" id="bbm_awal" name="bbm_awal" min="0"
                                        max="8" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Foto KM & BBM Awal</label>
                                    <input type="file" class="form-control" name="foto_awal" accept="image/*" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Jam Pergi</label>
                                    <input type="datetime-local" class="form-control" name="jam_pergi"
                                        value="{{ now()->format('Y-m-d\TH:i') }}" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Catat Peminjaman</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Daftar Peminjaman Aktif --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Daftar Peminjaman Aktif</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Kendaraan</th>
                                    <th>Tujuan</th>
                                    <th>Waktu Pinjam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjamanAktif as $key => $peminjaman)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ is_array(json_decode($peminjaman->nama_pegawai)) ? implode(', ', json_decode($peminjaman->nama_pegawai)) : $peminjaman->nama_pegawai }}
                                        </td>
                                        <td>{{ $peminjaman->kendaraan->tipe_kendaraan }}
                                            ({{ $peminjaman->kendaraan->no_kendaraan }})
                                        </td>
                                        <td>{{ $peminjaman->tujuan_perjalanan }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->jam_pergi)->format('d M Y, H:i') }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#completePeminjamanModal-{{ $peminjaman->id }}">
                                                Selesaikan
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada kendaraan yang sedang dipinjam.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Peta -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi dari Peta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <small class="form-text text-muted d-block">Klik pada peta atau geser marker untuk memilih lokasi
                            tujuan.</small>
                    </div>
                    <div id="map" style="height: 450px; width: 100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk setiap peminjaman --}}
    @foreach ($peminjamanAktif as $peminjaman)
        <div class="modal fade" id="completePeminjamanModal-{{ $peminjaman->id }}" tabindex="-1"
            aria-labelledby="completeModalLabel-{{ $peminjaman->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="completeModalLabel-{{ $peminjaman->id }}">Selesaikan Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hsse.peminjaman.complete', $peminjaman->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>KM Awal Manual</label>
                                <input type="number" class="form-control" value="{{ $peminjaman->km_awal_manual }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="km_akhir_manual-{{ $peminjaman->id }}" class="form-label">KM Akhir
                                    Manual</label>
                                <input type="number" class="form-control" id="km_akhir_manual-{{ $peminjaman->id }}"
                                    name="km_akhir_manual" placeholder="Masukkan KM Akhir Kendaraan" required>
                            </div>
                            <div class="mb-3">
                                <label for="bbm_akhir-{{ $peminjaman->id }}" class="form-label">BBM Akhir</label>
                                <div class="progress" style="height: 25px;">
                                    <div id="bbm-akhir-bar-{{ $peminjaman->id }}" class="progress-bar bg-success"
                                        role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                        aria-valuemax="8">
                                        <span id="bbm-akhir-value-{{ $peminjaman->id }}">0/8</span>
                                    </div>
                                </div>
                                <input type="range" class="form-range" id="bbm_akhir-{{ $peminjaman->id }}"
                                    name="bbm_akhir" min="0" max="8" value="0" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_bbm-{{ $peminjaman->id }}" class="form-label">Jenis BBM</label>
                                <select class="form-select" id="jenis_bbm-{{ $peminjaman->id }}" name="jenis_bbm"
                                    required>
                                    <option value="" disabled selected>Pilih Jenis BBM</option>
                                    <option value="Solar">Solar</option>
                                    <option value="Pertalite">Pertalite</option>
                                    <option value="Pertamax">Pertamax</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="foto_akhir-{{ $peminjaman->id }}" class="form-label">Foto KM & BBM
                                    Akhir</label>
                                <input type="file" class="form-control" id="foto_akhir-{{ $peminjaman->id }}"
                                    name="foto_akhir" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="jam_kembali-{{ $peminjaman->id }}" class="form-label">Jam Kembali</label>
                                <input type="datetime-local" class="form-control" id="jam_kembali-{{ $peminjaman->id }}"
                                    name="jam_kembali" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan & Selesaikan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    {{-- Script untuk Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih pengguna atau ketik nama',
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });
    </script>

    {{-- Script untuk Leaflet (Peta) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    {{-- script untuk visualisasi BBM AWAL --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bbmAwalInput = document.getElementById('bbm_awal');
            const bbmAwalBar = document.getElementById('bbm-awal-bar');
            const bbmAwalValue = document.getElementById('bbm-awal-value');

            bbmAwalInput.addEventListener('input', function() {
                const value = this.value;
                const percentage = (value / 8) * 100;

                bbmAwalBar.style.width = percentage + '%';
                bbmAwalBar.setAttribute('aria-valuenow', value);
                bbmAwalValue.textContent = value + '/8';

                if (value >= 6) {
                    bbmAwalBar.classList.remove('bg-warning', 'bg-danger');
                    bbmAwalBar.classList.add('bg-success');
                } else if (value >= 3) {
                    bbmAwalBar.classList.remove('bg-success', 'bg-danger');
                    bbmAwalBar.classList.add('bg-warning');
                } else {
                    bbmAwalBar.classList.remove('bg-success', 'bg-warning');
                    bbmAwalBar.classList.add('bg-danger');
                }
            });
            // Inisialisasi tampilan awal
            bbmAwalInput.dispatchEvent(new Event('input'));
        });
    </script>

    {{-- script untuk visualisasi BBM AKHIR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($peminjamanAktif as $peminjaman)
                const bbmAkhirInput_{{ $peminjaman->id }} = document.getElementById(
                    'bbm_akhir-{{ $peminjaman->id }}');
                const bbmAkhirBar_{{ $peminjaman->id }} = document.getElementById(
                    'bbm-akhir-bar-{{ $peminjaman->id }}');
                const bbmAkhirValue_{{ $peminjaman->id }} = document.getElementById(
                    'bbm-akhir-value-{{ $peminjaman->id }}');

                bbmAkhirInput_{{ $peminjaman->id }}.addEventListener('input', function() {
                    const value = this.value;
                    const percentage = (value / 8) * 100;

                    bbmAkhirBar_{{ $peminjaman->id }}.style.width = percentage + '%';
                    bbmAkhirBar_{{ $peminjaman->id }}.setAttribute('aria-valuenow', value);
                    bbmAkhirValue_{{ $peminjaman->id }}.textContent = value + '/8';

                    if (value >= 6) {
                        bbmAkhirBar_{{ $peminjaman->id }}.classList.remove('bg-warning', 'bg-danger').add(
                            'bg-success');
                    } else if (value >= 3) {
                        bbmAkhirBar_{{ $peminjaman->id }}.classList.remove('bg-success', 'bg-danger').add(
                            'bg-warning');
                    } else {
                        bbmAkhirBar_{{ $peminjaman->id }}.classList.remove('bg-success', 'bg-warning').add(
                            'bg-danger');
                    }
                });
            @endforeach
        });
    </script>

    {{-- Script Google Maps --}}
    <script>
        let akhirAutocomplete;
        let map;
        let marker;
        let geocoder;
        let distanceMatrixService;
        let awalInput;
        let akhirInput;

        function loadGoogleMapsAPI() {
            if (typeof google !== 'undefined' && google.maps) {
                initMap();
                return;
            }
            const apiKey = "{{ config('services.google.maps_api_key') }}";
            if (!apiKey) {
                console.error("Google Maps API Key is MISSING.");
                alert("Kunci API Google Maps tidak ditemukan. Fitur peta tidak akan berfungsi.");
                return;
            }
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places,geocoding&callback=initMap`;
            script.defer = true;
            script.async = true;
            document.head.appendChild(script);
        }

        function initMap() {
            const initialLat = -5.423720;
            const initialLng = 105.259910;

            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: initialLat,
                    lng: initialLng
                },
                zoom: 13
            });

            geocoder = new google.maps.Geocoder();
            distanceMatrixService = new google.maps.DistanceMatrixService();

            marker = new google.maps.Marker({
                position: {
                    lat: initialLat,
                    lng: initialLng
                },
                map: map,
                draggable: true
            });

            map.addListener('click', (event) => {
                placeMarkerAndPanTo(event.latLng, map);
                geocodePosition(event.latLng);
            });
            marker.addListener('dragend', () => geocodePosition(marker.getPosition()));

            awalInput = document.getElementById('titik_awal');
            akhirInput = document.getElementById('titik_akhir');

            akhirAutocomplete = new google.maps.places.Autocomplete(akhirInput, {
                componentRestrictions: {
                    country: 'id'
                },
                fields: ["formatted_address", "geometry"],
            });

            akhirAutocomplete.addListener('place_changed', () => {
                const place = akhirAutocomplete.getPlace();
                if (place && place.geometry && place.geometry.location) {
                    map.panTo(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                    hitungJarak();
                }
            });
        }

        async function hitungJarak() {
            const origin = awalInput.value;
            const destination = akhirInput.value;
            if (!origin || !destination) return;

            try {
                const response = await new Promise((resolve, reject) => {
                    distanceMatrixService.getDistanceMatrix({
                        origins: [origin],
                        destinations: [destination],
                        travelMode: google.maps.TravelMode.DRIVING,
                        unitSystem: google.maps.UnitSystem.METRIC
                    }, (response, status) => {
                        if (status === "OK") resolve(response);
                        else reject(status);
                    });
                });

                if (response.rows[0].elements[0].status === "OK") {
                    const distanceText = response.rows[0].elements[0].distance.text;
                    const distanceValue = parseFloat(distanceText.replace(/[^0-9,.]/g, '').replace(',', '.'));
                    document.getElementById("estimasi_jarak").value = distanceValue.toFixed(2);
                } else {
                    document.getElementById("estimasi_jarak").value = "Tidak ditemukan";
                }
            } catch (error) {
                console.error("Error menghitung jarak:", error);
                document.getElementById("estimasi_jarak").value = "Error";
            }
        }

        function placeMarkerAndPanTo(latLng, map) {
            marker.setPosition(latLng);
            map.panTo(latLng);
        }

        function geocodePosition(pos) {
            geocoder.geocode({
                latLng: pos
            }, (responses, status) => {
                if (status === google.maps.GeocoderStatus.OK && responses && responses.length > 0) {
                    akhirInput.value = responses[0].formatted_address;
                    hitungJarak();
                } else {
                    alert('Geocoder gagal: ' + status);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadGoogleMapsAPI();
            const mapModalElement = document.getElementById('mapModal');
            if (mapModalElement) {
                mapModalElement.addEventListener('shown.bs.modal', function() {
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(marker.getPosition());
                });
            }
        });
    </script>
@endpush
