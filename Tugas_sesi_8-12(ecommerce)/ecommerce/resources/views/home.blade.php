@extends('layouts')
@section('title', 'TokoOnline')
@section('content')
        <div class="p-5 mb-4 bg-light rounded-3 text-center">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Selamat Datang di Toko Kami</h1>
                <p class="fs-4">Temukan produk terbaik dengan penawaran menarik hanya di sini.</p>
                <button class="btn btn-primary btn-lg" type="button">Lihat Promo</button>
            </div>
        </div>
        


        <h2 class="mb-4">Produk Terbaru</h2>

        <div class="row">

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="https://placehold.co/400x300.png?text=Produk+1" class="card-img-top" alt="Nama Produk 1">
                    <div class="card-body">
                        <h5 class="card-title">Nama Produk 1</h5>
                        <p class="card-text fw-bold">Rp 150.000</p>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="https://placehold.co/400x300.png?text=Produk+2" class="card-img-top" alt="Nama Produk 2">
                    <div class="card-body">
                        <h5 class="card-title">Nama Produk 2</h5>
                        <p class="card-text fw-bold">Rp 250.000</p>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="https://placehold.co/400x300.png?text=Produk+3" class="card-img-top" alt="Nama Produk 3">
                    <div class="card-body">
                        <h5 class="card-title">Nama Produk 3</h5>
                        <p class="card-text fw-bold">Rp 300.000</p>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="https://placehold.co/400x300.png?text=Produk+4" class="card-img-top" alt="Nama Produk 4">
                    <div class="card-body">
                        <h5 class="card-title">Nama Produk 4</h5>
                        <p class="card-text fw-bold">Rp 175.000</p>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection