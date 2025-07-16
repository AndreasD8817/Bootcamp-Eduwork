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
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td><img src="{{$product->image}}" alt="Kategori 1" class="img-fluid rounded" style="max-height: 100px;"></td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->stock}}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('products-edit') }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->links()}}
    </div>
</x-app-layout>