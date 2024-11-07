@extends('layouts.base')
@section('konten')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pasien Nama Dokter</h3>
                    <p class="text-subtitle text-muted">
                        Pasien dokter hari ini berjumlah 10
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
                        <div class="comment-header">
                            <div class="pr-50">
                                <div class="avatar avatar-2xl">
                                    <img src="{{ asset('dist/assets/compiled/jpg/2.jpg') }}" alt="Avatar">
                                </div>
                            </div>
                            <div class="comment-body">
                                <div class="comment-profileName">Muhammad Alfian</div>
                                <div class="comment-time">8 seconds ago</div>
                                <div class="comment-message">
                                    <p class="list-group-item-text truncate mb-20">Your <a
                                            href="https://github.com/alfianchii/confess" target="_blank">confession</a> will
                                        be processed. Stay tuned!</p>
                                </div>
                                <div class="comment-actions">
                                    <button class="btn icon icon-left btn-primary me-2 text-nowrap"><i
                                            class="bi bi-eye-fill"></i> Show</button>
                                    <button class="btn icon icon-left btn-warning me-2 text-nowrap"><i
                                            class="bi bi-pencil-square"></i> Edit</button>
                                    <button class="btn icon icon-left btn-danger me-2 text-nowrap"><i
                                            class="bi bi-x-circle"></i> Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment">
                        <div class="comment-header">
                            <div class="pr-50">
                                <div class="avatar avatar-2xl">
                                    <img src="{{ asset('dist/assets/compiled/jpg/3.jpg') }}" alt="Avatar">
                                </div>
                            </div>
                            <div class="comment-body">
                                <div class="comment-profileName"> Sana Fatima </div>
                                <div class="comment-time">4 minutes ago</div>
                                <div class="comment-message">
                                    <p class="list-group-item-text truncate mb-20">I have looked into your matter and will
                                        respond soon.</p>
                                </div>
                                <div class="comment-actions">
                                    <button class="btn icon icon-left btn-primary me-2 text-nowrap"><i
                                            class="bi bi-eye-fill"></i> Show</button>
                                    <button class="btn icon icon-left btn-warning me-2 text-nowrap"><i
                                            class="bi bi-pencil-square"></i> Edit</button>
                                    <button class="btn icon icon-left btn-danger me-2 text-nowrap"><i
                                            class="bi bi-x-circle"></i> Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
