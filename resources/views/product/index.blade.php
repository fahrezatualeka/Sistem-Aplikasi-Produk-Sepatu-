@extends('layout.template')

@section('content')

{{-- swetalert --}}
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
            <h3>Data Produk</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Tambah
                <i class="fas fa-plus"></i>
            </button>
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
                        <th>Gambar</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th style="width: 125px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ ucfirst($product->category) }}</td>
                            <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($product->sale_price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" width="50">
                                @else
                                Tidak ada gambar
                                @endif
                            </td>
                            <td>{{ date('d-m-Y', strtotime($product->date)) }}</td>
                            <td>{{ Str::limit($product->description, 50) }}</td>

                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $product->id }}">
                                    Edit
                                </button>
                                <form id="delete-row-{{ $product->id }}" action="{{ route('product.delete', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- modal tambah data -->
@include('product.create')

<!-- modal edit data -->
@foreach ($data as $product)
    @include('product.edit', ['product' => $product])
@endforeach

@endsection