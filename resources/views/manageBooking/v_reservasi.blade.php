@extends('layouts.base')
@section('konten')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Reservasi</h3>
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
                                        <td>{{ \Carbon\Carbon::parse($a->tgl_periksa)->format('d-m-Y') }}</td>
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
                    <input type="hidden" id="patient_no_rm" name="no_rm">
                    <div class="modal-body overflow-auto" style="max-height: 70vh;">
                        <label for="no_rm">NO RM:</label>
                        <div class="form-group">
                            <input id="no_rm"  name="no_rm" type="text" class="form-control" readonly>
                        </div>
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
                      
                        <label for="departemen">Departemen Periksa:</label>
                        <div class="form-group">
                            <select class="form-select" id="departemen" name="departemen" onchange="fetchDoctors(this.value)">
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
       document.getElementById('no_rm').addEventListener('blur', function() {
    const no_rm = this.value;
    if (no_rm) {
        // Kirim request untuk mencari data pasien berdasarkan no_rm
        fetch(`/reservasi/${no_rm}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Isi form dengan data yang ditemukan
                    document.getElementById('namapasien').value = data.patient.nama_pasien;
                    document.getElementById('alamat').value = data.patient.alamat;
                    document.getElementById('telepon').value = data.patient.no_telp;
                    document.getElementById('tgllahir').value = data.patient.tgllahir;
                    document.getElementById('umur').value = data.patient.umur;

                    document.getElementById('departemen').value = data.patient.departemen;
                    fetchDoctors(data.patient.departemen, () => {
                        document.getElementById('daftardokter').value = data.patient.daftarDokterId;
                    });

                    if (data.patient.jenis_kelamin === 'Laki-Laki') {
                        document.getElementById('jkLaki').checked = true;
                    } else if (data.patient.jenis_kelamin === 'Perempuan') {
                        document.getElementById('jkPerempuan').checked = true;
                    }

                    // Enable `no_rm` jika data ditemukan
                    document.getElementById('no_rm').disabled = false;

                    Swal.fire({
                        icon: 'info',
                        title: 'Data Ditemukan',
                        text: 'Data pasien telah ditemukan dan form otomatis terisi.'
                    });
                } else {
                    // Kosongkan form jika pasien tidak ditemukan
                    document.getElementById('formPasien').reset();
                    // document.getElementById('no_rm').value = no_rm; // Pastikan no_rm tetap terisi
                    document.getElementById('no_rm').disabled = true; // Disable `no_rm` jika data tidak ditemukan
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Ditemukan',
                        text: 'Data pasien tidak ditemukan untuk No RM ini. No RM sekarang akan di-disable.'
                    });
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mencari data pasien.'
                });
            });
    }
});


function openPatientModal(action, no_rm = null) {
    const isEdit = action === 'edit';
    const isView = action === 'view';
    document.getElementById('patientModalLabel').innerText = isEdit ? 'Edit Data Pasien' : (isView ? 'Detail Pasien' : 'Tambah Data Pasien');
    document.getElementById('submitPatientBtn').style.display = isView ? 'none' : 'block';
    setFormReadOnly(isView);

    // Set `no_rm` value in the modal field
    document.getElementById('no_rm').value = no_rm || ''; // Set empty if no_rm is null

    if (isEdit || isView) {
    fetch(`/reservasi/${no_rm}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const patient = data.patient;

                // Convert `tgl_periksa` to `YYYY-MM-DD` without timezone adjustments
                const tglPeriksa = patient.tgl_periksa.split(' ')[0];
                document.getElementById('tgl_periksa').value = tglPeriksa;

                // Set other fields
                document.getElementById('namapasien').value = patient.nama_pasien;
                document.getElementById('alamat').value = patient.alamat;
                document.getElementById('telepon').value = patient.no_telp;
                document.getElementById('tgllahir').value = patient.tgllahir;
                document.getElementById('umur').value = patient.umur;
                document.getElementById('departemen').value = patient.departemen;

                fetchDoctors(patient.departemen, () => {
                    document.getElementById('daftardokter').value = patient.daftarDokterId;
                });

                if (patient.jenis_kelamin === 'Laki-Laki') {
                    document.getElementById('jkLaki').checked = true;
                } else if (patient.jenis_kelamin === 'Perempuan') {
                    document.getElementById('jkPerempuan').checked = true;
                }

                $('#patientModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Ditemukan',
                    text: 'Data pasien tidak ditemukan untuk No RM ini.'
                });
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat mencari data pasien.'
            });
        });
    } else {
        document.getElementById('formPasien').reset();
        document.getElementById('no_rm').disabled = false;
        $('#patientModal').modal('show');
    }
}


function viewPatient(no_rm) {
    console.log("no_rm received in viewPatient:", no_rm); // Debugging line
    openPatientModal('view', no_rm);
}



        function setFormReadOnly(isReadOnly) {
            document.getElementById('no_rm').readOnly = isReadOnly;
            document.getElementById('namapasien').readOnly = isReadOnly;
            document.getElementById('alamat').readOnly = isReadOnly;
            document.getElementById('telepon').readOnly = isReadOnly;
            document.getElementById('tgllahir').readOnly = isReadOnly;
            document.getElementById('umur').readOnly = isReadOnly;
            document.getElementById('tgl_periksa').readOnly = isReadOnly;
            document.getElementById('departemen').disabled = isReadOnly;
            document.getElementById('daftardokter').disabled = isReadOnly;
            document.getElementById('jkLaki').disabled = isReadOnly;
            document.getElementById('jkPerempuan').disabled = isReadOnly;
        }

        function submitPatientForm() {
            const no_rm = document.getElementById('no_rm').value;
            console.log("Submitting no_rm:", no_rm);

            const data = {
                no_rm: no_rm,
                nama_pasien: document.getElementById('namapasien').value,
                alamat: document.getElementById('alamat').value,
                jenis_kelamin: document.querySelector('input[name="jenis_kelamin"]:checked').value,
                telepon: document.getElementById('telepon').value,
                tgllahir: document.getElementById('tgllahir').value,
                umur: document.getElementById('umur').value,
                departemen: document.getElementById('departemen').value,
                daftarDokterId: document.getElementById('daftardokter').value,
                tgl_periksa: document.getElementById('tgl_periksa').value
            };

            fetch('{{ route('reservasi.saveOrUpdate') }}', {
                method: 'POST',
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
                    title: result.success ? 'Success' : 'Error',
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
        function fetchDoctors(departemenId, callback) {
    const dokterSelect = document.getElementById('daftardokter');

    // Kosongkan daftar dokter setiap kali departemen berubah
    dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';

    if (departemenId) {
        fetch(`managePasien/${departemenId}`)  // Pastikan endpoint ini sudah diatur
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
                    fetch(`/reservasi/${no_rm}`, {
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
        function calculateAge() {
            const birthDate = new Date(document.getElementById('tgllahir').value);
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            document.getElementById('umur').value = age;
        }

        // Attach to 'tgllahir' input field
        document.getElementById('tgllahir').addEventListener('change', calculateAge);
        
        
        function fetchDoctors(departemenId, callback) {
        const dokterSelect = document.getElementById('daftardokter');
            
        // Clear the dropdown each time a new department is selected
        dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';

        if (departemenId) {
            fetch(`/managePasien/${departemenId}`) // Ensure the endpoint is correct and returns JSON
                .then(response => response.json())
                .then(doctors => {
                    doctors.forEach(dokter => {
                        const option = document.createElement('option');
                        option.value = dokter.id;
                        option.text = dokter.nama_dokter;
                        dokterSelect.appendChild(option);
                    });

                    // Execute callback if provided to set a specific doctor
                    if (typeof callback === "function") callback();
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengambil data dokter.'
                    });
                });
        }
    }
    </script>
@endsection
