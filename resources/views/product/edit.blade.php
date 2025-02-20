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
                            <label for="brand_name_{{ $product->id }}" class="form-label">Nama Merek</label>
                            <input type="text" class="form-control" id="brand_name_{{ $product->id }}" name="brand_name" value="{{ $product->brand->name }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_name_{{ $product->id }}" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="category_name_{{ $product->id }}" name="category_name" value="{{ $product->category->name }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name_{{ $product->id }}" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name_{{ $product->id }}" name="name" value="{{ old('name', $product->name) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="purchase_price_{{ $product->id }}" class="form-label">Harga Pembelian</label>
                            <input type="number" class="form-control" id="purchase_price_{{ $product->id }}" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sale_price_{{ $product->id }}" class="form-label">Harga Penjualan</label>
                            <input type="number" class="form-control" id="sale_price_{{ $product->id }}" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock_{{ $product->id }}" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock_{{ $product->id }}" name="stock" value="{{ old('stock', $product->stock) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="image_{{ $product->id }}" class="form-label">Gambar (Opsional)</label>
                            <input type="file" class="form-control" id="image_{{ $product->id }}" name="image">
                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" width="80" class="img-thumbnail">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>