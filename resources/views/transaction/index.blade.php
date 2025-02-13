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
            <h3>Data Transaksi</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Tambah <i class="fas fa-plus"></i>
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
                        <th>Nama Customer</th>
                        <th>Jenis Transaksi</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Tanggal</th>
                        <th style="width: 125px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $transaction)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $transaction->product->name ?? 'Produk tidak ditemukan' }}</td>
                            <td>{{ $transaction->name }}</td>
                            <td>{{ $transaction->transaction_type }}</td>
                            <td>{{ $transaction->quantity }}</td>
                            <td>Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                            <td>{{ date('d-m-Y', strtotime($transaction->date)) }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $transaction->id }}">
                                    Edit
                                </button>
                                <form id="delete-row-{{ $transaction->id }}" action="{{ route('transaction.delete', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- modal edit data -->
                        @include('transaction.edit', ['transaction' => $transaction])

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- modal tambah data --}}
@include('transaction.create')

@endsection