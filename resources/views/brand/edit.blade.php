<!-- Modal untuk Edit Merek -->
<div class="modal fade" id="modalEdit{{ $brand->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $brand->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Edit Merek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Merek</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $brand->name }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Gambar (Opsional)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            
                            <!-- menampilkan gambar lama jika tersedia -->
                            @if($brand->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $brand->image) }}" width="80" class="img-thumbnail">
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>