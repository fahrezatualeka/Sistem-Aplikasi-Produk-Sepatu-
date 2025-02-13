<div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-control" id="category" name="category" disabled>
                            <option value="training" {{ $product->category == 'training' ? 'selected' : '' }}>Training</option>
                            <option value="running" {{ $product->category == 'running' ? 'selected' : '' }}>Running</option>
                            <option value="originals" {{ $product->category == 'originals' ? 'selected' : '' }}>Originals</option>
                            <option value="outdoor" {{ $product->category == 'outdoor' ? 'selected' : '' }} >Outdoor</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="purchase_price" class="form-label">Harga Pembelian</label>
                        <input type="number" class="form-control" id="purchase_price" name="purchase_price" value="{{ $product->purchase_price }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sale_price" class="form-label">Harga Penjualan</label>
                        <input type="number" class="form-control" id="sale_price" name="sale_price" value="{{ $product->sale_price }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        {{-- matikan inputan gambar --}}
                        {{-- <input type="file" class="form-control" id="image" name="image" value="{{ $product->image }}"> --}}
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}" width="80" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $product->date }}" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $product->description }}" required>
                    </div>

                </div>
            </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>