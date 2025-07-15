<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>
    <div class="container mt-5">
        <div class="card">
            <h5 class="card-header">Featured</h5>
                <div class="card-body">
                    <form action="proses_tambah_kategori.php" method="POST">
                        <div class="mb-3">
                            <label for="namaKategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="namaKategori" name="nama_kategori" required>
                        </div>
                        <button type="submit" class="btn btn-success">Update Kategori</button>
                    </form>
                </div>
        </div>

        
    </div>
</x-app-layout>
