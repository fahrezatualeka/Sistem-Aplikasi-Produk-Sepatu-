<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Aplikasi Produk (Sepatu)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    
  </head>
  <body>

    

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a class="nav-link active" href="{{ url('dashboard') }}">Dashboard</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link active" href="{{ url('brand') }}">Merek</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="{{ url('category') }}">Kategori</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="{{ url('product') }}">Produk</a>
                  </li>
                  
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" role="button" aria-expanded="false">Transaksi</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="transaction_purchase">Pembelian</a></li>
                      <li><a class="dropdown-item" href="transaction_sale">Penjualan</a></li>
                    </ul>
                  </li>

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" role="button" aria-expanded="false">Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="report_purchase">Pembelian</a></li>
                        <li><a class="dropdown-item" href="report_sale">Penjualan</a></li>
                    </ul>
                  </li>
              </ul>
  
              <ul class="navbar-nav ms-auto">
                  @auth
                      <li class="nav-item dropdown">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                             data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                          </a>
  
                          <ul class="dropdown-menu dropdown-menu-end">
                              <li>
                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();"><i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                                  </a>
                              </li>
                          </ul>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </li>
                  @endauth
              </ul>
          </div>
      </div>
  </nav>

    {{-- body setiap halaman --}}
    @yield('content')

  </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>