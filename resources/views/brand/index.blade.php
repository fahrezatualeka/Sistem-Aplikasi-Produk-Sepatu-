@extends('layout.template')

@section('content')



{{-- swetalert --}}
@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
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
            <h3>Data Merek</h3>
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
                        <th>Nama Brand</th>
                        <th>Gambar</th>
                        <th style="width: 160px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $key => $brand)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                @if($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" width="50">
                                @else
                                Tidak ada gambar
                                @endif
                            </td>

                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $brand->id }}"><i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <form id="delete-row-{{ $brand->id }}" action="{{ route('brand.delete', $brand->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"><i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- modal tambah data -->
@include('brand.create')

<!-- modal edit data -->
@foreach ($data as $brand)
    @include('brand.edit', ['brand' => $brand])
@endforeach

@endsection