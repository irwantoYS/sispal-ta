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
     <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ route('hsse.dashboard') }}" class="logo">
                      {{-- Gunakan class sidebar-brand untuk styling --}}
                        <img src="{{ asset('kai/assets/img/kaiadmin/pgncom-logo.png') }}" alt="navbar brand" class="navbar-brand sidebar-brand">
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="fa-solid fa-bars"></i>  {{-- Font Awesome --}}
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

                        <li class="nav-item {{ Request::is('hsse/perjalanan*') ? 'active' : '' }}">
                          <a data-bs-toggle="collapse" href="#perjalanan" class="{{ Request::is('hsse/perjalanan*') ? '' : 'collapsed' }}" aria-expanded="{{ Request::is('hsse/perjalanan*') ? 'true' : 'false' }}">
                              <i class="fa-solid fa-map-location-dot"></i>
                              <p>Perjalanan</p>
                              <span class="caret"></span>
                          </a>
                          <div class="collapse {{ Request::is('hsse/perjalanan*') ? 'show' : '' }}" id="perjalanan">
                              <ul class="nav nav-collapse">
                                  <li class="{{ Request::is('hsse/persetujuan') ? 'active' : '' }}">
                                      <a href="{{ route('hsse.persetujuan') }}">
                                          <span class="sub-item">Persetujuan Perjalanan</span>
                                      </a>
                                  </li>
                                  <li class="{{ Request::is('hsse/history') ? 'active' : '' }}">
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
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            <div class="main-header">
              <div class="main-header-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ route('hsse.dashboard') }}" class="logo">
                        <img src="{{ asset('kai/assets/img/kaiadmin/pgncom-logo.png') }}" alt="navbar brand" class="navbar-brand" height="40" />
                    </a>
                    
                </div>
                </div>

                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="notification">4</span> {{--  Ubah angka 4 dengan jumlah notifikasi yang sebenarnya --}}
                                </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">
                                            You have 4 new notification  {{--  Ubah teks ini --}}
                                        </div>
                                    </li>
                                    <li>
                                      {{--  Isi notifikasi yang sebenarnya dari database --}}
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                             {{--  Contoh, sesuaikan dengan data Anda.  Bisa menggunakan @foreach --}}
                                                <a href="#">
                                                    <div class="notif-icon notif-primary">
                                                        <i class="fa fa-user-plus"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block"> New user registered </span>
                                                        <span class="time">5 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-icon notif-success">
                                                        <i class="fa fa-comment"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            Rahmad commented on Admin
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="{{ asset('kai/assets/img/profile2.jpg') }}" alt="Img Profile" /> {{-- Ganti path ke profile yang sesuai --}}
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            Reza send messages to you
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-icon notif-danger">
                                                        <i class="fa fa-heart"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block"> Farrah liked Admin </span>
                                                        <span class="time">17 minutes ago</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="javascript:void(0);">See all notifications<i
                                                class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ asset('storage/' . (Auth::user()->image ?? 'kai/assets/img/default-user.png')) }}" alt=" " class="avatar-img rounded-circle">
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
                                                    <img src="{{ asset('storage/' . (Auth::user()->image ?? 'kai/assets/img/default-user.png')) }}" alt=" " class="avatar-img rounded">
                                                </div>
                                                <div class="u-text">
                                                    <h4>{{ Auth::user()->nama }}</h4>
                                                    <p class="text-muted">{{ Auth::user()->role }}</p>
                                                    <a href="#" {{--  Ganti route ke profile  --}}
                                                        class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                             {{-- Tambahkan form untuk logout, pastikan method-nya POST dan punya CSRF token --}}
                                            <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
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
</body>
</html>