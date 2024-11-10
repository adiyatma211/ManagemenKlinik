@extends('layouts.base')

@section('konten')
<div class="page-heading">
    <h1>Presensi</h1>
</div>

<section class="section">
<div class="card">
    <div class="card-header">
 <!-- Buttons for marking entry and exit -->
 <div class="mb-3">
    <form action="{{ route('presensi.masuk') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-primary">Tombol Masuk</button>
    </form>

    <form action="{{ route('presensi.keluar') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-danger">Tombol Keluar</button>
    </form>
</div>
    </div>
    <div class="card-body">
        <!-- Attendance Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Masuk</th>
                <th>Keluar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($presensiRecords as $record)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $record->masuk ? \Carbon\Carbon::parse($record->masuk)->format('d-m-Y H:i:s') : '-' }}</td>
                    <td>{{ $record->keluar ? \Carbon\Carbon::parse($record->keluar)->format('d-m-Y H:i:s') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
    <!-- Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   

    
</section>
   

@endsection
