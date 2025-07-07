@section('title', 'Dashboard | Driver')
@extends('layouts.sidebardriver')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                    <h6 class="op-7 mb-2">Performa Saya</h6>
                </div>
            </div>

            <div class="row">
                <!-- Kartu Total Perjalanan -->
                <div class="col-md-4">
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
                                        <p class="card-category">Total Perjalanan Saya</p>
                                        <h4 class="card-title">{{ $totalPerjalananDriver }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kartu Total Kendaraan -->
                <div class="col-md-4">
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
                                        <p class="card-category">Total Kendaraan Digunakan</p>
                                        <h4 class="card-title">{{ $totalKendaraanDriver }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Penutup .row untuk kartu statistik atas -->

            <!-- Baris untuk Statistik Performa Bulanan -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Statistik Performa Driver</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Ringkasan Total Keseluruhan dalam bentuk card -->
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-primary card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-primary bubble-shadow-small"><i
                                                            class="fas fa-route"></i></div>
                                                </div>
                                                <div class="col col-stats ms-3 ms-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Total Perjalanan</p>
                                                        <h4 class="card-title">{{ $totalPerjalananDriver }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-success card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-success bubble-shadow-small"><i
                                                            class="fas fa-tachometer-alt"></i></div>
                                                </div>
                                                <div class="col col-stats ms-3 ms-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Total KM (Manual)</p>
                                                        <h4 class="card-title">
                                                            {{ number_format($totalKmManualDriverSelesai, 2, ',', '.') }}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-info card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-info bubble-shadow-small"><i
                                                            class="fas fa-road"></i></div>
                                                </div>
                                                <div class="col col-stats ms-3 ms-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Total KM (Estimasi)</p>
                                                        <h4 class="card-title">
                                                            {{ number_format($totalJarakDriverSelesai, 2, ',', '.') }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-danger card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-danger bubble-shadow-small"><i
                                                            class="fas fa-gas-pump"></i></div>
                                                </div>
                                                <div class="col col-stats ms-3 ms-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Total Estimasi BBM</p>
                                                        <h4 class="card-title">
                                                            {{ number_format($totalBbmDriverSelesai, 2, ',', '.') }} L</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Filter Bulan dan Tahun -->
                            <form method="GET" action="{{ route('driver.dashboard') }}"
                                class="row g-3 align-items-center mb-4">
                                <div class="col-md-4">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select">
                                        @if ($availableMonths->isEmpty())
                                            <option value="{{ Carbon\Carbon::now()->month }}" selected>
                                                {{ Carbon\Carbon::now()->format('F') }}</option>
                                        @else
                                            @foreach ($availableMonths as $month)
                                                <option value="{{ $month }}"
                                                    {{ $selectedMonth == $month ? 'selected' : '' }}>
                                                    {{ Carbon\Carbon::create(null, $month, 1)->format('F') }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select">
                                        @if ($availableYears->isEmpty())
                                            <option value="{{ Carbon\Carbon::now()->year }}" selected>
                                                {{ Carbon\Carbon::now()->year }}</option>
                                        @else
                                            @foreach ($availableYears as $year)
                                                <option value="{{ $year }}"
                                                    {{ $selectedYear == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        @endif
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
                            <!-- Statistik Bulanan -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card card-stats card-secondary card-round">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center">
                                                        <i class="fas fa-road"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category">Jarak Tempuh</p>
                                                        <h4 class="card-title" style="font-size: 1rem;">
                                                            {{ number_format($statsKmManual ?? 0, 2, ',', '.') }} km
                                                            <small>(Manual)</small>
                                                        </h4>
                                                        <h4 class="card-title" style="font-size: 1rem;">
                                                            {{ number_format($statsJarak ?? 0, 0, ',', '.') }} km
                                                            <small>(estimasi)</small>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-stats card-success card-round">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center">
                                                        <i class="fas fa-route"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category">Jumlah Perjalanan</p>
                                                        <h4 class="card-title">{{ $statsJumlahPerjalanan ?? 0 }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-stats card-warning card-round">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center">
                                                        <i class="fas fa-clock"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category">Waktu Tempuh</p>
                                                        <h4 class="card-title">{{ $statsWaktuFormat }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Penutup .row untuk statistik bulanan -->
                        </div> <!-- Penutup .card-body utama -->
                    </div> <!-- Penutup .card utama -->
                </div> <!-- Penutup .col-md-12 utama -->
            </div> <!-- Penutup .row utama -->

            {{-- Kartu Statistik Performa Driver (Placeholder - bisa dihapus jika tidak diperlukan) --}}
        </div> <!-- Penutup .page-inner -->
    </div> <!-- Penutup .container -->

@endsection
