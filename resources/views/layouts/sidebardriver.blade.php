<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Driver')</title> {{-- Judul dinamis --}}
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('kai/assets/img/kaiadmin/pgncom-logo.png') }}" type="image/x-icon" />


    {{-- Gunakan Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('kai/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kai/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kai/assets/css/kaiadmin.min.css') }}" />

    {{-- CSS Kustom --}}
    <link rel="stylesheet" href="{{ asset('kai/assets/css/custom.css') }}" />

    {{--  Masukkan style ke custom.css  --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ route('driver.dashboard') }}" class="logo">
                        {{-- Gunakan class sidebar-brand --}}
                        <img src="{{ asset('kai/assets/img/kaiadmin/pgncom-logo.png') }}" alt="navbar brand"
                            class="navbar-brand sidebar-brand">
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item {{ Request::is('driver/dashboard') ? 'active' : '' }}">
                            <a href="{{ route('driver.dashboard') }}" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('driver/perjalanan*') ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#perjalanan"
                                class="{{ Request::is('driver/perjalanan*') ? '' : 'collapsed' }}"
                                aria-expanded="{{ Request::is('driver/perjalanan*') ? 'true' : 'false' }}">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <p>Perjalanan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ Request::is('driver/perjalanan*') ? 'show' : '' }}"
                                id="perjalanan">
                                <ul class="nav nav-collapse">
                                    <li class="{{ Request::is('driver/perjalanan/tambah') ? 'active' : '' }}">
                                        <a href="{{ route('driver.perjalanan.tambah') }}">
                                            <span class="sub-item">Tambah Perjalanan</span>
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('driver/perjalanan/status') ? 'active' : '' }}">
                                        <a href="{{ route('driver.perjalanan.status') }}">
                                            <span class="sub-item">Status Perjalanan</span>
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('driver/perjalanan/history') ? 'active' : '' }}">
                                        <a href="{{ route('driver.perjalanan.history') }}">
                                            <span class="sub-item">History Perjalanan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li
                            class="nav-item {{ Request::is('driver/kendaraan*') || Request::is('driver/history_inspeksi*') ? 'active' : '' }}">
                            <a href="{{ route('driver.kendaraan') }}">
                                <i class="fa-solid fa-car-side"></i>
                                <p>Kendaraan</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('driver/dcu*') ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#dcu"
                                class="{{ Request::is('driver/dcu*') ? '' : 'collapsed' }}"
                                aria-expanded="{{ Request::is('driver/dcu*') ? 'true' : 'false' }}">
                                <i class="fa-solid fa-notes-medical"></i>
                                <p>DCU</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ Request::is('driver/dcu*') ? 'show' : '' }}" id="dcu">
                                <ul class="nav nav-collapse">
                                    <li class="{{ Request::is('driver/dcu/create') ? 'active' : '' }}">
                                        <a href="{{ route('driver.dcu.create') }}">
                                            <span class="sub-item">Isi DCU</span>
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('driver/dcu/history') ? 'active' : '' }}">
                                        <a href="{{ route('driver.dcu.history') }}">
                                            <span class="sub-item">Riwayat DCU</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- Main Panel --}}
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        {{--  Perbaiki link di header dan route-nya --}}
                        <a href="{{ route('driver.dashboard') }}" class="logo">
                            <img src="{{ asset('kai/assets/img/kaiadmin/pgncom-logo.png') }}" alt="navbar brand"
                                class="navbar-brand" height="40" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </div>
                </div>

                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="badge bg-danger" id="unread-count"></span> </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">Notifikasi</div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                @auth
                                                    @forelse(auth()->user()->notifications as $notification)
                                                        <a href="{{ route('driver.status', $notification->data['perjalanan_id']) }}"
                                                            class="notif-item @if (!$notification->read_at) fw-bold @endif">
                                                            {{-- Sesuaikan dengan struktur notifikasi Anda --}}
                                                            <div
                                                                class="notif-icon notif-{{ $notification->type == 'perjalanan_baru' ? 'primary' : ($notification->type == 'perjalanan_disetujui' ? 'success' : 'danger') }}">
                                                                <i class="fa-solid fa-envelope"></i>
                                                            </div>
                                                            <div class="notif-content">
                                                                <span class="block">
                                                                    {{ $notification->data['pesan'] }}
                                                                </span>
                                                                <span
                                                                    class="time">{{ $notification->created_at->diffForHumans() }}</span>

                                                                @if (!$notification->read_at)
                                                                    <form
                                                                        action="{{ route('notifications.markAsRead', $notification) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-link mark-as-read-btn">Tandai
                                                                            Sudah
                                                                            Dibaca</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </a>

                                                    @empty
                                                        <p class="text-muted text-center">Tidak ada notifikasi</p>
                                                    @endforelse
                                                @endauth
                                            </div>
                                        </div>
                                    </li>
                                    {{-- <li>
                                        <a class="see-all" href="#">Lihat Semua Notifikasi <i
                                                class="fa fa-angle-right"></i></a>
                                    </li> --}}
                                </ul>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        {{-- Pastikan class img benar --}}
                                        <img src="{{ Auth::user() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('kai/assets/img/default-user.jpg') }}"
                                            alt="..." class="avatar-img rounded-circle">
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold">
                                            {{ Auth::user()->nama }}
                                        </span>
                                    </span>

                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-sm">
                                                    {{-- Pastikan class img benar dan tambahkan ID untuk modal --}}
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#profileModalDriver">
                                                        <img src="{{ Auth::user() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('kai/assets/img/default-user.jpg') }}"
                                                            alt="..." class="avatar-img rounded">
                                                    </a>
                                                </div>
                                                <div class="u-text">
                                                    <h4>{{ Auth::user()->nama }}</h4>
                                                    <p class="text-muted">{{ Auth::user()->role }}</p>
                                                    {{-- Hapus tombol View Profile --}}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a href="{{ route('logout') }}" class="dropdown-item"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    Log Out
                                                </a>
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="content">
                <main>
                    @yield('content')
                </main>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="text-center">
                        &copy; {{ date('Y') }} PGN RO Lampung. Hak Cipta Dilindungi Undang-undang.
                    </div>
                </div>
            </footer>
        </div>

    </div>

    {{-- Modal untuk menampilkan gambar profil Driver --}}
    <div class="modal fade" id="profileModalDriver" tabindex="-1" aria-labelledby="profileModalDriverLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalDriverLabel">Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ Auth::user() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('kai/assets/img/default-user.jpg') }}"
                        alt="Foto Profil" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    {{-- Pindahkan jquery ke atas --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('kai/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kai/assets/js/core/bootstrap.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('kai/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <script src="{{ asset('kai/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <script src="{{ asset('kai/assets/js/kaiadmin.min.js') }}"></script>

    {{-- Tambahkan @stack untuk script spesifik halaman --}}
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Fungsi untuk update jumlah notifikasi
            function updateUnreadCount() {
                fetch('{{ route('notifications.unreadCount') }}') // Buat route ini (lihat langkah 4)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('unread-count').textContent = data.count;
                        // Jika count 0, sembunyikan badge
                        if (data.count === 0) {
                            document.getElementById('unread-count').classList.add(
                                'd-none'); //d-none = display none, bawaan bootstrap
                        } else {
                            document.getElementById('unread-count').classList.remove('d-none');
                        }
                    });
            }

            // Update jumlah saat halaman pertama dimuat
            updateUnreadCount();

            // Update jumlah setiap 30 detik (opsional, sesuaikan)
            setInterval(updateUnreadCount, 30000);


            // Event listener untuk tombol "Tandai Sudah Dibaca"
            document.querySelector('.notif-box').addEventListener('click', function(
                event) { // Gunakan event delegation
                if (event.target.classList.contains('mark-as-read-btn')) {
                    event.preventDefault(); // Mencegah form di-submit secara normal
                    const form = event.target.closest('form'); // Cari form terdekat
                    const url = form.action;

                    fetch(url, {
                            method: 'POST', // Atau PATCH, tergantung route Anda
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Sertakan CSRF token
                                'Accept': 'application/json', // Minta response JSON
                            },
                            body: new FormData(form), // Kirim data form
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hapus notifikasi dari tampilan
                                form.closest('.notif-item')
                                    .remove(); //Hapus parent element yang terdekat dengan class notif-item
                                // Update jumlah notifikasi
                                updateUnreadCount();
                            } else {
                                alert('Gagal menandai notifikasi sebagai sudah dibaca.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan.');
                        });
                }
            });
        });
    </script>
</body>

</html>
