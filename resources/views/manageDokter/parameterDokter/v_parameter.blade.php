@extends('layouts.base')
@section('konten')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Departemen</h3>
                    <p class="text-subtitle text-muted">List Daftar Departemen</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Departemen</h5>
                    <button class="btn btn-success btn-sm mt-2" onclick="openDepartmentModal('add')">
                        Tambah Departemen
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Departemen</th>
                                    <th>Keterangan</th>
                                    <th>Ditambah Oleh</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ShowDepartemen as $key => $department)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $department->nama_departemen }}</td>
                                        <td>{{ $department->keterangan_departemen }}</td>
                                        <td>{{ $department->createdBy }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm"
                                                onclick="openDepartmentModal('view', '{{ $department->id }}')">View</button>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="openDepartmentModal('edit', '{{ $department->id }}')">Edit</button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteDepartment('{{ $department->id }}')">Delete</button>
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
    <div class="modal fade text-left" id="departmentModal" tabindex="-1" role="dialog"
        aria-labelledby="departmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="departmentModalLabel">Formulir Departemen</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formDepartemen">
                    @csrf <!-- Include CSRF token -->
                    <div class="modal-body overflow-auto" style="max-height: 70vh;">
                        <label for="namaDepartemen">Nama Departemen:</label>
                        <div class="form-group">
                            <input id="namaDepartemen" name="nama_departemen" type="text" class="form-control" required>
                        </div>
                        <label for="keteranganDepartemen">Keterangan Departemen:</label>
                        <div class="form-group">
                            <textarea id="keteranganDepartemen" name="keterangan_departemen" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="submitDepartmentBtn" onclick="submitDepartmentForm()"
                            class="btn btn-primary ms-1">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentDepartmentId = null;

        function openDepartmentModal(action, id = null) {
            const isEdit = action === 'edit';
            const isView = action === 'view';
            currentDepartmentId = isEdit || isView ? id : null;

            // Set modal title and button visibility based on action
            document.getElementById('departmentModalLabel').innerText = isEdit ? 'Edit Departemen' : (isView ?
                'Detail Departemen' : 'Tambah Departemen');
            document.getElementById('submitDepartmentBtn').style.display = isView ? 'none' : 'block';

            // Toggle read-only state for inputs based on action
            document.getElementById('namaDepartemen').readOnly = isView;
            document.getElementById('keteranganDepartemen').readOnly = isView;

            if (isEdit || isView) {
                // Fetch department data for view or edit
                fetch(`{{ route('edit.departemen', '') }}/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('namaDepartemen').value = data.department.nama_departemen;
                            document.getElementById('keteranganDepartemen').value = data.department
                                .keterangan_departemen;
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Error', 'An error occurred while fetching department data.', 'error'));
            } else {
                // Clear form for adding a new department
                document.getElementById('formDepartemen').reset();
            }

            $('#departmentModal').modal('show');
        }

        function submitDepartmentForm() {
            const url = currentDepartmentId ? `{{ route('update.departemen', '') }}/${currentDepartmentId}` :
                `{{ route('store.departemen') }}`;
            const method = currentDepartmentId ? 'POST' : 'POST';

            const data = {
                nama_departemen: document.getElementById('namaDepartemen').value,
                keterangan_departemen: document.getElementById('keteranganDepartemen').value,
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
                    $('#departmentModal').modal('hide');
                    Swal.fire({
                        icon: result.success ? 'success' : 'error',
                        title: result.success ? 'Data Saved!' : 'Save Failed',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    if (result.success) setTimeout(() => location.reload(), 2000);
                })
                .catch(error => Swal.fire('Error', 'An error occurred while saving department data.', 'error'));
        }

        function deleteDepartment(id) {
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
                    fetch(`{{ route('destroy.departemen', '') }}/${id}`, {
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
                        .catch(error => Swal.fire('Error', 'An error occurred while deleting the department.',
                            'error'));
                }
            });
        }
    </script>
@endsection
