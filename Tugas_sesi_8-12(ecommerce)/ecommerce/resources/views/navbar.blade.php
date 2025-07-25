<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">TokoOnline</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-cart-fill"></i> Keranjang
                        </a>
                    </li>
                    @if (Route::has('login'))
                        <!-- <nav class="flex items-center justify-end gap-4"> -->
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard
                                    </a>
                                </li>
                                
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"> Log in
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"> Register
                                    </a>
                                </li>
                                @endif
                            @endauth
                        <!-- </nav> -->
                    @endif
                </ul>
            </div>
        </div>
    </nav>