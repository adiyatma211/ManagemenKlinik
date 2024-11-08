@extends('layouts.base')
@section('konten')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pasien {{ Auth::user()->name }}</h3>
                    <p class="text-subtitle text-muted">
                        Pasien dokter hari ini berjumlah {{ $patientCount }}
                    </p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pasien</h4>
                </div>
                <div class="card-body">
                    <div class="comment">
                        @if($ShowRekam->isEmpty())
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="text-muted">Tidak ada pasien hari ini</h5>
                                </div>
                            </div>
                        @else
                            @foreach ($ShowRekam as $rekam)
                                <div class="comment-header">
                                    <div class="pr-50">
                                        <div class="avatar avatar-2xl">
                                            <img src="{{ asset('dist/assets/compiled/jpg/2.jpg') }}" alt="Avatar">
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-profileName">
                                            {{ $rekam->pasien->nama_pasien ?? 'Nama Tidak Tersedia' }}
                                        </div>
                                        <div class="comment-time">Jadwal Priksa : {{ \Carbon\Carbon::parse($rekam->pasien->tgl_periksa)->format('d-m-Y') }}</div>
                                    
                                        <div class="comment-message">
                                            <p class="list-group-item-text truncate mb-20">
                                                Diagnosa : {{ !empty($rekam->diagnoosa) ? $rekam->diagnoosa : 'Belum Melakukan Konsultasi' }}
                                            </p>
                                        </div>
                                        
                                        <div class="comment-actions">
                                            <a href="{{ url('/riwayatPasien/' . $rekam->id . '/edit') }}" class="btn icon icon-left btn-primary me-2 text-nowrap">
                                                <i class="bi bi-eye-fill"></i> Lihat Riwayat
                                            </a>
                                            
                                            
                                            <button class="btn icon icon-left btn-danger me-2 text-nowrap">
                                                <i class="bi bi-x-circle"></i> Selesai
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
