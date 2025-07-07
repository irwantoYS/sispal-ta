<!DOCTYPE html>
<html lang="en">

<head>

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('sislap.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PGNCOM | Beranda</title>
    <link rel="icon" href="{{ asset('storage/images/pgncom-logo.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

</head>

<body>
    <div class="container-fluid bg-light d-none d-lg-block">
        <div class="row align-items-center top-bar">
            <div class="col-lg-3 col-md-12 text-center text-lg-start">
                <a class="navbar-brand m-0 p-0">
                    <h1 class="text-primary m-0" style="letter-spacing: 10px;">
                        SAFETY DRIVE
                    </h1>
                </a>
            </div>
            <div class="col-lg-9 col-md-12 text-end">
                <div class="h-100 d-inline-flex align-items-center">
                    <img src="{{ asset('storage/images/pgncom-logo.png') }}" style="width: auto; height: 50px;">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid nav-bar bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 py-lg-0 px-lg-4">
            <a href="" class="navbar-brand d-flex align-items-center m-0 p-0 d-lg-none">
                <h1 class="text-primary m-0">SAFETY DRIVE</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav me-auto">
                    <a href="#home" class="nav-item nav-link active">Home</a>
                    <a href="#about" class="nav-item nav-link">About</a>
                </div>
                <div class="navbar-nav nav-item" style="align-items: left;">
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                </div>
            </div>
        </nav>
    </div>
    <section id="home">
        <div class="container py-5 mb-2 wow fadeInUp" data-wow-delay="0.1s"">
            <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-5 col-sm-12">
                                <h5 class=" text-uppercase mb-3 animated slideInDown">
                                    AKHLAK
                                </h5>
                                <h1 class="display-6 animated slideInDown mb-4">
                                    Amanah, Kompeten, Harmonis, Loyal, Adaptif, dan Kolaboratif.
                                </h1>
                                <p class="fs-10 fw-medium mb-4 pb-2">
                                    Sebagai perusahaan BUMN, Pertamina juga menanamkan nilai-nilai dasar (core values)
                                    BUMN, yang disingkat AKHLAK, yakni moral etika yang menjadi panduan seluruh BUMN
                                    saat ini.
                                </p>
                            </div>
                            <div class="col-lg-7 col-sm-12">
                                <img src="{{ asset('storage/images/akhlakbaru.jpeg') }}" class="d-block w-100"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-5 col-sm-12">
                                <h5 class=" text-uppercase mb-3 animated slideInDown">
                                    PGNCOM SAFETY DRIVE
                                </h5>
                                <h1 class="display-6 animated slideInDown mb-4">
                                    Company Value
                                </h1>
                                <p class="fs-10 fw-medium mb-4 pb-2">
                                    Becoming a reliable ICT provider is our main vision. PGNCOM Company values will
                                    always guide our path to give the best to the citizens of Indonesia.
                                </p>
                            </div>
                            <div class="col-lg-7 col-sm-12">
                                <img src="{{ asset('storage/images/pgnbaru.png') }}" class="d-block w-100"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        </div>
    </section>
    <section class="section" id="about">
        <div class="container-xxl py-5 mt-3">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-6 col-sm-12 wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="text-secondary text-uppercase">About Us</h6>
                        <h1 class="mb-4">PGNCOM</h1>
                        <p class="mb-4">
                            Safety drive adalah komitmen untuk menjaga keselamatan dalam berkendara, dan salah satu
                            elemen pentingnya adalah kemampuan untuk melaporkan perjalanan. Dalam Sistem Informasi
                            Laporan Perjalanan Operasional Teknisi, memungkinkan pengemudi atau teknisi untuk memberikan
                            informasi tentang perjalanan mereka, termasuk rincian seperti rute, kilometer yang ditempuh,
                            dan kondisi kendaraan.
                        </p>
                    </div>
                    <div class="col-lg-6 col-sm-12 pt-4" style="min-height: 500px;">
                        <div class="position-relative h-100 wow fadeInUp" data-wow-delay="0.5s">
                            <img class="position-absolute img-fluid w-100 h-120"
                                src="{{ asset('storage/images/About Us.png') }}"
                                style="object-fit: cover; padding: 0 0 50px 100px;" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container wow fadeInUp" data-wow-delay="0.1s"">
        <div class="row">
            <div class="col-lg-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Keluarga Anda Menunggu: </h5>
                        <p class="card-text">Ingatlah, setiap perjalanan adalah langkah menuju rumah dan keluarga Anda.
                            Jadilah pahlawan di mata mereka dengan selalu kembali dengan selamat.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Keselamatan adalah Prioritas Utama: </h5>
                        <p class="card-text">Setiap perjalanan adalah kesempatan untuk kembali dengan selamat. Selalu
                            utamakan keselamatan dalam setiap langkah Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Berhati-hatilah di Jalan: </h5>
                        <p class="card-text">Peraturan lalu lintas ada demi keselamatan kita semua. Taati semua aturan
                            dan tanda-tanda jalan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container align-items-center ms-auto">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">
                    SAFETY DRIVE
                </h6>
                <h1 class="mb-5">
                    Our Expert Staff
                </h1>
            </div>
            <div id="staffCarousel" class="owl-carousel owl-theme wow fadeInUp" data-wow-delay="0.3s">
                @forelse ($staff as $member)
                    <div class="item">
                        <div class="team-content text-center">
                            <div class="position-relative overflow-hidden" style="height: 300px;">
                                <img class="img-fluid w-100 h-100"
                                    src="{{ $member->image ? asset('storage/' . $member->image) : asset('kai/assets/img/default-user.jpg') }}"
                                    alt="{{ $member->nama }}" style="object-fit: cover;">
                            </div>
                            <div class="team-text">
                                <div class="bg-light p-3">
                                    <h5 class="fw-bold mb-1">{{ $member->nama }}</h5>
                                    <small class="text-muted">{{ $member->role }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Data staff tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- SECTION TOP DRIVER --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">
                    TOP DRIVER
                </h6>
                <h1 class="mb-5">
                    Driver Terbaik Bulan {{ $monthName ?? 'Ini' }}
                </h1>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse ($topDrivers as $index => $driver)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + $index * 0.2 }}s">
                        <div class="card h-100 shadow-sm">
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-primary rounded-pill fs-4">#{{ $index + 1 }}</span>
                            </div>
                            <img class="card-img-top"
                                src="{{ $driver->image ? asset('storage/' . $driver->image) : asset('kai/assets/img/default-user.jpg') }}"
                                alt="Foto {{ $driver->nama }}" style="height: 300px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">{{ $driver->nama }}</h5>
                                <p class="card-text mb-1"><i class="fas fa-route me-2"></i>Total Perjalanan:
                                    {{ $driver->total_perjalanan }}</p>
                                <p class="card-text mb-1"><i class="fas fa-road me-2"></i>Total Jarak (Estimasi):
                                    {{ number_format($driver->total_jarak, 2, ',', '.') }} KM</p>
                                <p class="card-text mb-1"><i class="fas fa-tachometer-alt me-2"></i>Total Jarak
                                    (Manual)
                                    :
                                    {{ number_format($driver->total_km_manual, 2, ',', '.') }} KM</p>
                                <p class="card-text"><i class="fas fa-clock me-2"></i>Total Durasi:
                                    {{ $driver->total_durasi_format }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                        <p class="text-muted fs-5">Belum ada data driver terbaik untuk bulan
                            {{ $monthName ?? 'ini' }}.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    {{-- AKHIR SECTION TOP DRIVER --}}

    {{-- SECTION TOP INSPECTOR --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">
                    TOP INSPECTOR
                </h6>
                <h1 class="mb-5">
                    Inspektur Terbaik Bulan {{ $monthName ?? 'Ini' }}
                </h1>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse ($topInspectors as $index => $inspector)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + $index * 0.2 }}s">
                        <div class="card h-100 shadow-sm">
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-primary rounded-pill fs-4">#{{ $index + 1 }}</span>
                            </div>
                            <img class="card-img-top"
                                src="{{ $inspector->image ? asset('storage/' . $inspector->image) : asset('kai/assets/img/default-user.jpg') }}"
                                alt="Foto {{ $inspector->nama }}" style="height: 300px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">{{ $inspector->nama }}</h5>
                                <p class="card-text mb-1"><i class="fas fa-check-circle me-2"></i>Total Inspeksi:
                                    {{ $inspector->total_inspeksi }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                        <p class="text-muted fs-5">Belum ada data inspektur terbaik untuk bulan
                            {{ $monthName ?? 'ini' }}.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    {{-- AKHIR SECTION TOP INSPECTOR --}}

    <footer class="text-white text-center text-lg-start bg-primary wow fadeInUp" data-wow-delay="0.5s">
        <div class="container p-4">
            <div class="row mt-4">
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Address</h5>

                    <ul class="fa-ul" style="margin-left: 1.65em;">
                        <li class="mb-3">
                            <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">Jl. Sam
                                Ratulangi No.15 Penegahan Raya, Kedaton, Bandar Lampung
                                35112</span>
                        </li>
                        <li class="mb-3">
                            <span class="fa-li"><i class="fas fa-envelope"></i></span><span
                                class="ms-2">0721787085</span>
                        </li>
                        <li class="mb-3">
                            <span class="fa-li"><i class="fas fa-phone"></i></span><span
                                class="ms-2">sales@pgncom.co.id</span>
                        </li>
                    </ul>

                    <div class="mt-4 align-center">
                        <a type="button" class="btn rounded-circle btn-floating btn-light btn-lg mx-2"
                            href="https://www.instagram.com/pgncom_id/" target="blank"><i
                                class="fab fa-instagram"></i></a>
                        <a type="button" class="btn rounded-circle btn-floating btn-light btn-lg mx-2"
                            href="https://twitter.com/pgncom_id" target="blank"><i class="fab fa-twitter"></i></a>
                        <a type="button" class="btn rounded-circle btn-floating btn-light btn-lg mx-2"
                            href="https://web.facebook.com/pgncom.id" target="blank"><i
                                class="fab fa-facebook"></i></i></a>
                        <a type="button" class="btn rounded-circle btn-floating btn-light btn-lg mx-2"
                            href="https://www.linkedin.com/company/pgncom/" target="blank"><i
                                class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Opening hours</h5>

                    <table class="table text-center text-white">
                        <tbody class="fw-normal">
                            <tr>
                                <td>Monday - Friday:</td>
                                <td>07-30 AM </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Location</h5>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2036773.2126440762!2d103.43716915927001!3d-4.397501566573127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db1ac49a6df5%3A0xc7cea81081683bbb!2sKantor%20PGN%20Com%20dan%20Gasnet%20RO%20Lampung!5e0!3m2!1sen!2sid!4v1698573669861!5m2!1sen!2sid"
                        width="" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            &copy; {{ date('Y') }} PGN RO Lampung. Hak Cipta Dilindungi Undang-undang.
        </div>
    </footer>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <script src="{{ asset('bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>

    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>

    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>


    <script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>

</body>

</html>
