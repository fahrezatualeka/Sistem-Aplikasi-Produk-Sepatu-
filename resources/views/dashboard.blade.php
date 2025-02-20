@extends('layout.template')

@section('content')
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif

    <section class="container mt-5">
        <h2>Dashboard</h2>

        <!-- Statistik Produk -->
        <div class="row mb-4">
            @php
                $stats = [
                    ['Produk', 'product', 'primary', $product, 'Rp'.number_format($purchaseProduct, 0, ',', '.'), 'Rp'.number_format($saleProduct, 0, ',', '.'), 'Rp'.number_format($profitProduct, 0, ',', '.')],
                    ['Transaksi Pembelian', 'transaction_purchase', 'success', $purchase, 'Rp'.number_format($pricePurchase, 0, ',', '.'), 'Rp'.number_format($totalPurchase, 0, ',', '.')],
                    ['Transaksi Penjualan', 'transaction_sale', 'danger', $sale, 'Rp'.number_format($priceSale, 0, ',', '.'), 'Rp'.number_format($totalSale, 0, ',', '.')]
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="col-md-4 d-flex">
                    <div class="card text-white bg-{{ $stat[2] }} w-100">
                        <a href="{{ $stat[1] }}" style="text-decoration: none; color:white;">
                            <div class="card-body">
                                <h3 class="card-title">{{ $stat[0] }}: {{ $stat[3] }}</h3>
                                @for ($i = 4; $i < count($stat); $i++)
                                    <h5>{{ $stat[$i] }}</h5>
                                @endfor
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Grafik Transaksi Produk -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p>Grafik Produk</p>
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p>Grafik Transaksi</p>
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let purchase = {{ $purchaseProduct }};
            let sale = {{ $saleProduct }};
            let profit = sale - purchase;
            let totalPurchase = {{ $totalPurchase }};
            let totalSale = {{ $totalSale }};

            // grafik Produk
            new Chart(document.getElementById('productChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Pembelian', 'Penjualan'],
                    datasets: [
                        { label: 'Pembelian', data: [purchase, 0], backgroundColor: 'rgba(56, 56, 56, 0.5)', borderColor: 'rgba(40, 167, 69, 1)', borderWidth: 2 },
                        { label: 'Penjualan', data: [0, sale], backgroundColor: 'rgba(138, 116, 118, 0.5)', borderColor: 'rgba(40, 167, 69, 1)', borderWidth: 2 },
                        { label: 'Profit', data: [profit, profit], borderColor: '#FFD700', borderWidth: 3, tension: 0.4, type: 'line' }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true, suggestedMax: 10000000 } }
                }
            });

            // grafik Transaksi
            new Chart(document.getElementById('transactionChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Pembelian', 'Penjualan'],
                    datasets: [
                        { label: 'Harga', data: [{{ $pricePurchase }}, {{ $priceSale }}], borderColor: 'rgba(56, 56, 56, 0.5)', borderWidth: 3 },
                        { label: 'Subtotal', data: [{{ $totalPurchase }}, {{ $totalSale }}], borderColor: 'rgba(138, 116, 118, 0.5)', borderWidth: 3 }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true, suggestedMax: 10000000 } }
                }
            });
        });
    </script>
@endsection
