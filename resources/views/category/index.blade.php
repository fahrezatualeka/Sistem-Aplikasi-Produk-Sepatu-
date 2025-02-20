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
            <h3>Data Kategori</h3>
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
                        <th>Nama Kategori</th>
                        <th style="width: 160px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $key => $category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $category->id }}"><i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <form id="delete-row-{{ $category->id }}" action="{{ route('category.delete', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"><i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- modal tambah data -->
@include('category.create')

<!-- modal edit data -->
@foreach ($data as $category)
    @include('category.edit', ['category' => $category])
@endforeach

@endsection