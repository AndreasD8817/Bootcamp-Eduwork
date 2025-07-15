<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Produk') }}
        </h2>
    </x-slot>
    <div class="container mt-5">

        <a href="{{ route('products-tambah') }}" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center text-light">
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama Kategori</th>
                        <th>Deskprisi</th>
                        <th>Jumlah Produk</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><img src="https://placehold.co/100x100.png" alt="Kategori 1" class="img-fluid rounded"></td>
                        <td>Elektronik</td>
                        <td>Ini Deskripsi Singkat Kategori 1</td>
                        <td>150</td>
                        <td>150.000</td>
                        <td>
                            <a href="{{ route('products-edit') }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>