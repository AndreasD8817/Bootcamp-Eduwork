<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori Produk') }}
        </h2>
    </x-slot>
    <div class="container mt-5">

        <a href="{{ route('categories-products-tambah') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center text-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td class="text-center">{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">{{ $category->product_count }}</td>
                        <td>
                            <a href="{{ route('categories-products-edit') }}" class="btn btn-warning btn-sm me-2 justify-content-center">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm justify-content-center">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>