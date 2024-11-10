@extends('layouts.base')

@section('konten')
<div class="page-heading">
    <h3>Daftar Nota Pasien </h3>
    {{-- <p class="text-subtitle text-muted">List Jadwal Praktek Dokter</p> --}}
</div>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Nota Pasien</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Nama Dokter</th>
                            <th>Diagnosa</th>
                            <th>Obat</th>
                            <th>Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showNota as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $a->rekam->pasien->nama_pasien }}</td>
                                <td>{{ $a->rekam->dokter->nama_dokter}}</td>
                                <td>{{ $a->rekam->diagnoosa}}</td>
                                <td>{{ $a->rekam->obat}}</td>
                                <td>{{ $a->biaya}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
