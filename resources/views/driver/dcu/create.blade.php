@section('title', 'Form DCU | Driver')
@extends('layouts.sidebardriver')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Form Daily Check Up (DCU)</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('driver.dcu.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam">Jam</label>
                                    <input type="text" class="form-control" id="jam"
                                        value="{{ now()->format('H:i') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shift">Shift</label>
                                    <select class="form-control" id="shift" name="shift" required>
                                        <option value="Pagi">Pagi</option>
                                        <option value="Malam">Malam</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>Tekanan Darah</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sistolik">Sys</label>
                                    <input type="number" class="form-control" id="sistolik" name="sistolik"
                                        placeholder="Contoh: 120" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="diastolik">Dias</label>
                                    <input type="number" class="form-control" id="diastolik" name="diastolik"
                                        placeholder="Contoh: 80" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nadi">Nadi</label>
                                    <input type="number" class="form-control" id="nadi" name="nadi"
                                        placeholder="Contoh: 80" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pernapasan">Frekuensi Napas</label>
                                    <input type="number" class="form-control" id="pernapasan" name="pernapasan"
                                        placeholder="Contoh: 20" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="spo2">SpO2</label>
                                    <input type="text" class="form-control" id="spo2" name="spo2"
                                        placeholder="Contoh: 98.5" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="suhu_tubuh">Suhu</label>
                                    <input type="text" class="form-control" id="suhu_tubuh" name="suhu_tubuh"
                                        placeholder="Contoh: 36.5" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mata">Mata</label>
                                    <select class="form-control" id="mata" name="mata" required>
                                        <option value="Normal">Normal</option>
                                        <option value="Tidak Normal">Tidak Normal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kesimpulan">Kesimpulan (Fit/Unfit)</label>
                                    <select class="form-control" id="kesimpulan" name="kesimpulan" required>
                                        <option value="Fit">Fit</option>
                                        <option value="Unfit">Unfit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('driver.dashboard') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
