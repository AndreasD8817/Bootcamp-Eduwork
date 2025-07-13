@extends('layouts')
@section('title', 'Shopping Cart')
@section('content')
    <main class="container my-5">
        <h1 class="mb-4">Keranjang Belanja Anda</h1>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-end">Subtotal</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://placehold.co/100x100.png" alt="Produk 1" class="img-fluid rounded me-3" style="width: 75px;">
                                    <div>
                                        <h6 class="mb-0">Nama Produk 1</h6>
                                        <small class="text-muted">Deskripsi singkat produk</small>
                                    </div>
                                </div>
                            </td>
                            <td>Rp 150.000</td>
                            <td class="text-center">
                                <input type="number" value="1" min="1" class="form-control" style="width: 70px; margin: auto;">
                            </td>
                            <td class="text-end">Rp 150.000</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://placehold.co/100x100.png" alt="Produk 2" class="img-fluid rounded me-3" style="width: 75px;">
                                    <div>
                                        <h6 class="mb-0">Nama Produk 2</h6>
                                        <small class="text-muted">Deskripsi lain yang bagus</small>
                                    </div>
                                </div>
                            </td>
                            <td>Rp 250.000</td>
                            <td class="text-center">
                                <input type="number" value="2" min="1" class="form-control" style="width: 70px; margin: auto;">
                            </td>
                            <td class="text-end">Rp 500.000</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-top-0">
                <div class="d-flex justify-content-end">
                    <div class="text-end" style="width: 300px;">
                        <h5 class="mb-3">Total Keranjang</h5>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp 650.000</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span>Rp 20.000</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>Rp 670.000</span>
                        </div>
                        <a href="#" class="btn btn-primary w-100 mt-3">Lanjut ke Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection