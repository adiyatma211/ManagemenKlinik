@extends('layouts.base')

@section('konten')
<div class="page-heading">
    <h3>Daftar Jadwal Praktek</h3>
    <p class="text-subtitle text-muted">List Jadwal Praktek Dokter</p>
</div>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Jadwal Praktek</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $index => $schedule)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $schedule->day_range }}</td>
                                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                {{-- <td>
                                    @foreach ($schedule->doctors as $doctor)
                                        <span>{{ $doctor->nama_dokter }}</span>@if(!$loop->last), @endif
                                    @endforeach
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
