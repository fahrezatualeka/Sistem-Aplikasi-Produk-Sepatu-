<style>
    .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="product-container">
                        <!-- item pertama tanpa tombol hapus -->
                        <div class="product-item row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Brand</label>
                                <select class="form-control brand-select" name="brand_id[]" required>
                                    <option value="" disabled selected>- Pilih -</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <select class="form-control category-select" name="category_id[]" required>
                                    <option value="" disabled selected>- Pilih -</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="name[]" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Pembelian</label>
                                <input type="number" class="form-control" name="purchase_price[]" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Penjualan</label>
                                <input type="number" class="form-control" name="sale_price[]" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stock[]" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="image[]" accept="image/*">
                            </div>
                        </div>
                    </div>

                    {{-- tombol tambah produk lebih dari 1 --}}
                    <button type="button" class="btn btn-primary mt-3" id="btnTambahProduk">
                        <i class="fa-solid fa-plus"></i> Tambah</button>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productContainer = document.getElementById("product-container"); // container utama untuk produk
        const btnTambahProduk = document.getElementById("btnTambahProduk"); //tombol untuk menambah produk baru

        function addProductRow() {
            // membuat elemen div baru untuk produk tambahan
            let productItem = document.createElement("div");
            productItem.classList.add("product-item", "row", "align-items-center", "mb-2");

            // menambahkan input form untuk produk
            productItem.innerHTML = `
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Brand</label>
                    <select class="form-control brand-select" name="brand_id[]" required>
                        <option value="" disabled selected>- Pilih -</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <select class="form-control category-select" name="category_id[]" required>
                        <option value="" disabled selected>- Pilih -</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" name="name[]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Pembelian</label>
                    <input type="number" class="form-control" name="purchase_price[]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Penjualan</label>
                    <input type="number" class="form-control" name="sale_price[]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stock[]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" class="form-control" name="image[]" accept="image/*">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-end mt-4">
                    <button type="button" class="btn btn-danger btn-remove-product">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;

            // menambahkan elemen produk baru ke dalam container
            productContainer.appendChild(productItem);

            // menambahkan event listener ke tombol hapus yang baru dibuat
            productItem.querySelector(".btn-remove-product").addEventListener("click", function () {
                productItem.remove(); // menghapus elemen produk saat tombol diklik
                toggleRemoveButton(); // memeriksa apakah tombol hapus perlu ditampilkan
            });

            toggleRemoveButton(); // memeriksa status tombol hapus setelah menambah produk
        }

        function toggleRemoveButton() {
            let productItems = productContainer.querySelectorAll(".product-item"); // mengambil semua item produk
            let removeButtons = productContainer.querySelectorAll(".btn-remove-product"); // mengambil semua tombol hapus

            // jika hanya ada satu produk, sembunyikan tombol hapus
            if (productItems.length === 1) {
                removeButtons.forEach(button => button.style.display = "none");
            } else {
                removeButtons.forEach(button => button.style.display = "inline-block"); // tampilkan tombol hapus jika lebih dari satu produk
            }
        }

        // event listener untuk tombol tambah produk
        btnTambahProduk.addEventListener("click", addProductRow);

        // memastikan tombol hapus dalam kondisi awal yang benar
        toggleRemoveButton();
    });
</script>