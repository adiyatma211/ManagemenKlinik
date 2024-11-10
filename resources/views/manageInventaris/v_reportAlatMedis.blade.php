@extends('layouts.base')

@section('konten')
<div class="page-heading">
    <h1>Inventaris Medis</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success btn-sm mt-2" onclick="openAddModal()">Tambah Barang</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Jumlah Masuk</th>
                        <th>Jumlah Keluar</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="inventory-table-body">
                    @foreach ($inventaris as $item)
                        <tr>
                            <td>
                                <img src="{{ asset('inventaris/' . basename($item->image_path)) }}" 
                                     style="width: 50px; height: 50px; object-fit: cover;" 
                                     alt="{{ $item->name }}"
                                     onerror="this.onerror=null; this.src='/default-placeholder.jpg';">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description ?? 'No Description' }}</td>
                            <td>{{ $item->jumlah_masuk }}</td>
                            <td>{{ $item->jumlah_keluar }}</td>
                            <td>{{ $item->total }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $item->id }})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteItem({{ $item->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemModalLabel">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="itemForm" enctype="multipart/form-data">
                    <input type="hidden" id="itemId">
                    <div class="mb-3">
                        <label for="itemName" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="itemName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemDescription" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="itemDescription" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="itemJumlahMasuk" class="form-label">Jumlah Masuk</label>
                        <input type="number" class="form-control" id="itemJumlahMasuk" name="jumlah_masuk" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemJumlahKeluar" class="form-label">Jumlah Keluar</label>
                        <input type="number" class="form-control" id="itemJumlahKeluar" name="jumlah_keluar" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemImage" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="itemImage" name="image">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveItem()">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
function fetchInventoryData() {
    fetch('/getInventoryItems')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tableBody = document.getElementById('inventory-table-body');
                tableBody.innerHTML = data.data.map(item => {
                    // Set a placeholder image initially
                    const placeholderUrl = '/default-placeholder.jpg';
                    const imageUrl = item.image_path 
                        ? `/storage/${item.image_path}`
                        : placeholderUrl;

                    return `
                        <tr>
                            <td>
                                <img src="${placeholderUrl}" 
                                     style="width: 50px; height: 50px; object-fit: cover;" 
                                     alt="${item.name}"
                                     data-real-src="${imageUrl}" 
                                     onload="setTimeout(() => this.src=this.dataset.realSrc, 1000)">
                            </td>
                            <td>${item.name}</td>
                            <td>${item.description || 'No Description'}</td>
                            <td>${item.jumlah_masuk}</td>
                            <td>${item.jumlah_keluar}</td>
                            <td>${item.total}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="openEditModal(${item.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteItem(${item.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                }).join('');
            } else {
                Swal.fire("Error", "Failed to fetch inventory data", "error");
            }
        })
        .catch(error => console.error('Error fetching inventory data:', error));
}


    
    // Function to open the modal for adding a new item
function openAddModal() {
    document.getElementById('itemModalLabel').innerText = 'Tambah Barang';
    document.getElementById('itemId').value = '';
    document.getElementById('itemForm').reset();
    new bootstrap.Modal(document.getElementById('itemModal')).show();
}

// Function to open the modal for editing an item
function openEditModal(id) {
    fetch(`/getInventoryItem/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('itemModalLabel').innerText = 'Edit Barang';
                document.getElementById('itemId').value = data.item.id;
                document.getElementById('itemName').value = data.item.name;
                document.getElementById('itemDescription').value = data.item.description;
                document.getElementById('itemJumlahMasuk').value = data.item.jumlah_masuk;
                document.getElementById('itemJumlahKeluar').value = data.item.jumlah_keluar;
                
                new bootstrap.Modal(document.getElementById('itemModal')).show();
            } else {
                Swal.fire("Error", "Failed to load item data", "error");
            }
        })
        .catch(error => console.error('Error fetching item data:', error));
}


// Function to save the item (create or update)
function saveItem() {
    const formData = new FormData(document.getElementById('itemForm'));
    const id = document.getElementById('itemId').value;
    const url = id ? `/updateInventoryItem/${id}` : '/saveInventoryItem';
    const method = id ? 'POST' : 'POST';

    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('itemModal')).hide();
            Swal.fire({
                icon: 'success',
                title: id ? 'Updated!' : 'Added!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            // Force a full page reload after success to ensure all images and data are loaded
            setTimeout(() => window.location.reload(), 2000);
        } else {
            Swal.fire("Error", data.message, "error");
        }
    })
    .catch(error => Swal.fire('Error', 'An error occurred while saving the item.', 'error'));
}



// Function to delete an item with confirmation
function deleteItem(id) {
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
            fetch(`/deleteInventoryItem/${id}`, {
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
                
                // Force a full page reload after success to ensure the table updates
                if (result.success) setTimeout(() => window.location.reload(), 2000);
            })
            .catch(error => Swal.fire('Error', 'An error occurred while deleting the item.', 'error'));
        }
    });
}

</script>

@endsection
