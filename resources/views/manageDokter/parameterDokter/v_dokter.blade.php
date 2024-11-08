@extends('layouts.base')
@section('konten')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Dokter</h3>
                    <p class="text-subtitle text-muted">List Daftar Dokter Aktif</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Dokter</h5>
                    <button class="btn btn-success btn-sm mt-2" onclick="openDoctorModal('add')">
                        Tambah Dokter
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Departemen</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Ditambah Oleh</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ShowDoctor as $key => $doctor)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $doctor->nama_dokter }}</td>
                                        <td>{{ $doctor->jenis_kelamin }}</td>
                                        <td>{{ $doctor->departemen->nama_departemen ?? 'N/A' }}</td>
                                        <td>{{ $doctor->tanggal_masuk }}</td>
                                        <td>{{ $doctor->status }}</td>
                                        <td>{{ $doctor->createdBy }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm"
                                                onclick="openDoctorModal('view', '{{ $doctor->id }}')">View</button>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="openDoctorModal('edit', '{{ $doctor->id }}')">Edit</button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteDoctor('{{ $doctor->id }}')">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Unified Modal for View, Add, and Edit --}}
    <div class="modal fade text-left" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="doctorModalLabel">Formulir Dokter</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formDoctor">
                    @csrf <!-- Include CSRF token -->
                    <div class="modal-body overflow-auto" style="max-height: 70vh;">
                        <label for="namaDoctor">Nama Dokter:</label>
                        <div class="form-group">
                            <input id="namaDoctor" name="nama" type="text" class="form-control" required>
                        </div>
                        <label>Jenis Kelamin:</label>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkLaki"
                                    value="Laki-Laki" required>
                                <label class="form-check-label" for="jkLaki">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkPerempuan"
                                    value="Perempuan" required>
                                <label class="form-check-label" for="jkPerempuan">Perempuan</label>
                            </div>
                        </div>
                        <label for="tgl_masuk">Tanggal Masuk:</label>
                        <div class="form-group">
                            <input type="date" id="tgl_masuk" name="tgl_masuk" class="form-control mb-3">
                        </div>
                        <label for="departemen">Departemen:</label>
                        <div class="form-group">
                            <select class="form-select" id="departemen" name="departemen">
                                @foreach ($showDepartemen as $department)
                                    <option value="{{ $department->id }}">{{ $department->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <label for="status">Status:</label>
                        <div class="form-group">
                            <input id="status" name="status" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="submitDoctorBtn" onclick="submitDoctorForm()"
                            class="btn btn-primary ms-1">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentDoctorId = null;

        function openDoctorModal(action, id = null) {
            const isEdit = action === 'edit';
            const isView = action === 'view';
            currentDoctorId = isEdit || isView ? id : null;

            document.getElementById('doctorModalLabel').innerText = isEdit ? 'Edit Dokter' : (isView ? 'Detail Dokter' :
                'Tambah Dokter');
            document.getElementById('submitDoctorBtn').style.display = isView ? 'none' : 'block';

            document.getElementById('namaDoctor').readOnly = isView;
            document.getElementById('tgl_masuk').readOnly = isView;
            document.getElementById('departemen').disabled = isView;
            document.getElementById('status').readOnly = isView;

            if (isEdit || isView) {
                fetch(`{{ route('edit.dokter', '') }}/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('namaDoctor').value = data.dokter.nama_dokter;
                            document.getElementById('tgl_masuk').value = data.dokter.tanggal_masuk;
                            document.getElementById('departemen').value = data.dokter
                                .departemenId; // gunakan ID departemen

                            document.getElementById('status').value = data.dokter.status;

                            if (data.dokter.jenis_kelamin === 'Laki-Laki') {
                                document.getElementById('jkLaki').checked = true;
                            } else if (data.dokter.jenis_kelamin === 'Perempuan') {
                                document.getElementById('jkPerempuan').checked = true;
                            }
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Error', 'An error occurred while fetching doctor data.', 'error'));
            } else {
                document.getElementById('formDoctor').reset();
            }

            $('#doctorModal').modal('show');
        }


        function submitDoctorForm() {
            const url = currentDoctorId ? `{{ route('update.dokter', '') }}/${currentDoctorId}` :
                `{{ route('store.dokter') }}`;
            const method = currentDoctorId ? 'PUT' : 'POST';

            const data = {
                nama_dokter: document.getElementById('namaDoctor').value,
                jenis_kelamin: document.querySelector('input[name="jenis_kelamin"]:checked').value,
                tanggal_masuk: document.getElementById('tgl_masuk').value,
                departemenId: document.getElementById('departemen').value,
                status: document.getElementById('status').value,
                _token: '{{ csrf_token() }}'
            };


            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    $('#doctorModal').modal('hide');
                    Swal.fire({
                        icon: result.success ? 'success' : 'error',
                        title: result.success ? 'Data Saved!' : 'Save Failed',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    if (result.success) setTimeout(() => location.reload(), 2000);
                })
                .catch(error => Swal.fire('Error', 'An error occurred while saving doctor data.', 'error'));
        }

        function deleteDoctor(id) {
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('destroy.dokter', '') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(result => {
                            Swal.fire({
                                icon: result.success ? 'success' : 'error',
                                title: result.success ? 'Deleted!' : 'Delete Failed',
                                text: result.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            if (result.success) setTimeout(() => location.reload(), 2000);
                        })
                        .catch(error => Swal.fire('Error', 'An error occurred while deleting the doctor.',
                            'error'));
                }
            });
        }
    </script>
@endsection
