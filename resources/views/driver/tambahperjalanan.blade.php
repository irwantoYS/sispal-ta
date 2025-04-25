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
                                        <input type="text" class="form-control" id="titik_akhir" name="titik_akhir"
                                            placeholder="Titik Akhir" required>
                                    </div>
                                </div>

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
                                                role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="8">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                const toastEl = document.getElementById('successToast');
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            @endif
        });
    </script>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <ul id="error-messages">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
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

        function initMap() {
            const awalInput = document.getElementById('titik_awal');
            const akhirInput = document.getElementById('titik_akhir');

            if (!awalInput || !akhirInput) {
                console.error("Elemen input tidak ditemukan!");
                return;
            }

            // Inisialisasi Autocomplete dengan session token
            autocompleteSessionToken = new google.maps.places.AutocompleteSessionToken();

            // awalAutocomplete = new google.maps.places.Autocomplete(awalInput, {
            //     types: ['establishment'],
            //     componentRestrictions: {
            //         country: 'id'
            //     },
            //     sessionToken: autocompleteSessionToken
            // });

            akhirAutocomplete = new google.maps.places.Autocomplete(akhirInput, {
                types: ['establishment'],
                componentRestrictions: {
                    country: 'id'
                },
                sessionToken: autocompleteSessionToken
            });

            const distanceMatrixService = new google.maps.DistanceMatrixService();

            // Handle event 'input' dengan debouncing
            // awalInput.addEventListener('input', () => {
            //     clearTimeout(typingTimer);
            //     typingTimer = setTimeout(() => {
            //         // Reset session token untuk awalInput setiap kali pengguna mulai mengetik
            //         autocompleteSessionToken = new google.maps.places.AutocompleteSessionToken();
            //         awalAutocomplete.sessionToken = autocompleteSessionToken;
            //         console.log('Session token baru dibuat untuk titik awal');
            //     }, doneTypingInterval);
            // });

            akhirInput.addEventListener('input', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    // Reset session token untuk akhirInput setiap kali pengguna mulai mengetik
                    autocompleteSessionToken = new google.maps.places.AutocompleteSessionToken();
                    akhirAutocomplete.sessionToken = autocompleteSessionToken;
                    console.log('Session token baru dibuat untuk titik akhir');
                }, doneTypingInterval);
            });

            // // Listener 'place_changed' untuk menghitung jarak
            // awalAutocomplete.addListener('place_changed', async () => {
            //     console.log("Place changed - titik awal");
            //     await hitungJarak(); // Menunggu hitungJarak() selesai
            //     console.log("Jarak dihitung - titik awal");
            // });

            akhirAutocomplete.addListener('place_changed', async () => {
                console.log("Place changed - titik akhir");
                await hitungJarak(); // Menunggu hitungJarak() selesai
                console.log("Jarak dihitung - titik akhir");
            });

            async function hitungJarak() {
                const origin = awalInput.value;
                const destination = akhirInput.value;

                if (!origin || !destination) {
                    document.getElementById('estimasi_jarak').value = "";
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
                                console.error("Error calculating distance:", status);
                                alert("Terjadi kesalahan saat menghitung jarak: " + status);
                                document.getElementById("estimasi_jarak").value = "";
                                reject(status);
                            }
                        });
                    });

                    const distanceString = response.rows[0].elements[0].distance.text; // Ambil string, contoh "11.9 km"
                    const distanceValue = parseFloat(distanceString.replace(/[^0-9.]/g,
                        '')); // Hapus " km", konversi ke float
                    document.getElementById("estimasi_jarak").value = distanceValue; // Simpan hanya angka
                } catch (error) {
                    console.error("Error:", error);
                }
            }
        }

        function loadGoogleMapsAPI() {
            if (window.google && window.google.maps) {
                initMap();
                return;
            }

            const apiKey = "{{ config('services.google.maps_api_key') }}";

            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places,geocoding&callback=initMap`;
            script.defer = true;
            script.async = true;
            script.onerror = () => {
                console.error("Gagal memuat Google Maps API!");
            };
            document.head.appendChild(script);
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadGoogleMapsAPI();
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
