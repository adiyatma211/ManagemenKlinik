@extends('layouts.base')
@section('konten')
<div class="page-heading">
    <h3>Daftar History Pasien </h3>
    {{-- <p class="text-subtitle text-muted">List Jadwal Praktek Dokter</p> --}}
</div>
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Periksa</th>
                            <th>Departemen</th>
                            <th>Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showHistory as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $a->no_rm }}</td>
                                <td>{{ $a->pasien->nama_pasien }}</td>
                                <td>{{ $a->tanggal_periksa}}</td>
                                <td>{{ $a->dokter->departemen->nama_departemen}}</td>
                                <td>{{ $a->dokter->nama_dokter}}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


@endsection