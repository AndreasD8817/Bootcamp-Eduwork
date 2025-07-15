<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class ="container">
                        <div class="row align-items-stretch ">
                            <div class="col-md-4 mb-4"> <div class="card h-100 bg-primary-subtle"> <div class="card-header">
                                        Jumlah Produk
                                    </div>
                                    <div class="card-body d-flex flex-column"> <h1 class="card-title fw-bold" style="font-size: 30px">150</h1>
                                        <p class="card-text mt-auto">Total Jumlah Produk Yang Tersedia di sistem</p> </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 bg-success-subtle">
                                    <div class="card-header">
                                        Jumlah Klik Produk
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h1 class="card-title fw-bold" style="font-size: 30px">2500</h1>
                                        <p class="card-text mt-auto">Total Klik pada produk yang telah di lihat pengguna.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 bg-warning-subtle">
                                    <div class="card-header">
                                        Jumlah Kategori Produk
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h1 class="card-title fw-bold" style="font-size: 30px">60</h1>
                                        <p class="card-text mt-auto">Total Jumlah Kategori Produk yang tersedia di sistem.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
