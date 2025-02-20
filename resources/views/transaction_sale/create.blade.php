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
                <h5 class="modal-title">Tambah Transaksi Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaction_sale.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="transaksi-container">
                        <div class="transaksi-item row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Produk</label>
                                <select class="form-control product-select" name="product_id[]">
                                    <option value="" disabled selected>- Pilih -</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-harga="{{ $product->sale_price }}" data-stock="{{ $product->stock }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pelanggan</label>
                                <input type="text" class="form-control name-input" name="name[]">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah</label>
                                <select class="form-control quantity-input" name="quantity[]" required>
                                    <option value="" disabled selected>- Pilih -</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="text" class="form-control price-input" name="price[]" disabled>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Subtotal</label>
                                <input type="text" class="form-control subtotal-input" name="subtotal[]" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal Penjualan</label>
                                <input type="date" class="form-control date-input" name="date[]" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary mt-3" id="btnTambahTransaksi"><i class="fa-solid fa-plus"></i> Tambah</button>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // dapat elemen utama yang digunakan dalam transaksi
        const transaksiContainer = document.getElementById("transaksi-container");
        const btnTambahTransaksi = document.getElementById("btnTambahTransaksi");

        // fungsi untuk menghitung subtotal berdasarkan harga dan jumlah produk
        function updateSubtotal(transaksiItem) {
            let priceInput = transaksiItem.querySelector(".price-input");
            let quantityInput = transaksiItem.querySelector(".quantity-input");
            let subtotalInput = transaksiItem.querySelector(".subtotal-input");

            let price = parseFloat(priceInput.value) || 0; // ambil harga atau default 0
            let quantity = parseInt(quantityInput.value) || 1; // ambil jumlah atau default 1

            subtotalInput.value = price * quantity; // hitung subtotal
        }

        // fungsi untuk memperbarui pilihan jumlah (quantity) berdasarkan stok produk
        function updateQuantityOptions(transaksiItem, stock) {
            let quantityInput = transaksiItem.querySelector(".quantity-input");
            quantityInput.innerHTML = '<option value="" disabled selected>- Pilih -</option>';

            // Menambahkan pilihan jumlah berdasarkan stok yang tersedia
            for (let i = 1; i <= stock; i++) {
                let option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                quantityInput.appendChild(option);
            }
        }

        //fungsi untuk memperbarui harga dan subtotal saat produk dipilih
        function updatePriceAndSubtotal(event) {
            let transaksiItem = event.target.closest(".transaksi-item");
            let productSelect = transaksiItem.querySelector(".product-select");
            let priceInput = transaksiItem.querySelector(".price-input");

            let selectedOption = productSelect.options[productSelect.selectedIndex];
            let price = selectedOption.getAttribute("data-harga") || 0;
            let stock = selectedOption.getAttribute("data-stock") || 0;

            priceInput.value = price; // Set harga produk
            updateQuantityOptions(transaksiItem, stock); // Perbarui pilihan jumlah
            updateSubtotal(transaksiItem); // Perbarui subtotal
        }

        //fungsi untuk menambahkan baris transaksi baru
        function addTransactionRow() {
            let transaksiItem = document.createElement("div");
            transaksiItem.classList.add("transaksi-item", "row");
            transaksiItem.innerHTML = `
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Produk</label>
                    <select class="form-control product-select" name="product_id[]" required>
                        <option value="" disabled selected>- Pilih -</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-harga="{{ $product->sale_price }}" data-stock="{{ $product->stock }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5 mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control name-input" name="name[]" required>
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-end mt-4">
                    <button type="button" class="btn btn-danger btn-remove-transaksi"><i class="fa-solid fa-trash"></i></button>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Jumlah</label>
                    <select class="form-control quantity-input" name="quantity[]" required>
                        <option value="" disabled selected>- Pilih -</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" class="form-control price-input" name="price[]" disabled>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Subtotal</label>
                    <input type="text" class="form-control subtotal-input" name="subtotal[]" disabled>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Penjualan</label>
                    <input type="date" class="form-control date-input" name="date[]" required>
                </div>
            `;

            transaksiContainer.appendChild(transaksiItem);

            // tambah event listener ke elemen-elemen baru yang dibuat
            transaksiItem.querySelector(".product-select").addEventListener("change", updatePriceAndSubtotal);
            transaksiItem.querySelector(".quantity-input").addEventListener("change", function () {
                updateSubtotal(transaksiItem);
            });

            // menghapus transaksi jika tombol hapus diklik
            transaksiItem.querySelector(".btn-remove-transaksi").addEventListener("click", function () {
                transaksiItem.remove();
                toggleRemoveButtons();
            });

            toggleRemoveButtons(); // periksa apakah tombol hapus perlu ditampilkan
        }

        //fungsi untuk mengatur tampilan tombol hapus
        function toggleRemoveButtons() {
            let transaksiItems = transaksiContainer.querySelectorAll(".transaksi-item");
            let removeButtons = transaksiContainer.querySelectorAll(".btn-remove-transaksi");

            if (transaksiItems.length > 1) {
                removeButtons.forEach(button => button.style.display = "inline-block");
            } else {
                removeButtons.forEach(button => button.style.display = "none");
            }
        }

        // event listener untuk menambahkan baris transaksi saat tombol tambah diklik
        btnTambahTransaksi.addEventListener("click", addTransactionRow);
        
        //menambahkan event listener pada elemen produk yang sudah ada di dalam modal
        document.querySelectorAll(".product-select").forEach(select => {
            select.addEventListener("change", updatePriceAndSubtotal);
        });

        // tambah event listener untuk memperbarui subtotal saat jumlah berubah
        document.querySelectorAll(".quantity-input").forEach(input => {
            input.addEventListener("change", function () {
                let transaksiItem = input.closest(".transaksi-item");
                updateSubtotal(transaksiItem);
            });
        });

        toggleRemoveButtons(); // panggil fungsi untuk mengatur tampilan awal tombol hapus
    });
</script>