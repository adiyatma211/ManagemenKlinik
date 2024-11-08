@extends('layouts.base')
@section('konten')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pasien A/N : {{ $patient->pasien->nama_pasien ?? 'Nama Tidak Tersedia' }}</h3>
            </div>
        </div>
    </div>
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Pasien</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('patients.update',$patient->id) }}" method="POST" class="form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Nama Pasien:</label>
                                            <input type="text" id="first-name-column" class="form-control"
                                            value="{{ $patient->pasien->nama_pasien ?? 'Nama Tidak Tersedia' }}" placeholder="Joko Sunarjo" name="nama_pasien" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Jenis Kelamin:</label>
                                            <input type="text" id="last-name-column" class="form-control"
                                            value="{{ $patient->pasien->jenis_kelamin ?? 'Jenis Kelamin Tidak Tersedia' }}" placeholder="Laki - Laki" name="jenis_kelamin" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="keluhan" class="form-label">Keluhan</label>
                                            <textarea class="form-control" name="keluhan" id="keluhan" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="diagnosa" class="form-label">Diagnosa</label>
                                            <textarea class="form-control" name="diagnoosa" id="diagnosa" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="tindakan" class="form-label">Tindakan</label>
                                            <textarea class="form-control" name="tindakan" id="tindakan" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="obat" class="form-label">Obat</label>
                                            <textarea class="form-control" name="obat" id="obat" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
