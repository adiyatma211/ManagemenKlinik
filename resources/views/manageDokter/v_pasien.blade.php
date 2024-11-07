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
                    <h5 class="card-title">Daftar Pasien</h5>
                    <button class="btn btn-success btn-sm mt-2" onclick="openPatientModal('add')">
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
                                                onclick="openPatientModal('edit', '{{ $a->no_rm }}')">Edit</button>
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

    {{-- Unified Modal --}}
    <div class="modal fade text-left" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="patientModalLabel">Formulir Pasien</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="formPasien">
                    <input type="hidden" id="patient_no_rm">
                    <div class="modal-body overflow-auto" style="max-height: 70vh;">
                        <label for="namapasien">Nama Pasien:</label>
                        <div class="form-group">
                            <input id="namapasien" type="text" class="form-control" required>
                        </div>
                        <label for="alamat">Alamat:</label>
                        <div class="form-group">
                            <input id="alamat" type="text" class="form-control" required>
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
                        <label for="telepon">No Telepon:</label>
                        <div class="form-group">
                            <input id="telepon" type="tel" class="form-control" maxlength="13"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                        <label for="tgllahir">Tanggal Lahir:</label>
                        <div class="form-group">
                            <input type="date" id="tgllahir" class="form-control mb-3" onchange="calculateAge()"
                                required>
                        </div>
                        <label for="umur">Umur:</label>
                        <div class="form-group">
                            <input id="umur" type="text" class="form-control" readonly>
                        </div>
                        <label for="tgl_masuk">Tanggal Masuk:</label>
                        <div class="form-group">
                            <input type="date" id="tgl_masuk" class="form-control mb-3">
                        </div>
                        <label for="departemen">Departemen Periksa:</label>
                        <div class="form-group">
                            <select class="form-select" id="departemen">
                                <option>IT</option>
                                <option>Blade Runner</option>
                                <option>Thor Ragnarok</option>
                            </select>
                        </div>
                        <label for="daftardokter">Daftar Dokter:</label>
                        <div class="form-group">
                            <input id="daftardokter" type="text" class="form-control">
                        </div>
                        <label for="tgl_periksa">Tanggal Periksa:</label>
                        <div class="form-group">
                            <input type="date" id="tgl_periksa" class="form-control mb-3">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="submitPatientBtn" onclick="submitPatientForm()"
                            class="btn btn-primary ms-1">
                            Simpan
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

            // Check if birth date is invalid, then clear the umur field
            if (isNaN(birthDate)) {
                document.getElementById('umur').value = ''; // Clear field if date is invalid
                return;
            }

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();
            const dayDifference = today.getDate() - birthDate.getDate();

            // Adjust age if the birthday hasn't occurred yet this year
            if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
                age--;
            }

            // Set "X tahun" format in the readonly umur input field
            document.getElementById('umur').value = age;
        }

        function openPatientModal(action, no_rm = null) {
            const isEdit = action === 'edit';
            document.getElementById('patientModalLabel').innerText = isEdit ? 'Edit Data Pasien' : 'Tambah Data Pasien';
            document.getElementById('submitPatientBtn').innerText = isEdit ? 'Update' : 'Simpan';

            if (isEdit) {
                fetch(`/managePasien/edit/${no_rm}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('patient_no_rm').value = no_rm;
                            document.getElementById('namapasien').value = data.patient.nama_pasien;
                            document.getElementById('alamat').value = data.patient.alamat;
                            document.getElementById('telepon').value = data.patient.no_telp;
                            document.getElementById('tgllahir').value = data.patient.tgllahir;
                            document.getElementById('umur').value = data.patient.umur;
                            document.getElementById('tgl_masuk').value = data.patient.tgl_masuk;
                            document.getElementById('departemen').value = data.patient.departemen;
                            document.getElementById('daftardokter').value = data.patient.daftarDokter;
                            document.getElementById('tgl_periksa').value = data.patient.tgl_periksa;

                            if (data.patient.jenis_kelamin === 'Laki-Laki') {
                                document.getElementById('jkLaki').checked = true;
                            } else if (data.patient.jenis_kelamin === 'Perempuan') {
                                document.getElementById('jkPerempuan').checked = true;
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('formPasien').reset();
                document.getElementById('patient_no_rm').value = '';
            }

            $('#patientModal').modal('show');
        }

        function submitPatientForm() {
            const no_rm = document.getElementById('patient_no_rm').value;
            const url = no_rm ? `/managePasien/update/${no_rm}` : '{{ route('save.pasien') }}';
            const method = no_rm ? 'POST' : 'POST';

            // Check if each element exists before accessing `.value`
            const nama_pasien = document.getElementById('namapasien') ? document.getElementById('namapasien').value : '';
            const alamat_pasien = document.getElementById('alamat') ? document.getElementById('alamat').value : '';
            const telepon = document.getElementById('telepon') ? document.getElementById('telepon').value : '';
            const tgllahir = document.getElementById('tgllahir') ? document.getElementById('tgllahir').value : '';
            const umur = document.getElementById('umur') ? document.getElementById('umur').value : '';
            const tgl_masuk = document.getElementById('tgl_masuk') ? document.getElementById('tgl_masuk').value : '';
            const departemen = document.getElementById('departemen') ? document.getElementById('departemen').value : '';
            const daftarDokter = document.getElementById('daftardokter') ? document.getElementById('daftardokter').value :
                '';
            const tgl_periksa = document.getElementById('tgl_periksa') ? document.getElementById('tgl_periksa').value : '';

            // Check if a gender radio button is selected
            const jenis_kelamin_radio = document.querySelector('input[name="jenis_kelamin"]:checked');
            const jenis_kelamin_pasien = jenis_kelamin_radio ? jenis_kelamin_radio.value : '';

            // Ensure that the required fields are filled
            if (!nama_pasien || !alamat_pasien || !jenis_kelamin_pasien || !telepon || !tgllahir) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill in all required fields.'
                });
                return;
            }

            const data = {
                nama_pasien,
                alamat_pasien,
                jenis_kelamin_pasien,
                telepon,
                tgllahir,
                umur,
                tgl_masuk,
                departemen,
                daftarDokter,
                tgl_periksa
            };

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    $('#patientModal').modal('hide');
                    Swal.fire({
                        icon: result.success ? 'success' : 'error',
                        title: result.success ? 'Data Saved!' : 'Save Failed',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    if (result.success) setTimeout(() => location.reload(), 2000);
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

        function deletePasien(no_rm) {
            // Show a confirmation dialog using SweetAlert
            Swal.fire({
                title: 'Apakah Anda Akan Menghapus ?',
                text: "Data Tidak akan dapat di kembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Hapus'
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
                                text: 'An error occurred while deleting patient data.'
                            });
                        });
                }
            });
        }
    </script>
@endsection
