@section('title', 'Tambah Perjalanan | Driver')
@extends('layouts.sidebardriver')

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
                    <h3 class="fw-bold mb-3">Pemakaian Kendaraan</h3>
                    <h6 class="op-7 mb-2">Pemakaian Kendaraan</h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Pemakaian Kendaraan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('storePerjalanan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama Pengemudi</label>
                                        <input type="text" class="form-control" placeholder="Nama Pengemudi"
                                            value="{{ Auth::user()->nama }}" required readonly>
                                        <input type="hidden" id='pengemudi_id' name="pengemudi_id"
                                            value="{{ Auth::user()->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama Pegawai</label>
                                        <select class="js-example-basic-multiple form-control" name="nama_pegawai[]"
                                            multiple="multiple" required style="width: 100%;">
                                            @foreach ($pegawaiList as $pegawai)
                                                <option value="{{ $pegawai->nama }}">{{ $pegawai->nama }}</option>
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
                                        <label>Titik Akhir</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="titik_akhir" name="titik_akhir"
                                                placeholder="Titik Akhir" required>
                                            <button type="button" id="toggleMapBtn"
                                                class="btn btn-outline-secondary btn-sm" title="Buka Peta Interaktif"
                                                data-bs-toggle="modal" data-bs-target="#mapModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                                </svg>
                                                Peta
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Peta -->
                                <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi dari Peta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <button type="button" class="btn btn-info btn-sm mb-1"
                                                        onclick="setTargetInput('titik_awal')">Set Titik Awal</button>
                                                    <button type="button" class="btn btn-info btn-sm mb-1"
                                                        onclick="setTargetInput('titik_akhir')">Set Titik Akhir</button>
                                                    <small class="form-text text-muted d-block">Klik tombol di atas, lalu
                                                        klik pada peta atau geser marker untuk memilih lokasi.</small>
                                                </div>
                                                <div id="map" style="height: 450px; width: 100%;"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Selesai & Tutup Peta</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Peta -->

                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Estimasi Jarak (KM)</label>
                                        <input type="text" class="form-control" id="estimasi_jarak" name="estimasi_jarak"
                                            placeholder="Estimasi Jarak" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Tujuan Perjalanan</label>
                                        <input type="text" class="form-control" name="tujuan_perjalanan"
                                            placeholder="Tujuan Perjalanan" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Tipe Kendaraan</label>
                                        <select class="form-select" name="kendaraan_id" required>
                                            <option value="" disabled selected>Pilih kendaraan</option>
                                            @foreach ($kendaraan as $k)
                                                <option value="{{ $k->id }}">
                                                    {{ $k->tipe_kendaraan }} {{ $k->no_kendaraan }} <span
                                                        class="status-badge">{!! $k->status_display !!}</span>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label for="bbm_awal">BBM Awal</label>
                                        <div class="progress" style="height: 25px;">
                                            <div id="bbm-awal-bar"
                                                class="progress-bar bg-success d-flex align-items-center justify-content-center"
                                                role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="8">
                                                <span id="bbm-awal-value">0/8</span>
                                            </div>
                                        </div>
                                        <input type="range" class="form-range" id="bbm_awal" name="bbm_awal"
                                            min="0" max="8" value="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Foto KM & BBM Awal</label>
                                        <input type="file" class="form-control" name="foto_awal" accept="image/*"
                                            required />
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
                                <button type="submit" class="btn btn-primary">Tambah Perjalanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Data berhasil ditambahkan!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{-- Display custom session error --}}
                    @if (session('error'))
                        {{ session('error') }}
                    @endif

                    {{-- Display validation errors --}}
                    @if ($errors->any())
                        <ul class="mb-0" style="padding-left: 1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                const toastEl = document.getElementById('successToast');
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            @endif

            // Show error toast if there are any errors
            @if ($errors->any() || session('error'))
                const errorToastEl = document.getElementById('errorToast');
                const errorToast = new bootstrap.Toast(errorToastEl);
                errorToast.show();
            @endif
        });
    </script>




    {{-- Script untuk inisialisasi dan fungsi-fungsi --}}
    <script>
        // let awalAutocomplete;
        let akhirAutocomplete;
        let typingTimer;
        const doneTypingInterval = 500;
        let autocompleteSessionToken;
        let map;
        let marker;
        let geocoder;
        let targetInputElementId = null; // Variabel untuk menyimpan ID input yang akan diisi
        let distanceMatrixService; // <- Deklarasi global
        let awalInput; // <- Deklarasi global
        let akhirInput; // <- Deklarasi global

        function setTargetInput(inputId) {
            targetInputElementId = inputId;
            const inputField = document.getElementById(inputId);
            if (inputField) {
                inputField.focus();
                // Optionally, provide visual feedback that this input is now targeted
                // For example, by adding a class or changing its style briefly.
                console.log("Target input set to: " + inputId);
            } else {
                console.error("Element input dengan ID " + inputId + " tidak ditemukan.");
            }
        }

        function loadGoogleMapsAPI() {
            console.log("LOAD_MAPS: Attempting to load Google Maps API...");
            if (window.google && window.google.maps && window.google.maps.places) {
                console.log("LOAD_MAPS: Google Maps API (including Places) already loaded. Initializing map directly.");
                initMap();
                return;
            }

            const apiKey = "{{ config('services.google.maps_api_key') }}";
            console.log("LOAD_MAPS: Using API Key - Present:", !!apiKey, "Length:", apiKey ? apiKey.length : 0);

            if (!apiKey) {
                console.error(
                    "LOAD_MAPS: Google Maps API Key is MISSING or EMPTY. Please check your .env and config/services.php file."
                );
                alert(
                    "PENTING: Kunci API Google Maps tidak ditemukan. Fitur peta dan pencarian alamat tidak akan berfungsi."
                );
                return;
            }

            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places,geocoding&callback=initMap`;
            script.defer = true;
            script.async = true;
            script.onload = function() {
                console.log(
                    "LOAD_MAPS: Google Maps API script loaded successfully via onload. initMap should be called by callback."
                );
            };
            script.onerror = () => {
                console.error(
                    "LOAD_MAPS: CRITICAL - Failed to load Google Maps API script! Check API Key, Quotas, Billing, and API Restrictions in Google Cloud Console. Also check network connectivity."
                );
                alert(
                    "KESALAHAN KRITIS: Gagal memuat skrip Google Maps. Pastikan kunci API valid, tidak ada masalah kuota/tagihan, dan periksa pembatasan API di Google Cloud Console. Fitur peta tidak akan berfungsi."
                );
            };
            document.head.appendChild(script);
            console.log("LOAD_MAPS: Google Maps API script appended to head. Waiting for callback or onload.");
        }

        function initMap() {
            console.log("INIT_MAP: initMap function CALLED.");

            if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                console.error(
                    "INIT_MAP: FATAL - google.maps object is NOT AVAILABLE. Aborting map initialization. This usually means the API script failed to load or there was an issue with the API key/billing/restrictions."
                );
                return;
            }
            console.log("INIT_MAP: google.maps object is AVAILABLE.");

            const mapElement = document.getElementById('map');
            if (!mapElement) {
                console.error("INIT_MAP: FATAL - Map element with ID 'map' NOT FOUND in the DOM. Cannot create map.");
                return;
            }
            console.log("INIT_MAP: Map element #map FOUND.");

            const initialLat = -5.423720;
            const initialLng = 105.259910;

            try {
                map = new google.maps.Map(mapElement, {
                    center: {
                        lat: initialLat,
                        lng: initialLng
                    },
                    zoom: 13,
                    // Menambahkan beberapa opsi dasar untuk memastikan peta tidak kosong jika ada masalah style
                    streetViewControl: false,
                    mapTypeControl: false
                });
                console.log("INIT_MAP: Map object CREATED successfully.");
            } catch (e) {
                console.error("INIT_MAP: FATAL - Error CREATING map object:", e);
                alert("Terjadi kesalahan saat membuat objek peta: " + e.message);
                return;
            }

            try {
                geocoder = new google.maps.Geocoder();
                console.log("INIT_MAP: Geocoder INITIALIZED.");
            } catch (e) {
                console.error("INIT_MAP: Error initializing Geocoder:", e);
            }


            try {
                marker = new google.maps.Marker({
                    position: {
                        lat: initialLat,
                        lng: initialLng
                    },
                    map: map,
                    draggable: true
                });
                console.log("INIT_MAP: Marker CREATED and added to map.");
            } catch (e) {
                console.error("INIT_MAP: Error CREATING marker:", e);
            }

            if (map && marker) { // Pastikan map dan marker berhasil dibuat
                map.addListener('click', (event) => {
                    placeMarkerAndPanTo(event.latLng, map);
                    geocodePosition(event.latLng);
                });
                marker.addListener('dragend', () => {
                    geocodePosition(marker.getPosition());
                });
                console.log("INIT_MAP: Map and marker LISTENERS ADDED.");
            } else {
                console.warn("INIT_MAP: Map or Marker object is missing. Listeners NOT added.");
            }

            awalInput = document.getElementById('titik_awal');
            akhirInput = document.getElementById('titik_akhir');
            console.log("INIT_MAP: Titik awal input element:", awalInput ? "Found" : "NOT Found");
            console.log("INIT_MAP: Titik akhir input element:", akhirInput ? "Found" : "NOT Found");

            if (typeof google.maps.places === 'undefined') {
                console.error("INIT_MAP: FATAL - Google Maps PLACES library is NOT AVAILABLE. Autocomplete will NOT work.");
            } else {
                console.log("INIT_MAP: Google Maps PLACES library is AVAILABLE.");
                if (akhirInput) {
                    try {
                        autocompleteSessionToken = new google.maps.places.AutocompleteSessionToken();
                        akhirAutocomplete = new google.maps.places.Autocomplete(akhirInput, {
                            types: ['establishment'], // Anda bisa sesuaikan tipe tempat jika perlu
                            componentRestrictions: {
                                country: 'id'
                            },
                            fields: ["address_components", "geometry", "icon", "name",
                                "formatted_address"
                            ], // Minta field spesifik
                            sessionToken: autocompleteSessionToken
                        });
                        console.log("INIT_MAP: Autocomplete for titik_akhir INITIALIZED.");

                        akhirAutocomplete.addListener('place_changed', async () => {
                            console.log("INIT_MAP: Autocomplete - place_changed event for titik_akhir.");
                            const place = akhirAutocomplete.getPlace();
                            if (place && place.geometry && place.geometry.location) {
                                console.log("INIT_MAP: Autocomplete - Place data received:", place
                                    .formatted_address);
                                if (map && marker) {
                                    map.panTo(place.geometry.location);
                                    marker.setPosition(place.geometry.location);
                                }
                                await hitungJarak();
                            } else {
                                console.warn(
                                    "INIT_MAP: Autocomplete - place_changed event but no valid place.geometry.location. Input was:",
                                    akhirInput.value);
                                geocodeAddress(akhirInput.value, 'titik_akhir');
                            }
                        });

                        akhirInput.addEventListener('input', () => {
                            clearTimeout(typingTimer);
                            typingTimer = setTimeout(() => {
                                autocompleteSessionToken = new google.maps.places
                                    .AutocompleteSessionToken();
                                if (akhirAutocomplete) {
                                    akhirAutocomplete.sessionToken = autocompleteSessionToken;
                                }
                                // console.log('New session token created for titik_akhir autocomplete.');
                            }, doneTypingInterval);
                        });
                        console.log("INIT_MAP: Listeners for titik_akhir autocomplete ADDED.");
                    } catch (e) {
                        console.error("INIT_MAP: Error initializing Autocomplete for titik_akhir:", e);
                        alert("Terjadi kesalahan saat menginisialisasi fitur autocomplete alamat: " + e.message);
                    }
                } else {
                    console.warn("INIT_MAP: Elemen input titik_akhir TIDAK DITEMUKAN, Autocomplete tidak diinisialisasi.");
                }
            }

            try {
                distanceMatrixService = new google.maps.DistanceMatrixService();
                console.log("INIT_MAP: DistanceMatrixService INITIALIZED.");
            } catch (e) {
                console.error("INIT_MAP: Error initializing DistanceMatrixService:", e);
            }
            console.log("INIT_MAP: initMap function FINISHED.");
        }

        async function hitungJarak() { // <- Fungsi sekarang global
            if (!awalInput || !akhirInput) {
                console.error("hitungJarak: Elemen input awal atau akhir tidak ditemukan.");
                document.getElementById('estimasi_jarak').value = "";
                return;
            }
            const origin = awalInput.value;
            const destination = akhirInput.value;

            if (!origin || !destination) {
                document.getElementById('estimasi_jarak').value = "";
                console.log("hitungJarak: Origin atau destination kosong.");
                return;
            }

            console.log(`hitungJarak dipanggil dengan origin: ${origin}, destination: ${destination}`);


            if (!distanceMatrixService) {
                console.error("DistanceMatrixService belum diinisialisasi.");
                return;
            }

            try {
                const response = await new Promise((resolve, reject) => {
                    distanceMatrixService.getDistanceMatrix({
                        origins: [origin],
                        destinations: [destination],
                        travelMode: google.maps.TravelMode.DRIVING,
                        unitSystem: google.maps.UnitSystem.METRIC
                    }, (response, status) => {
                        if (status === "OK") {
                            resolve(response);
                        } else {
                            console.error("Error calculating distance:", status, response);
                            // alert("Terjadi kesalahan saat menghitung jarak: " + status);
                            document.getElementById("estimasi_jarak").value = "Error";
                            reject(status);
                        }
                    });
                });

                if (response.rows[0].elements[0].status === "OK") {
                    const distanceString = response.rows[0].elements[0].distance.text;
                    const distanceValue = parseFloat(distanceString.replace(/[^0-9.]/g, ''));
                    document.getElementById("estimasi_jarak").value = distanceValue;
                    console.log("Estimasi jarak dihitung: " + distanceValue);
                } else {
                    console.warn("Element status bukan OK:", response.rows[0].elements[0].status);
                    document.getElementById("estimasi_jarak").value = "Tidak ditemukan";
                }
            } catch (error) {
                console.error("Error dalam hitungJarak:", error);
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
                if (status === google.maps.GeocoderStatus.OK) {
                    if (responses && responses.length > 0) {
                        let idToUpdate = targetInputElementId;

                        if (!idToUpdate) {
                            console.log(
                                "Tidak ada target input eksplisit yang dipilih. Menggunakan 'titik_akhir' sebagai default untuk pembaruan dari interaksi peta ini."
                            );
                            idToUpdate = 'titik_akhir';
                        }

                        const inputElement = document.getElementById(idToUpdate);
                        if (inputElement) {
                            inputElement.value = responses[0].formatted_address;

                            if (document.getElementById('titik_awal').value && document.getElementById(
                                    'titik_akhir').value) {
                                hitungJarak();
                            }
                        } else {
                            console.error("Elemen input dengan ID '" + idToUpdate + "' tidak ditemukan.");
                        }
                    } else {
                        alert('Geocoder tidak menemukan alamat untuk posisi yang dipilih.');
                    }
                } else {
                    alert('Geocoder gagal: ' + status);
                }
            });
        }

        // Fungsi baru untuk geocode alamat dari input text (misalnya setelah Enter di autocomplete)
        async function geocodeAddress(address, inputId) {
            geocoder.geocode({
                'address': address,
                'componentRestrictions': {
                    'country': 'id'
                }
            }, (results, status) => {
                if (status === 'OK') {
                    map.panTo(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    document.getElementById(inputId).value = results[0].formatted_address; // Update input field
                    if (document.getElementById('titik_awal').value && document.getElementById('titik_akhir')
                        .value) {
                        hitungJarak(); // Hitung jarak
                    }
                } else {
                    // alert('Geocode tidak berhasil karena: ' + status);
                    console.warn('Geocode tidak berhasil karena: ' + status + ' untuk alamat: ' + address);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM_LOADED: DOMContentLoaded event fired.");
            loadGoogleMapsAPI(); // Ini akan memanggil initMap pada akhirnya

            const mapModalElement = document.getElementById('mapModal');
            if (mapModalElement) {
                mapModalElement.addEventListener('shown.bs.modal', function() {
                    if (map) { // Pastikan objek peta sudah diinisialisasi
                        google.maps.event.trigger(map, "resize");
                        const currentMarkerPos = marker ? marker.getPosition() : null;
                        const centerPos = currentMarkerPos || {
                            lat: -5.423720,
                            lng: 105.259910
                        }; // Default center
                        map.setCenter(centerPos);

                        // Atur zoom. Jika peta baru pertama kali dibuka (tidak ada posisi marker sebelumnya),
                        // gunakan zoom default. Jika sudah ada interaksi, biarkan zoom yang mungkin sudah disesuaikan pengguna,
                        // atau set ke level zoom yang lebih dekat.
                        if (!currentMarkerPos || (map.getZoom() <
                                7)) { // Zoom default jika marker belum ada atau zoom terlalu jauh
                            map.setZoom(13);
                        }
                        // else {
                        // Anda bisa menambahkan logika zoom spesifik di sini jika marker sudah ada
                        // map.setZoom(15); // contoh
                        // }
                    }
                });
            }
        });
    </script>

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

                // Ubah warna bar berdasarkan value
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
        });
    </script>

    <style>
        #successToast {
            animation: fadeInUp 0.5s ease, fadeOutDown 0.5s ease 3.5s forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOutDown {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(50px);
            }
        }
    </style>

    @push('scripts')
        {{-- Hapus jQuery CDN, asumsikan sudah ada di layout --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Gunakan inisialisasi Select2 paling dasar
                $('.js-example-basic-multiple').select2();
            });
        </script>
    @endpush
@endsection
