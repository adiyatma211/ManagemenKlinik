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
                    @if ($ShowRekam->isEmpty())
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="text-muted">Tidak ada pasien hari ini</h5>
                            </div>
                        </div>
                    @else
                        @foreach ($ShowRekam as $rekam)
                            <!-- Start of individual card for each patient -->
                            <div class="card mb-3 border shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="avatar avatar-2xl me-3">
                                        <img src="{{ asset('dist/assets/compiled/jpg/2.jpg') }}" alt="Avatar">
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $rekam->pasien->nama_pasien ?? 'Nama Tidak Tersedia' }}</h5>
                                        <p class="mb-1 text-muted">Jadwal Priksa: {{ \Carbon\Carbon::parse($rekam->pasien->tgl_periksa)->format('d-m-Y') }}</p>
                                        <p class="mb-1">Diagnosa: {{ !empty($rekam->diagnoosa) ? $rekam->diagnoosa : 'Belum Melakukan Konsultasi' }}</p>
                                        <div class="d-flex align-items-center mt-2">
                                            <a href="{{ url('/riwayatPasien/' . $rekam->id . '/edit') }}"
                                               class="btn btn-primary me-2 text-nowrap">
                                                <i class="bi bi-eye-fill"></i> Lihat Riwayat
                                            </a>
                                            @if ($rekam->completed)
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <button onclick="markAsSelesai({{ $rekam->id }})"
                                                        class="btn btn-danger text-nowrap">
                                                    <i class="bi bi-x-circle"></i> Selesai
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of individual card for each patient -->
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        
    </div>

    <script>
        function markAsSelesai(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tindakan ini akan menyelesaikan data pasien.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesai'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('/riwayatPasien/selesai') }}/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil', data.message, 'success');
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                Swal.fire('Gagal', data.message, 'error');
                            }
                        })
                        .catch(error => Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data.', 'error'));
                }
            });
        }
    </script>

@endsection
