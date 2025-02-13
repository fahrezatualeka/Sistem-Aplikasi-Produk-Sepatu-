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
                timer: 2000
            });
        });
    </script>
@endif

<section class="container mt-5">
    
    <h3>Dashboard</h3>

    <!-- statistik produk -->
    <div class="row mb-4">
        {{-- kolom total produk --}}
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Stok Produk</h5>
                    <p class="card-text fs-3">{{ $totalStock }}</p>
                </div>
            </div>
        </div>

        {{-- kolom total harga beli --}}
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Harga Beli</h5>
                    <p class="card-text fs-3">Rp {{ number_format($totalPurchasePrice, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- kolom total harga jual --}}
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total Harga Jual</h5>
                    <p class="card-text fs-3">Rp {{ number_format($totalSalePrice, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- kolom total selisih --}}
        <div class="col-md-3">
            <div class="card text-white" style="background-color: grey">
                <div class="card-body">
                    <h5 class="card-title">Total Selisih</h5>
                    <p class="card-text fs-3">Rp {{ number_format($totalSelisihPrice, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- grafik transaksi produk -->
    <div class="row">
        <!-- kolom diagram batang -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p>Diagram Batang</p>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <!-- kolom diagram garis -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p>Diagram Garis</p>
                    <canvas id="comparisonChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // animasi diagram batang
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Total Harga Beli', 'Total Harga Jual'],
                datasets: [{
                    data: [{{ $totalPurchasePrice }}, {{ $totalSalePrice }}],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Menghilangkan kotak legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // animasi diagram garis
        var ctxComparison = document.getElementById('comparisonChart').getContext('2d');
        var comparisonChart = new Chart(ctxComparison, {
            type: 'line',
            data: {
                labels: ['Total Harga Beli', 'Total Harga Jual'],
                datasets: [{
                    data: [{{ $totalPurchasePrice }}, {{ $totalSalePrice }}],
                    borderColor: '#6c5337',
                    backgroundColor: 'rgba(255, 204, 0, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Menghilangkan kotak legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection