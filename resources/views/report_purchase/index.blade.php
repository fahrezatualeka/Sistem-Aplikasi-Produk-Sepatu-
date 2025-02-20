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
            <h3>Data Laporan Pembelian</h3>
        </div>

        

{{-- filter --}}
<div class="card-body">
    <form action="{{ route('report_purchase.filter') }}" method="GET" id="filterForm">
        <div class="row">
            {{-- cari --}}
            <div class="col-md-3">
                <label for="search">Pencarian:</label>
                <input type="text" name="search" class="form-control" id="search" placeholder="- Semua -" value="{{ request()->search }}">
            </div>
    
            {{-- brand --}}
            <div class="col-md-2">
                <label for="brand">Pilih Brand:</label>
                <select name="brand" class="form-control" id="brand">
                    <option value="">- Semua -</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request()->brand == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            {{-- kategori --}}
            <div class="col-md-2">
                <label for="category">Pilih Kategori:</label>
                <select name="category" class="form-control" id="category">
                    <option value="">- Semua -</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            {{-- bulan --}}
            <div class="col-md-2">
                <label for="month">Pilih Bulan:</label>
                <select name="month" class="form-control" id="month">
                    <option value="">- Semua -</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request()->month == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->locale('id')->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
    
            {{-- tahun --}}
            <div class="col-md-2">
                <label for="year">Pilih Tahun:</label>
                <select name="year" class="form-control" id="year">
                    <option value="">- Semua -</option>
                    @for ($i = now()->year; $i >= now()->year - 2; $i--)
                        <option value="{{ $i }}" {{ request()->year == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
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
                        <th>Brand</th>
                        <th>Kategori</th>
                        <th>Produk</th>
                        <th>Pemasok</th>
                        <th>Harga Pembelian</th>
                        <th>Harga Penjualan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Profit/Keuntungan</th>
                        <th>Tanggal Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $report_purchase)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $report_purchase->brand->name}}</td>
                            <td>{{ $report_purchase->category->name}}</td>
                            <td>{{ $report_purchase->product->name}}</td>
                            <td>{{ $report_purchase->name}}</td>  
                            <td>Rp{{ number_format($report_purchase->purchase_price, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($report_purchase->sale_price, 0, ',', '.') }}</td>
                            <td>{{ $report_purchase->quantity }}</td>
                            <td>Rp{{ number_format($report_purchase->subtotal, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($report_purchase->profit, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($report_purchase->date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada laporan pembelian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- export excel dan pdf --}}
            <a href="{{ route('report_purchase.exportExcel', request()->query()) }}" class="btn btn-secondary">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('report_purchase.exportPdf', request()->query()) }}" class="btn btn-secondary">
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
                    typingTimer = setTimeout(() => form.submit(), 750);
                });
            }
        });
    });
</script>
@endsection
