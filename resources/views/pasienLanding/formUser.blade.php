@extends('layouts.lpBase')
@section('kontenUser')
<section class="take-appointment section-space overflow-hidden">     
    <div class="container">         
        <div class="take-appointment__container-shape" data-background="assets/imgs/take-appointment/container-shape.png"></div>         
        <div class="row">             
            <!-- Form untuk Pasien Lama -->
            <div class="col-lg-6">                 
                <div class="section__title-wrapper take-appointment__content">                     
                    <h5 class="section__subtitle color-theme-primary mb-15 mb-xs-10 title-animation">
                        <img src="{{asset('lpUser/assets/imgs/ask-quesiton/heart.png')}}" alt="icon not found" class="img-fluid"> Pasien Lama
                    </h5>                     
                    <h2 class="section__title mb-20 mb-xs-15 title-animation">Sudah Pernah Berobat? Isi Detail Anda</h2>                      
                    <div class="take-appointment__form mt-md-50 mt-sm-40 mt-xs-40">                         
                        <div class="row">    
                            <!-- No RM -->
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="no_rm">No RM</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="no_rm" id="no_rm" type="text" onblur="checkNoRM()" placeholder="Masukkan No RM...">                                        
                                        <i class="fa-solid fa-id-badge"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>                                  
                            
                            <!-- Nama Pasien -->
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="nama_pasien">Nama</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="nama_pasien" id="nama_pasien" type="text" placeholder="Masukkan nama...">                                         
                                        <i class="fa-solid fa-user"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>                             
                            
                            <!-- Alamat Pasien -->
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="alamat_pasien">Alamat</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="alamat_pasien" id="alamat_pasien" type="text" placeholder="Masukkan alamat...">                                         
                                        <i class="fa-solid fa-id-badge"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>                             
                            
                            <!-- No Telepon -->
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="telepon">No Telepon</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="telepon" id="telepon" type="text" placeholder="Masukkan no telepon...">                                         
                                        <i class="fa-solid fa-phone"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>                             
                            
                            <!-- Tanggal Lahir -->
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="tgllahir">Tanggal Lahir</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="tgllahir" id="tgllahir" type="date" placeholder="Masukkan tanggal lahir...">                                         
                                        <i class="fa-solid fa-calendar"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>     
                            
                            <!-- Umur -->
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="umur">Umur</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="umur" id="umur" type="number" placeholder="Masukkan umur...">                                         
                                        <i class="fa-solid fa-paper-plane"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>
                            
                            <!-- Tanggal Periksa -->
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="tgl_periksa">Tanggal Periksa</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="tgl_periksa" id="tgl_periksa" type="date" placeholder="Masukkan tanggal periksa...">                                         
                                        <i class="fa-solid fa-calendar"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>          
            
                            <!-- Departemen -->
                            <div class="col-sm-6">
                                <div class="take-appointment__form-input">
                                    <label for="departemen">Departemen</label>
                                    <div class="take-appointment__form-input-select">
                                        <select id="departemen" name="departemen" onchange="fetchDoctors()">
                                            <option value="">Pilih Departemen</option>
                                            @foreach ($departemenList as $departemen)
                                                <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Daftar Dokter -->
                            <div class="col-sm-6">
                                <div class="take-appointment__form-input">
                                    <label for="daftarDokterId">Dokter</label>
                                    <div class="take-appointment__form-input-select">
                                        <select id="daftarDokterId" name="daftarDokterId">
                                            <option value="">Pilih Dokter...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>         
                            
                            <!-- Submit Button -->
                            <div class="col-12">                                 
                                <button type="button" class="rr-btn rr-btn__primary-color mt-10 mt-xs-10" onclick="updatePatientData()">                                     
                                    <span class="btn-wrap">                                         
                                        <span class="text-one">Daftar Sekarang <i class="fa-solid fa-arrow-right"></i></span>                                      
                                        <span class="text-two">Daftar Sekarang <i class="fa-solid fa-arrow-right"></i></span>                                      
                                    </span>                                 
                                </button>                             
                            </div>
                                                   
                        </div>                     
                    </div>                 
                </div>             
            </div>
                         
            <!-- Form untuk Pasien Baru -->
            <div class="col-lg-6">                 
                <div class="section__title-wrapper take-appointment__content">                     
                    <h5 class="section__subtitle color-theme-primary mb-15 mb-xs-10 title-animation">
                        <img src="{{asset('lpUser/assets/imgs/ask-quesiton/heart.png')}}" alt="icon not found" class="img-fluid"> Pasien Baru
                    </h5>                     
                    <h2 class="section__title mb-20 mb-xs-15 title-animation">Daftarkan Diri Anda Untuk Kesembuhan yang Sempurna</h2>                      
                    <div class="take-appointment__form mt-md-50 mt-sm-40 mt-xs-40">                         
                        <div class="row">                                                       
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_name">Nama</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="new_name" id="new_name" type="text" placeholder="Your name...">                                         
                                        <i class="fa-solid fa-user"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>                             
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_address">Alamat</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="new_address" id="new_address" type="text" placeholder="Your address...">                                         
                                        <i class="fa-solid fa-id-badge"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>                             
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_phone">No Telepon</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="new_phone" id="new_phone" type="text" placeholder="Your phone...">                                         
                                        <i class="fa-solid fa-phone"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>                             
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_birthdate">Tanggal Lahir</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="new_birthdate" id="new_birthdate" type="date" placeholder="Your birthdate...">                                         
                                        <i class="fa-solid fa-calendar"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>     
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_age">Umur</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="new_age" id="new_age" type="number" placeholder="Your age...">                                         
                                        <i class="fa-solid fa-paper-plane"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_gender">Jenis Kelamin</label>                                     
                                    <div class="take-appointment__form-input-select">                                         
                                        <select class="form-select" id="new_gender" name="gender" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>                                     
                                    </div>                                 
                                </div>                             
                            </div>
                            
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_checkup_date">Tanggal Periksa</label>                                     
                                    <div class="input-wrapper">                                         
                                        <input name="new_checkup_date" id="new_checkup_date" type="date" placeholder="Checkup date...">                                         
                                        <i class="fa-solid fa-calendar"></i>                                     
                                    </div>                                 
                                </div>                             
                            </div>          
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_departemen">Departemen</label>                                     
                                    <div class="take-appointment__form-input-select">                                         
                                        <select class="form-select" id="new_departemen" name="departemen" onchange="fetchDoctorsBaru()">
                                            <option value="">Pilih Departemen</option>
                                            @foreach ($departemenList as $departemen)
                                                <option value="{{ $departemen->id }}">{{ $departemen->nama_departemen }}</option>
                                            @endforeach
                                        </select>                                
                                    </div>                                 
                                </div>                             
                            </div>     
                            <div class="col-sm-6">                                 
                                <div class="take-appointment__form-input">                                     
                                    <label for="new_dokter">Dokter</label>                                     
                                    <div class="take-appointment__form-input-select">                                         
                                        <select id="new_dokter" name="dokter">
                                            <option value="">Pilih Dokter...</option>
                                        </select>                                     
                                    </div>                                 
                                </div>                             
                            </div>                              
                            <div class="col-12">                                 
                                <button type="button" class="rr-btn rr-btn__primary-color mt-10 mt-xs-10" onclick="addNewPatient()">                                     
                                    <span class="btn-wrap">                                         
                                        <span class="text-one">Appointment Now <i class="fa-solid fa-plus"></i></span>                                         
                                        <span class="text-two">Appointment Now <i class="fa-solid fa-plus"></i></span>                                     
                                    </span>                                 
                                </button>                             
                            </div>                   
                        </div>                     
                    </div>                 
                </div>             
            </div>                 
        </div>     
    </div> 
</section>
<script>
        function fetchDoctors() {
        const departemenId = document.getElementById("departemen").value;
        const dokterSelect = $("#daftarDokterId");

        // Clear previous options
        dokterSelect.html('<option value="">Pilih Dokter...</option>');

        if (departemenId) {
            fetch(`/index/${departemenId}`)
                .then(response => response.json())
                .then(doctors => {
                    doctors.forEach(doctor => {
                        dokterSelect.append(new Option(doctor.nama_dokter, doctor.id));
                    });
                    // Refresh Nice Select to reflect the new options
                    dokterSelect.niceSelect('update');
                })
                .catch(error => console.error("Error fetching doctors:", error));
        } else {
            dokterSelect.niceSelect('update');
        }
    }
</script>
<script>
    function fetchDoctorsBaru() {
        const departemenId = document.getElementById("new_departemen").value;
        const dokterSelect = $("#new_dokter");

        dokterSelect.html('<option value="">Pilih Dokter...</option>');

        if (departemenId) {
            fetch(`/index/${departemenId}`)
                .then(response => response.json())
                .then(doctors => {
                    doctors.forEach(doctor => {
                        dokterSelect.append(new Option(doctor.nama_dokter, doctor.id));
                    });
                    dokterSelect.niceSelect('update');
                })
                .catch(error => console.error("Error fetching doctors:", error));
        } else {
            dokterSelect.niceSelect('update');
        }
    }
</script>

<script>
    function checkNoRM() {
        const noRM = document.getElementById("no_rm").value;

        if (noRM) {
            fetch(`/index/dataPasien/${noRM}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Menampilkan data pasien jika ditemukan
                        document.getElementById("nama_pasien").value = data.patient.nama_pasien;
                        document.getElementById("alamat_pasien").value = data.patient.alamat;
                        document.getElementById("telepon").value = data.patient.no_telp;
                        document.getElementById("tgllahir").value = data.patient.tgllahir;
                        document.getElementById("umur").value = data.patient.umur;
                        document.getElementById("tgl_periksa").value = data.patient.tgl_masuk;
                    } else {
                        alert("No RM tidak ditemukan.");
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    }
</script>

<script>
    function updatePatientData() {
    const no_rm = document.getElementById("no_rm").value;
    const data = {
        nama_pasien: document.getElementById("nama_pasien").value,
        alamat_pasien: document.getElementById("alamat_pasien").value,
        telepon: document.getElementById("telepon").value,
        tgllahir: document.getElementById("tgllahir").value,
        umur: document.getElementById("umur").value,
        tgl_periksa: document.getElementById("tgl_periksa").value,
        departemen: document.getElementById("departemen").value,
        daftarDokterId: document.getElementById("daftarDokterId").value
    };

    fetch(`/index/dataPasien/update/${no_rm}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(responseData => {
        if (responseData.success) {
            Swal.fire({
                icon: 'success',
                title: 'Data Updated!',
                text: responseData.message,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: responseData.message,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonText: 'OK'
        });
    });
}

</script>

<script>
        function addNewPatient() {
        const data = {
            nama_pasien: document.getElementById("new_name").value,
            alamat: document.getElementById("new_address").value,
            telepon: document.getElementById("new_phone").value,
            tgllahir: document.getElementById("new_birthdate").value,
            umur: document.getElementById("new_age").value,
            tgl_periksa: document.getElementById("new_checkup_date").value,
            departemen: document.getElementById("new_departemen").value,
            dokter_id: document.getElementById("new_dokter").value,
            jenis_kelamin: document.getElementById("new_gender").value  // Updated field name
        };
    
        fetch('/index/dataPasien/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(responseData => {
            if (responseData.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Patient Registered!',
                    text: responseData.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: responseData.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                confirmButtonText: 'OK'
            });
        });
    }
</script>

@endsection