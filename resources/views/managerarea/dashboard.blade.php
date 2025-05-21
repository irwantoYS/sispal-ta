@section('title', 'Dashboard | Manager Area')
@extends('layouts.sidebarma')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                    <h6 class="op-7 mb-2">Ringkasan Sistem</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-route" style="color: white;"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Perjalanan</p>
                                        <h4 class="card-title">{{ $totalPerjalanan }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-car" style="color: white;"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Kendaraan</p>
                                        <h4 class="card-title">{{ $totalKendaraan }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-id-card" style="color: white;"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Driver</p>
                                        <h4 class="card-title">{{ $totalDriver }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Top Driver Performance</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4 text-center">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-road fa-2x text-danger me-2"></i>
                                        <div>
                                            <small class="text-muted">Seluruh Total Jarak Tempuh</small><br>
                                            <strong class="fs-5">{{ number_format($totalJarakSemua ?? 0, 0, ',', '.') }}
                                                km</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-gas-pump fa-2x text-info me-2"></i>
                                        <div>
                                            <small class="text-muted">Seluruh Total Estimasi BBM</small><br>
                                            <strong class="fs-5">{{ number_format($totalBbmSemua ?? 0, 2, ',', '.') }}
                                                Liter</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-clock fa-2x text-warning me-2"></i>
                                        <div>
                                            <small class="text-muted">Seluruh Total Waktu Tempuh</small><br>
                                            <strong class="fs-5">{{ $totalWaktuFormatSemua }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <form method="GET" action="{{ route('managerarea.dashboard') }}"
                                class="row g-3 align-items-center mb-4">
                                <div class="col-md-4">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select">
                                        @foreach ($availableMonths as $month)
                                            <option value="{{ $month }}"
                                                {{ $selectedMonth == $month ? 'selected' : '' }}>
                                                {{ Carbon\Carbon::create(null, $month, 1)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select">
                                        @foreach ($availableYears as $year)
                                            <option value="{{ $year }}"
                                                {{ $selectedYear == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                            <p class="mt-3 mb-4">Menampilkan data untuk:
                                <strong>{{ Carbon\Carbon::create(null, $selectedMonth, 1)->format('F') }}
                                    {{ $selectedYear }}</strong>
                            </p>
                            <hr>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <h5 class="mb-3">Jarak Tempuh Terbanyak</h5>
                                    @if ($topDriversByDistance->isEmpty())
                                        <p class="text-center text-muted">Tidak ada data.</p>
                                    @else
                                        <ul class="list-group list-group-flush">
                                            @foreach ($topDriversByDistance as $index => $driver)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}.
                                                        {{ $driver->user->nama ?? 'Driver Tidak Ditemukan' }}</span>
                                                    <span
                                                        class="badge bg-primary rounded-pill">{{ number_format($driver->total_jarak, 0, ',', '.') }}
                                                        km</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-3">Perjalanan Terbanyak</h5>
                                    @if ($topDriversByTrips->isEmpty())
                                        <p class="text-center text-muted">Tidak ada data.</p>
                                    @else
                                        <ul class="list-group list-group-flush">
                                            @foreach ($topDriversByTrips as $index => $driver)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}.
                                                        {{ $driver->user->nama ?? 'Driver Tidak Ditemukan' }}</span>
                                                    <span
                                                        class="badge bg-success rounded-pill">{{ $driver->total_perjalanan }}
                                                        Perjalanan</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-3">Waktu Tempuh Terlama</h5>
                                    @if ($topDriversByTime->isEmpty())
                                        <p class="text-center text-muted">Tidak ada data.</p>
                                    @else
                                        <ul class="list-group list-group-flush">
                                            @foreach ($topDriversByTime as $index => $driver)
                                                @php
                                                    // Konversi detik ke jam dan menit
                                                    $totalSeconds = $driver->total_detik;
                                                    $hours = floor($totalSeconds / 3600);
                                                    $minutes = floor(($totalSeconds % 3600) / 60);
                                                    $timeString = '';
                                                    if ($hours > 0) {
                                                        $timeString .= $hours . ' jam ';
                                                    }
                                                    if ($minutes > 0 || $hours == 0) {
                                                        // Tampilkan menit jika ada atau jika jam 0
                                                        $timeString .= $minutes . ' mnt';
                                                    }
                                                    if (empty($timeString)) {
                                                        $timeString = '0 mnt'; // Jika total detik < 60
                                                    }
                                                @endphp
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}.
                                                        {{ $driver->user->nama ?? 'Driver Tidak Ditemukan' }}</span>
                                                    <span
                                                        class="badge bg-warning rounded-pill">{{ trim($timeString) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
