@extends('layouts.base')
@section('konten')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Pasien</h3>
                    <p class="text-subtitle text-muted">List Daftar Pasien Klinik ABC</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Daftar Pasien
                    </h5>
                    <button class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#inlineForm">
                        Tambah Pasien
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No RM</th>
                                    <th>Name</th>
                                    <th>Dokter</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Jadwal Periksa</th>
                                    <th>Ditambah Oleh</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ShowPatien as $key => $a)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $a->no_rm }}</td>
                                        <td>{{ $a->nama_pasien }}</td>
                                        <td>{{ $a->daftarDokter }}</td>
                                        <td>{{ $a->tgl_masuk }}</td>
                                        <td>{{ $a->tgl_periksa }}</td>
                                        <td>{{ $a->createdBy }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm"
                                                onclick="viewPatient('{{ $a->no_rm }}')">View</button>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="editPatient('{{ $a->no_rm }}')">Edit</button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deletePasien('{{ $a->no_rm }}')">Delete</button>
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
    <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
        aria-atomic="true" style="position: fixed; top: 20px; right: 20px; display: none;">
        <div class="d-flex">
            <div class="toast-body">
                Data pasien berhasil disimpan!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" aria-label="Close"
                onclick="hideToast()"></button>
        </div>
    </div>



    {{-- Modal --}}
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Formulir Tambah Pasien</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formTambahPasien">
                    <div class="modal-body overflow-auto" style="max-height: 70vh;">
                        <label for="namapasien">Nama Pasien: </label>
                        <div class="form-group">
                            <input id="namapasien" type="text" placeholder="Diego Maradone" class="form-control"
                                required>
                            <small class="text-danger" id="nameError" style="display: none;">Nama pasien wajib
                                diisi.</small>
                        </div>
                        <label for="alamat">Alamat:</label>
                        <div class="form-group">
                            <input id="alamat" type="text" placeholder="JL.Singosari.." class="form-control" required>
                            <small class="text-danger" id="addressError" style="display: none;">Alamat wajib diisi.</small>
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
                            <small class="text-danger" id="genderError" style="display: none;">Jenis kelamin wajib
                                dipilih.</small>
                        </div>
                        <div class="form-group">
                            <label for="telepon">No Telepon:</label>
                            <input id="telepon" type="tel" placeholder="081213" class="form-control" maxlength="13"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            <small class="text-danger" id="phoneError" style="display: none;">Nomor telepon wajib
                                diisi.</small>
                        </div>
                        <label for="tgllahir">Tanggal Lahir:</label>
                        <div class="form-group">
                            <input type="date" id="tgllahir" placeholder="Tanggal Lahir"
                                class="form-control mb-3 flatpickr-no-config" onchange="calculateAge()" required>
                            <small class="text-danger" id="birthDateError" style="display: none;">Tanggal lahir wajib
                                diisi.</small>
                        </div>
                        <label for="umur">Umur:</label>
                        <div class="form-group">
                            <input id="umur" type="text" placeholder="20" class="form-control" readonly>
                        </div>
                        <label for="tgl_masuk">Tanggal Masuk:</label>
                        <div class="form-group">
                            <input type="date" id="tgl_masuk" placeholder="Tanggal Masuk"
                                class="form-control mb-3 flatpickr-no-config">
                        </div>
                        <label for="departemen">Departemen Periksa:</label>
                        <div class="form-group">
                            <fieldset class="form-group">
                                <select class="form-select" id="basicSelect">
                                    <option>IT</option>
                                    <option>Blade Runner</option>
                                    <option>Thor Ragnarok</option>
                                </select>
                            </fieldset>
                        </div>
                        <label for="daftardokter">Daftar Dokter:</label>
                        <div class="form-group">
                            <input id="daftardokter" type="text" placeholder="dr. Diego Maradone"
                                class="form-control">
                        </div>
                        <label for="tgl_periksa">Tanggal Periksa:</label>
                        <div class="form-group">
                            <input type="date" id="tgl_periksa" placeholder="Tanggal Periksa"
                                class="form-control mb-3 flatpickr-no-config">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" id="success" onclick="submitForm()" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- View Edit --}}
    <div class="modal fade text-left" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewModalLabel">View Data Pasien</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body overflow-auto" style="max-height: 70vh;">
                    <label for="view_namapasien">Nama Pasien:</label>
                    <div class="form-group">
                        <input id="view_namapasien" type="text" class="form-control" readonly>
                    </div>
                    <label for="view_alamat">Alamat:</label>
                    <div class="form-group">
                        <input id="view_alamat" type="text" class="form-control" readonly>
                    </div>
                    <label>Jenis Kelamin:</label>
                    <div class="form-group">
                        <input id="view_jenis_kelamin" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="view_telepon">No Telepon:</label>
                        <input id="view_telepon" type="tel" class="form-control" readonly>
                    </div>
                    <label for="view_tgllahir">Tanggal Lahir:</label>
                    <div class="form-group">
                        <input type="text" id="view_tgllahir" class="form-control" readonly>
                    </div>
                    <label for="view_umur">Umur:</label>
                    <div class="form-group">
                        <input id="view_umur" type="text" class="form-control" readonly>
                    </div>
                    <label for="view_tgl_masuk">Tanggal Masuk:</label>
                    <div class="form-group">
                        <input type="text" id="view_tgl_masuk" class="form-control" readonly>
                    </div>
                    <label for="view_departemen">Departemen Periksa:</label>
                    <div class="form-group">
                        <input id="view_departemen" type="text" class="form-control" readonly>
                    </div>
                    <label for="view_daftardokter">Daftar Dokter:</label>
                    <div class="form-group">
                        <input id="view_daftardokter" type="text" class="form-control" readonly>
                    </div>
                    <label for="view_tgl_periksa">Tanggal Periksa:</label>
                    <div class="form-group">
                        <input type="text" id="view_tgl_periksa" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit Data Pasien</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formEditPasien">
                    <input type="hidden" id="edit_no_rm">
                    <div class="modal-body overflow-auto" style="max-height: 70vh;">
                        <label for="edit_namapasien">Nama Pasien:</label>
                        <div class="form-group">
                            <input id="edit_namapasien" type="text" class="form-control">
                        </div>
                        <label for="edit_alamat">Alamat:</label>
                        <div class="form-group">
                            <input id="edit_alamat" type="text" class="form-control">
                        </div>
                        <label>Jenis Kelamin:</label>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_jenis_kelamin"
                                    id="edit_jkLaki" value="Laki-Laki">
                                <label class="form-check-label" for="edit_jkLaki">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_jenis_kelamin"
                                    id="edit_jkPerempuan" value="Perempuan">
                                <label class="form-check-label" for="edit_jkPerempuan">Perempuan</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_telepon">No Telepon:</label>
                            <input id="edit_telepon" type="tel" placeholder="081213" class="form-control"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>

                        <label for="edit_tgllahir">Tanggal Lahir:</label>
                        <div class="form-group">
                            <input type="date" id="edit_tgllahir" placeholder="Tanggal Lahir"
                                class="form-control mb-3 flatpickr-no-config" onchange="calculateAge()">
                        </div>
                        <label for="edit_umur">Umur:</label>
                        <div class="form-group">
                            <input id="edit_umur" type="text" placeholder="20" class="form-control" readonly>
                        </div>
                        <label for="edit_tgl_masuk">Tanggal Masuk:</label>
                        <div class="form-group">
                            <input type="date" id="edit_tgl_masuk" placeholder="Tanggal Masuk"
                                class="form-control mb-3 flatpickr-no-config">
                        </div>
                        <label for="departemen">Departemen Periksa:</label>
                        <div class="form-group">
                            <fieldset class="form-group">
                                <select class="form-select" id="basicSelect">
                                    <option>IT</option>
                                    <option>Blade Runner</option>
                                    <option>Thor Ragnarok</option>
                                </select>
                            </fieldset>
                        </div>
                        <label for="edit_daftardokter">Daftar Dokter:</label>
                        <div class="form-group">
                            <input id="edit_daftardokter" type="text" placeholder="dr. Diego Maradone"
                                class="form-control">
                        </div>
                        <label for="edit_tgl_periksa">Tanggal Periksa:</label>
                        <div class="form-group">
                            <input type="date" id="edit_tgl_periksa" placeholder="Tanggal Periksa"
                                class="form-control mb-3 flatpickr-no-config">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" onclick="submitEditForm()" class="btn btn-primary ms-1">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        function calculateAge() {
            const birthDate = new Date(document.getElementById('tgllahir').value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();

            // Adjust age if the birthday has not occurred this year
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            document.getElementById('umur').value = age; // Set the calculated age in the umur field
        }

        function submitForm() {
            const nama_pasien = document.getElementById('namapasien');
            const alamat = document.getElementById('alamat');
            const telepon = document.getElementById('telepon');
            const tgllahir = document.getElementById('tgllahir');
            const jenis_kelamin = document.querySelector('input[name="jenis_kelamin"]:checked');

            let isValid = true;

            // Check each field and display error if empty
            if (!nama_pasien.value) {
                document.getElementById('nameError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('nameError').style.display = 'none';
            }

            if (!alamat.value) {
                document.getElementById('addressError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('addressError').style.display = 'none';
            }

            if (!jenis_kelamin) {
                document.getElementById('genderError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('genderError').style.display = 'none';
            }

            if (!telepon.value) {
                document.getElementById('phoneError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('phoneError').style.display = 'none';
            }

            if (!tgllahir.value) {
                document.getElementById('birthDateError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('birthDateError').style.display = 'none';
            }

            // If any field is invalid, stop the function
            if (!isValid) {
                return;
            }

            // Proceed with AJAX if the form is valid
            const data = {
                nama_pasien: nama_pasien.value,
                alamat_pasien: alamat.value,
                jenis_kelamin_pasien: jenis_kelamin.value,
                telepon: telepon.value,
                tgllahir: tgllahir.value,
                umur: document.getElementById('umur').value,
                tgl_masuk: document.getElementById('tgl_masuk').value,
                departemen: document.getElementById('basicSelect').value,
                daftarDokter: document.getElementById('daftardokter').value,
                tgl_periksa: document.getElementById('tgl_periksa').value
            };

            fetch('{{ route('save.pasien') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        $('#inlineForm').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Saved!',
                            text: 'The patient data has been saved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Save Failed',
                            text: result.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while saving patient data.'
                    });
                });
        }


        // View
        function viewPatient(no_rm) {
            const url = `/managePasien/view/${no_rm}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Populate view modal fields with data
                        document.getElementById('view_namapasien').value = data.patient.nama_pasien;
                        document.getElementById('view_alamat').value = data.patient.alamat;
                        document.getElementById('view_jenis_kelamin').value = data.patient.jenis_kelamin;
                        document.getElementById('view_telepon').value = data.patient.no_telp;
                        document.getElementById('view_tgllahir').value = data.patient.tgllahir;
                        document.getElementById('view_umur').value = data.patient.umur;
                        document.getElementById('view_tgl_masuk').value = data.patient.tgl_masuk;
                        document.getElementById('view_departemen').value = data.patient.departemen;
                        document.getElementById('view_daftardokter').value = data.patient.daftarDokter;
                        document.getElementById('view_tgl_periksa').value = data.patient.tgl_periksa;

                        // Open the view modal
                        $('#viewModal').modal('show');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data pasien');
                });
        }

        // Edit Form
        function editPatient(no_rm) {
            // Construct the URL dynamically
            const url = `/managePasien/edit/${no_rm}`;

            // Make an AJAX request to get patient data by no_rm
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Populate modal fields with data
                        document.getElementById('edit_no_rm').value = no_rm;
                        document.getElementById('edit_namapasien').value = data.patient.nama_pasien;
                        document.getElementById('edit_alamat').value = data.patient.alamat;
                        document.getElementById('edit_telepon').value = data.patient.no_telp;
                        document.getElementById('edit_tgllahir').value = data.patient.tgllahir;
                        document.getElementById('edit_umur').value = data.patient.umur;
                        document.getElementById('edit_tgl_masuk').value = data.patient.tgl_masuk;
                        document.getElementById('basicSelect').value = data.patient.departemen;
                        document.getElementById('edit_daftardokter').value = data.patient.daftarDokter;
                        document.getElementById('edit_tgl_periksa').value = data.patient.tgl_periksa;

                        // Set gender radio button
                        if (data.patient.jenis_kelamin === 'Laki-Laki') {
                            document.getElementById('edit_jkLaki').checked = true;
                        } else if (data.patient.jenis_kelamin === 'Perempuan') {
                            document.getElementById('edit_jkPerempuan').checked = true;
                        }

                        // Open the modal
                        $('#editModal').modal('show');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data pasien');
                });
        }

        function submitEditForm() {
            // Retrieve no_rm from hidden input
            const no_rm = document.getElementById('edit_no_rm').value;
            console.log("no_rm:", no_rm); // Log no_rm

            // Retrieve other form data from the edit modal
            const data = {
                nama_pasien: document.getElementById('edit_namapasien').value,
                alamat_pasien: document.getElementById('edit_alamat').value,
                jenis_kelamin_pasien: document.querySelector('input[name="edit_jenis_kelamin"]:checked') ?
                    document.querySelector('input[name="edit_jenis_kelamin"]:checked').value : '',
                telepon: document.getElementById('edit_telepon').value,
                tgllahir: document.getElementById('edit_tgllahir').value,
                umur: document.getElementById('edit_umur').value,
                tgl_masuk: document.getElementById('edit_tgl_masuk').value,
                departemen: document.getElementById('basicSelect').value,
                daftarDokter: document.getElementById('edit_daftardokter').value,
                tgl_periksa: document.getElementById('edit_tgl_periksa').value
            };

            console.log("Data being sent:", data); // Log all form data

            // AJAX request to update the data
            fetch(`/managePasien/update/${no_rm}`, {
                    method: 'POST', // Use POST for updates
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Use SweetAlert to show a success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Update Successful',
                            text: result.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Reload the page after the alert closes
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: result.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memperbarui data pasien'
                    });
                });
        }

        // Delete Patien
        function deletePasien(no_rm) {
            // Show a confirmation dialog using SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with the deletion
                    fetch(`/managePasien/delete/${no_rm}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
                            }
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: result.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload(); // Reload the page after deletion
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: result.message
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus data pasien'
                            });
                        });
                }
            });
        }
    </script>
@endsection
