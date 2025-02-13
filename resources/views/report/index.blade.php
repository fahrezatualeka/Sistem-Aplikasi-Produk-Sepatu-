@extends('layout/template')

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
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Data Laporan</h3>
        </div>

        {{-- filter --}}
        <div class="card-body">
            <form action="{{ route('report.filter') }}" method="GET" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <label for="search">Pencarian:</label>
                        <input type="text" name="search" class="form-control" id="search" placeholder="- Semua -" value="{{ request()->search }}">
                    </div>
                    <div class="col-md-2">
                        <label for="category">Kategori:</label>
                        <select name="category" class="form-control" id="category">
                            <option value="">- Semua -</option>
                            <option value="training" {{ request()->category == 'training' ? 'selected' : '' }}>Training</option>
                            <option value="running" {{ request()->category == 'running' ? 'selected' : '' }}>Running</option>
                            <option value="originals" {{ request()->category == 'originals' ? 'selected' : '' }}>Originals</option>
                            <option value="outdoor" {{ request()->category == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="transaction_type">Jenis Transaksi:</label>
                        <select name="transaction_type" class="form-control" id="transaction_type">
                            <option value="">- Semua -</option>
                            <option value="pembelian" {{ request()->transaction_type == 'pembelian' ? 'selected' : '' }}>Pembelian</option>
                            <option value="penjualan" {{ request()->transaction_type == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>


        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0px">No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Pembelian</th>
                        <th>Harga Penjualan</th>
                        <th>Stok</th>
                        <th>Profit/Keuntungan</th>
                        <th>Nama Customer</th>
                        <th>Jenis Transaksi</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $report)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>{{ $report->product->name ?? 'Produk tidak ditemukan' }}</td>

                            <td>{{ ucfirst($report->category) }}</td>
                            
                            <td>Rp {{ number_format($report->purchase_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($report->sale_price, 0, ',', '.') }}</td>
                            <td>{{ $report->stock }}</td>
                            <td>Rp {{ number_format($report->profit, 0, ',', '.') }}</td>
                            
                            
                            
                            <td>{{ $report->name ?? 'Tidak ada customer' }}</td>
                            <td>{{ $report->transaction_type ?? 'Tidak ada transaksi' }}</td>


                            <td>{{ $report->quantity }}</td>
                            <td>Rp {{ number_format($report->subtotal, 0, ',', '.') }}</td>
                            <td>{{ date('d-m-Y', strtotime($report->date)) }}</td>

                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- export excel dan pdf --}}
                <a href="{{ route('report.exportExcel') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('report.exportPdf') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </a>
        </div>
    </div>
</section>




<script>

// script utk perubahan filter tanpa tombol
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("filterForm"); // ambil elemen form berdsarkan id


    // loop semua input dan select dalam form
    form.querySelectorAll("input, select").forEach(element => {
        element.addEventListener("change", function () {
            form.submit();
        });

        if (element.type === "text") {
            let typingTimer;
            element.addEventListener("keyup", function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => form.submit(), 500);
            });
        }
    });
});
</script>
@endsection
