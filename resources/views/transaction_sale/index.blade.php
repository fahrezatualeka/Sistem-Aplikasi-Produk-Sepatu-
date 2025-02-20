@extends('layout.template')

@section('content')

{{-- sweetalert --}}
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
            <h3>Data Transaksi Penjualan</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa-solid fa-plus"></i> Tambah
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
                        <th>Produk</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Tanggal Penjualan</th>
                        <th style="width: 270px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $transaction_sale)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $transaction_sale->product->name}}</td>
                            <td>{{ $transaction_sale->name }}</td>
                            <td>{{ $transaction_sale->quantity }}</td>
                            <td>Rp{{ number_format($transaction_sale->price, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($transaction_sale->subtotal, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction_sale->date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>

                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $transaction_sale->id }}"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                <form id="delete-row-{{ $transaction_sale->id }}" action="{{ route('transaction_sale.delete', $transaction_sale->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')"><i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                                <a href="{{ route('transaction_sale.invoice', $transaction_sale->id) }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-file-arrow-down"></i> Cetak Nota
                                </a>
                            </td>
                        </tr>

                        
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada transaksi penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
    {{-- modal tambah data --}}
    @include('transaction_sale.create')

    <!-- modal edit data -->
@foreach ($data as $transaction_sale)
    @include('transaction_sale.edit', ['transaction' => $transaction_sale])
@endforeach


@endsection