<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'HSSE')</title>
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

    {{-- CSS untuk DataTables (Dihapus karena kemungkinan sudah include di plugins.min.css atau kaiadmin.min.css) --}}
    {{-- <link rel="stylesheet" href="{{ asset('kai/assets/js/plugin/datatables/datatables.min.css') }}" /> --}}
    {{-- Jika Anda menggunakan ekstensi Responsive, tambahkan juga CSS-nya --}}
    {{-- <link rel="stylesheet" href="{{ asset('path/to/responsive.dataTables.min.css') }}" /> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ route('hsse.dashboard') }}" class="logo">
                        {{-- Gunakan class sidebar-brand untuk styling --}}
                        <img src="{{ asset('kai/assets/img/kaiadmin/pgncom-logo.png') }}" alt="navbar brand"
                            class="navbar-brand sidebar-brand">
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="fa-solid fa-bars"></i> {{-- Font Awesome --}}
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="fa-solid fa-bars"></i> {{-- Font Awesome --}}
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="fa-solid fa-ellipsis-vertical"></i> {{-- Font Awesome --}}
                    </button>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item {{ Request::is('hsse/dashboard') ? 'active' : '' }}">
                            <a href="{{ route('hsse.dashboard') }}" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('hsse.persetujuan') || request()->routeIs('hsse.history') || request()->routeIs('hsse.peminjaman.index') ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#perjalanan"
                                class="{{ request()->routeIs('hsse.persetujuan') || request()->routeIs('hsse.history') || request()->routeIs('hsse.peminjaman.index') ? '' : 'collapsed' }}"
                                aria-expanded="{{ request()->routeIs('hsse.persetujuan') || request()->routeIs('hsse.history') || request()->routeIs('hsse.peminjaman.index') ? 'true' : 'false' }}">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <p>Perjalanan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->routeIs('hsse.persetujuan') || request()->routeIs('hsse.history') || request()->routeIs('hsse.peminjaman.index') ? 'show' : '' }}"
                                id="perjalanan">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->routeIs('hsse.persetujuan') ? 'active' : '' }}">
                                        <a href="{{ route('hsse.persetujuan') }}">
                                            <span class="sub-item">Persetujuan Perjalanan</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('hsse.peminjaman.index') ? 'active' : '' }}">
                                        <a href="{{ route('hsse.peminjaman.index') }}">
                                            <span class="sub-item">Peminjaman Kendaraan</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('hsse.history') ? 'active' : '' }}">
                                        <a href="{{ route('hsse.history') }}">
                                            <span class="sub-item">History Perjalanan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item {{ Request::is('hsse/kelola-akun*') ? 'active' : '' }}">
                            <a href="{{ route('hsse.kelolaakun') }}">
                                <i class="fa-solid fa-user-group"></i>
                                <p>Kelola Akun</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('hsse/kendaraan*') ? 'active' : '' }}">
                            <a href="{{ route('hsse.kendaraan') }}">
                                <i class="fa-solid fa-car-side"></i>
                                <p>Kendaraan</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('hsse/pegawai*') ? 'active' : '' }}">
                            <a href="{{ route('hsse.pegawai.index') }}">
                                <i class="fa-solid fa-id-card"></i>
                                <p>Master Pegawai</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('hsse.dashboard') }}" class="logo">
                            <img src="{{ asset('kai/assets/img/kaiadmin/pgncom-logo.png') }}" alt="navbar brand"
                                class="navbar-brand" height="40" />
                        </a>

                    </div>
                </div>

                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            {{-- === Mulai Bagian Notifikasi Dinamis === --}}
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-bell"></i>
                                    {{-- Span untuk menampilkan jumlah notifikasi --}}
                                    <span class="badge bg-danger" id="unread-count"></span>
                                </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">Notifikasi</div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                @auth
                                                    {{-- Loop notifikasi user yang login --}}
                                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                                        {{-- Hanya tampilkan yang belum dibaca di dropdown --}}
                                                        <a href="{{ route('hsse.persetujuan') }}?notification_id={{ $notification->id }}&perjalanan_id={{ $notification->data['perjalanan_id'] ?? '' }}"
                                                            class="notif-item @if (!$notification->read_at) fw-bold @endif"
                                                            data-notification-id="{{ $notification->id }}">
                                                            {{-- Ganti ikon jika perlu --}}
                                                            <div class="notif-icon notif-primary">
                                                                <i class="fa-solid fa-check-circle"></i>
                                                            </div>
                                                            <div class="notif-content">
                                                                <span class="block">
                                                                    {{ $notification->data['pesan'] ?? 'Notifikasi baru' }}
                                                                </span>
                                                                <span
                                                                    class="time">{{ $notification->created_at->diffForHumans() }}</span>
                                                                {{-- Tombol Mark as Read (aksi via JS) --}}
                                                                @if (!$notification->read_at)
                                                                    <button
                                                                        class="btn btn-xs btn-link mark-as-read-btn float-end"
                                                                        data-notification-id="{{ $notification->id }}">Tandai
                                                                        Dibaca</button>
                                                                @endif
                                                            </div>
                                                        </a>
                                                    @empty
                                                        <p class="text-muted text-center p-2">Tidak ada notifikasi baru</p>
                                                    @endforelse
                                                @endauth
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        {{-- Link ke halaman semua notifikasi jika ada --}}
                                        {{-- <a class="see-all" href="#">Lihat Semua Notifikasi <i class="fa fa-angle-right"></i></a> --}}
                                    </li>
                                </ul>
                            </li>
                            {{-- === Akhir Bagian Notifikasi Dinamis === --}}

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ Auth::user() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('kai/assets/img/default-user.jpg') }}"
                                            alt=" " class="avatar-img rounded-circle">
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
                                                    {{-- Tambahkan ID untuk modal --}}
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#profileModalHSSE">
                                                        <img src="{{ Auth::user() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('kai/assets/img/default-user.jpg') }}"
                                                            alt=" " class="avatar-img rounded">
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
                                            {{-- Tambahkan form untuk logout, pastikan method-nya POST dan punya CSRF token --}}
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

    {{-- Modal untuk menampilkan gambar profil HSSE --}}
    <div class="modal fade" id="profileModalHSSE" tabindex="-1" aria-labelledby="profileModalHSSELabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalHSSELabel">Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ Auth::user() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('kai/assets/img/default-user.jpg') }}"
                        alt="Foto Profil" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

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

    {{-- Script Notifikasi Dinamis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Fungsi untuk update jumlah notifikasi belum dibaca
            function updateUnreadCount() {
                fetch('{{ route('notifications.unreadCount') }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const countElement = document.getElementById('unread-count');
                        if (countElement) {
                            countElement.textContent = data.count > 0 ? data.count :
                                ''; // Tampilkan count jika > 0
                            // Toggle class d-none berdasarkan count
                            if (data.count === 0) {
                                countElement.classList.add('d-none');
                            } else {
                                countElement.classList.remove('d-none');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching unread count:', error);
                    });
            }

            // Update jumlah saat halaman pertama dimuat
            updateUnreadCount();

            // Update jumlah setiap 30 detik (opsional)
            // setInterval(updateUnreadCount, 30000);

            // Fungsi untuk menandai notifikasi sebagai sudah dibaca
            function markNotificationAsRead(notificationId) {
                const url =
                    `{{ url('/notifications') }}/${notificationId}/mark-as-read`; // Sesuaikan route jika perlu

                fetch(url, {
                        method: 'PATCH', // Atau POST
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to mark notification as read');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            console.log('Notification marked as read:', notificationId);
                            // Hapus item notifikasi dari dropdown
                            const notifItem = document.querySelector(
                                `.notif-item[data-notification-id="${notificationId}"]`);
                            if (notifItem) {
                                notifItem.remove();
                            }
                            // Update count setelah berhasil
                            updateUnreadCount();
                            // Periksa apakah ada notif lain, jika tidak tampilkan pesan kosong
                            const notifCenter = document.querySelector('.notif-center');
                            if (notifCenter && notifCenter.children.length === 0) {
                                notifCenter.innerHTML =
                                    '<p class="text-muted text-center p-2">Tidak ada notifikasi baru</p>';
                            }
                        } else {
                            console.error('Failed to mark notification as read:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                    });
            }

            // Event listener untuk klik pada notifikasi atau tombol mark as read
            document.querySelector('.notif-box').addEventListener('click', function(event) {
                const target = event.target;
                const notifItem = target.closest('.notif-item'); // Cari item notifikasi terdekat

                if (!notifItem) return; // Keluar jika klik bukan di dalam item notifikasi

                const notificationId = notifItem.getAttribute('data-notification-id');

                // Jika yang diklik adalah tombol "Tandai Dibaca"
                if (target.classList.contains('mark-as-read-btn')) {
                    event.preventDefault(); // Mencegah link default
                    event.stopPropagation(); // Mencegah klik menyebar ke link <a>
                    markNotificationAsRead(notificationId);
                }
                // Jika yang diklik adalah link notifikasi itu sendiri (dan belum dibaca)
                else if (notifItem.classList.contains('fw-bold')) {
                    // Tandai sebagai sudah dibaca SEBELUM pindah halaman
                    markNotificationAsRead(notificationId);
                    // Navigasi bisa ditangani oleh link <a> itu sendiri
                }
            });
        });
    </script>

    {{-- Stack untuk script tambahan dari view anak --}}
    @stack('scripts')
</body>

</html>
