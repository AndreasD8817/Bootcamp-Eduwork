@extends('layouts')
@section('title', 'TokoOnline')
@section('content')
            <style>
                .thumbnail_product {
                    background-position: center;
                    background-size: cover;
                    height: 300px;
                    weidth: 100px;
                }
            </style>
        <div class="p-5 mb-4 bg-light rounded-3 text-center">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Selamat Datang di Toko Kami</h1>
                <p class="fs-4">Temukan produk terbaik dengan penawaran menarik hanya di sini.</p>
                <button class="btn btn-primary btn-lg" type="button">Lihat Promo</button>
            </div>
        </div>
        <h2 class="mb-4">Produk Terbaru</h2>

        <div class="row">
        @foreach($product as $products)
            
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="thumbnail_product" style="background-image: url('{{ $products->image }}');">
                    </div>
                    <!-- <img src="{{ $products->image }}" class="card-img-top" alt="Nama Produk 1"> -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $products->name }}</h5>
                        <p class="card-text fw-bold">{{ $products->price }}</p>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12 mt-4">
                {{ $product->links()}}
        </div>
    </div>
@endsection