<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>
    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-body">
                <form action="proses_tambah_produk.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="namaProduk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="namaProduk" name="nama_produk" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsiProduk" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsiProduk" name="deskripsi_produk" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="stokProduk" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stokProduk" name="stok_produk" min="0" required>
                        </div>

                    <div class="mb-3">
                        <label for="hargaProduk" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="hargaProduk" name="harga_produk" step="0.01" min="0" required>
                            </div>
                    </div>

                    <div class="mb-3">
                        <label for="gambarProduk" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="gambarProduk" name="gambar_produk" accept="image/*">
                        </div>

                    <div class="mb-3">
                        <label for="kategoriProduk" class="form-label">Kategori Produk</label>
                        <select class="form-select" id="kategoriProduk" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            <option value="1">Elektronik</option>
                            <option value="2">Pakaian</option>
                            <option value="3">Makanan & Minuman</option>
                            </select>
                    </div>

                        <button type="submit" class="btn btn-success">Simpan Edit Produk</button>
                        <a href="produk_list.html" class="btn btn-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>

        
</x-app-layout>