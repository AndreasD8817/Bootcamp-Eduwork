<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori Produk') }}
        </h2>
    </x-slot>
    <div class="container mt-5">

        <a href="#" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center text-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Elektronik</td>
                        <td>150</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Pakaian</td>
                        <td>230</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Makanan & Minuman</td>
                        <td>80</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>