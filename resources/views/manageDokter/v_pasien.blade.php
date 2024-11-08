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
                                        <td>{{ $a->dokter->nama_dokter ?? 'N/A' }}</td>
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
                            <select class="form-select" id="departemen" name="departemen" onchange="fetchDoctors()">
                                <option value="">Pilih Departemen</option>
                                @foreach ($departemenList as $departemen)
                                    <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="daftardokter">Daftar Dokter:</label>
                        <div class="form-group">
                            <select class="form-select" id="daftardokter" name="daftarDokterId">
                                <option value="">Pilih Dokter</option>
                            </select>
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
        function fetchDoctors(departemenId, callback) {
            const dokterSelect = document.getElementById('daftardokter');

            // Kosongkan daftar dokter setiap kali departemen berubah
            dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';

            if (departemenId) {
                fetch(`/managePasien/${departemenId}`)
                    .then(response => response.json())
                    .then(doctors => {
                        doctors.forEach(dokter => {
                            const option = document.createElement('option');
                            option.value = dokter.id;
                            option.text = dokter.nama_dokter;
                            dokterSelect.appendChild(option);
                        });

                        // Callback untuk mengatur dokter setelah daftar terisi
                        if (typeof callback === "function") callback();
                    })
                    .catch(error => console.error('Error fetching doctors:', error));
            }
        }


        function calculateAge() {
            const birthDate = new Date(document.getElementById('tgllahir').value);
            const today = new Date();

            if (isNaN(birthDate)) {
                document.getElementById('umur').value = '';
                return;
            }

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();
            const dayDifference = today.getDate() - birthDate.getDate();

            if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
                age--;
            }

            document.getElementById('umur').value = age;
        }


        function setFormReadOnly(isReadOnly) {
            document.getElementById('namapasien').readOnly = isReadOnly;
            document.getElementById('alamat').readOnly = isReadOnly;
            document.getElementById('telepon').readOnly = isReadOnly;
            document.getElementById('tgllahir').readOnly = isReadOnly;
            document.getElementById('umur').readOnly = isReadOnly;
            document.getElementById('tgl_masuk').readOnly = isReadOnly;
            document.getElementById('tgl_periksa').readOnly = isReadOnly;
            document.getElementById('departemen').disabled = isReadOnly;
            document.getElementById('daftardokter').disabled = isReadOnly;
            document.getElementById('jkLaki').disabled = isReadOnly;
            document.getElementById('jkPerempuan').disabled = isReadOnly;
        }


        function submitPatientForm() {
            const no_rm = document.getElementById('patient_no_rm').value;
            const url = no_rm ? `/managePasien/update/${no_rm}` : '{{ route('save.pasien') }}';
            const method = no_rm ? 'POST' : 'POST';

            // Ambil nilai dari setiap input
            const nama_pasien = document.getElementById('namapasien');
            const alamat_pasien = document.getElementById('alamat');
            const jenis_kelamin_pasien = document.querySelector('input[name="jenis_kelamin"]:checked');
            const telepon = document.getElementById('telepon');
            const tgllahir = document.getElementById('tgllahir');
            const umur = document.getElementById('umur');
            const tgl_masuk = document.getElementById('tgl_masuk');
            const departemen = document.getElementById('departemen');
            const daftarDokterId = document.getElementById('daftardokter');
            const tgl_periksa = document.getElementById('tgl_periksa');

            // Validasi: Reset style input field
            const inputFields = [nama_pasien, alamat_pasien, telepon, tgllahir, umur, tgl_masuk, departemen, daftarDokterId,
                tgl_periksa
            ];
            inputFields.forEach(field => field.style.borderColor = ''); // Reset border color

            // Validasi: Pastikan semua input yang diperlukan diisi
            let isValid = true;
            if (!nama_pasien.value) {
                nama_pasien.style.borderColor = 'red';
                isValid = false;
            }
            if (!alamat_pasien.value) {
                alamat_pasien.style.borderColor = 'red';
                isValid = false;
            }
            if (!jenis_kelamin_pasien) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please select gender.'
                });
                isValid = false;
            }
            if (!telepon.value) {
                telepon.style.borderColor = 'red';
                isValid = false;
            }
            if (!tgllahir.value) {
                tgllahir.style.borderColor = 'red';
                isValid = false;
            }
            if (!umur.value) {
                umur.style.borderColor = 'red';
                isValid = false;
            }

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill in all required fields marked in red.'
                });
                return;
            }

            // Buat data untuk dikirimkan
            const data = {
                nama_pasien: nama_pasien.value,
                alamat_pasien: alamat_pasien.value,
                jenis_kelamin_pasien: jenis_kelamin_pasien.value,
                telepon: telepon.value,
                tgllahir: tgllahir.value,
                umur: umur.value,
                tgl_masuk: tgl_masuk.value,
                departemen: departemen.value,
                daftarDokterId: daftarDokterId.value,
                tgl_periksa: tgl_periksa.value
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

        function openPatientModal(action, no_rm = null) {
            const isEdit = action === 'edit';
            const isView = action === 'view';
            document.getElementById('patientModalLabel').innerText = isEdit ? 'Edit Data Pasien' : (isView ?
                'Detail Pasien' : 'Tambah Data Pasien');
            document.getElementById('submitPatientBtn').style.display = isView ? 'none' : 'block';
            setFormReadOnly(isView);

            if (isEdit || isView) {
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

                            // Mengatur nilai tgl_masuk dan tgl_periksa dengan hanya mengambil bagian tanggal
                            document.getElementById('tgl_masuk').value = data.patient.tgl_masuk ? data.patient.tgl_masuk
                                .split(' ')[0] : '';
                            document.getElementById('tgl_periksa').value = data.patient.tgl_periksa ? data.patient
                                .tgl_periksa.split(' ')[0] : '';

                            // Set departemen dan dokter
                            document.getElementById('departemen').value = data.patient.departemen;
                            fetchDoctors(data.patient.departemen, data.patient.daftarDokterId);

                            // Set jenis kelamin
                            if (data.patient.jenis_kelamin === 'Laki-Laki') {
                                document.getElementById('jkLaki').checked = true;
                            } else if (data.patient.jenis_kelamin === 'Perempuan') {
                                document.getElementById('jkPerempuan').checked = true;
                            }

                            $('#patientModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching patient data:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while fetching patient data.'
                        });
                    });
            } else {
                // Reset form untuk mode "Tambah"
                document.getElementById('formPasien').reset();
                document.getElementById('patient_no_rm').value = '';
                document.getElementById('departemen').value = ''; // Reset dropdown departemen
                document.getElementById('daftardokter').innerHTML =
                    '<option value="">Pilih Dokter</option>'; // Reset daftar dokter
                document.getElementById('jkLaki').checked = false; // Reset radio button
                document.getElementById('jkPerempuan').checked = false;

                // Tambahkan event listener untuk muat dokter saat departemen dipilih
                document.getElementById('departemen').addEventListener('change', function() {
                    fetchDoctors(this.value);
                });

                $('#patientModal').modal('show');
            }
        }



        function viewPatient(no_rm) {
            fetch(`/managePasien/edit/${no_rm}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('patientModalLabel').innerText = 'Detail Pasien';
                        document.getElementById('submitPatientBtn').style.display = 'none'; // Sembunyikan tombol submit

                        // Isi setiap field dengan data dari database
                        document.getElementById('namapasien').value = data.patient.nama_pasien;
                        document.getElementById('alamat').value = data.patient.alamat;
                        document.getElementById('telepon').value = data.patient.no_telp;
                        document.getElementById('tgllahir').value = data.patient.tgllahir;
                        document.getElementById('umur').value = data.patient.umur;

                        // Pisahkan tanggal dari waktu
                        document.getElementById('tgl_masuk').value = data.patient.tgl_masuk ? data.patient.tgl_masuk
                            .split(' ')[0] : '';
                        document.getElementById('tgl_periksa').value = data.patient.tgl_periksa ? data.patient
                            .tgl_periksa.split(' ')[0] : '';

                        // Set jenis kelamin sesuai data dari database
                        if (data.patient.jenis_kelamin === 'Laki-Laki') {
                            document.getElementById('jkLaki').checked = true;
                        } else if (data.patient.jenis_kelamin === 'Perempuan') {
                            document.getElementById('jkPerempuan').checked = true;
                        }

                        // Panggil fetchDoctors dengan departemen dan set daftarDokter setelah dropdown terisi
                        document.getElementById('departemen').value = data.patient.departemen;
                        fetchDoctors(data.patient.departemen, () => {
                            document.getElementById('daftardokter').value = data.patient.daftarDokterId;
                        });

                        // Set form menjadi read-only
                        setFormReadOnly(true);

                        $('#patientModal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching patient data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while fetching patient data.'
                    });
                });
        }







        function deletePasien(no_rm) {
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
                    fetch(`/managePasien/delete/${no_rm}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                                }).then(() => location.reload());
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
