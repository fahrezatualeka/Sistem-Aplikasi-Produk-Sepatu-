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
                <h5 class="modal-title">Tambah Transaksi Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaction_purchase.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="transaksi-container">
                        <div class="transaksi-item row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Produk</label>
                                <select class="form-control product-select" name="product_id[]">
                                    <option value="" disabled selected>- Pilih -</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" 
                                            data-harga="{{ $product->purchase_price }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Pemasok</label>
                                <input type="text" class="form-control name-input" name="name[]">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control quantity-input" name="quantity[]" min="1" value="1">
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
                                <label class="form-label">Tanggal Pembelian</label>
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
        const transaksiContainer = document.getElementById("transaksi-container");
        const btnTambahTransaksi = document.getElementById("btnTambahTransaksi");

        //fungsi untuk memperbarui subtotal berdasarkan harga dan jumlah
        function updateSubtotal(transaksiItem) {
            let priceInput = transaksiItem.querySelector(".price-input");
            let quantityInput = transaksiItem.querySelector(".quantity-input");
            let subtotalInput = transaksiItem.querySelector(".subtotal-input");

            let price = parseFloat(priceInput.value) || 0; // ambil harga, jika tidak ada maka 0
            let quantity = parseInt(quantityInput.value) || 1; // ambil jumlah, jika tidak ada maka 1

            subtotalInput.value = price * quantity; // hitung subtotal
        }

        // fungsi untuk memperbarui harga dan subtotal saat produk dipilih
        function updatePriceAndSubtotal(event) {
            let transaksiItem = event.target.closest(".transaksi-item"); // ambil elemen transaksi terkait
            let productSelect = transaksiItem.querySelector(".product-select");
            let priceInput = transaksiItem.querySelector(".price-input");

            let selectedOption = productSelect.options[productSelect.selectedIndex]; // ambil opsi yang dipilih
            let price = selectedOption.getAttribute("data-harga") || 0; // ambil hargaa dari atribut data-harga

            priceInput.value = price; // perbarui input harga
            updateSubtotal(transaksiItem); // hitung ulang subtotal
        }

        // fungsi untuk menambahkan baris transaksi baru
        function addTransactionRow() {
            let transaksiItem = document.createElement("div");
            transaksiItem.classList.add("transaksi-item", "row"); // tamba kelas transaksi-item dan row
            transaksiItem.innerHTML = `
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Produk</label>
                    <select class="form-control product-select" name="product_id[]">
                        <option value="" disabled selected>- Pilih -</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-harga="{{ $product->purchase_price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5 mb-3">
                    <label class="form-label">Nama Pemasok</label>
                    <input type="text" class="form-control name-input" name="name[]">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-end mt-4">
                    <button type="button" class="btn btn-danger btn-remove-transaksi"><i class="fa-solid fa-trash"></i></button>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control quantity-input" name="quantity[]" min="1" value="1">
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
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" class="form-control date-input" name="date[]" required>
                </div>
            `;

            transaksiContainer.appendChild(transaksiItem); // tambahkan elemen baru ke dalam container transaksi

            // Ttambahkan event listener ke elemen-elemen baru
            transaksiItem.querySelector(".product-select").addEventListener("change", updatePriceAndSubtotal);
            transaksiItem.querySelector(".quantity-input").addEventListener("input", function () {
                updateSubtotal(transaksiItem);
            });

            // tambahkan event listener untuk tombol hapus transaksi
            transaksiItem.querySelector(".btn-remove-transaksi").addEventListener("click", function () {
                transaksiItem.remove();
                toggleRemoveButtons();
            });

            toggleRemoveButtons(); // Perbarui tampilan tombol hapus
        }

        // fungsi untuk menampilkan atau menyembunyikan tombol hapus transaksi
        function toggleRemoveButtons() {
            let transaksiItems = transaksiContainer.querySelectorAll(".transaksi-item");
            let removeButtons = transaksiContainer.querySelectorAll(".btn-remove-transaksi");

            if (transaksiItems.length > 1) {
                removeButtons.forEach(button => button.style.display = "inline-block"); // tampill tombol hapus jika lebih dari satu transaksi
            } else {
                removeButtons.forEach(button => button.style.display = "none"); // sembunyikan tombol hapus jika hanya satu transaksi
            }
        }

        btnTambahTransaksi.addEventListener("click", addTransactionRow); // tambahkan event listener untuk tombol tambah transaksi

        // tambah event listener untuk setiap elemen select produk yang ada di awal
        document.querySelectorAll(".product-select").forEach(select => {
            select.addEventListener("change", updatePriceAndSubtotal);
        });

        // tambahkan event listener untuk setiap input jumlah yang ada di awal
        document.querySelectorAll(".quantity-input").forEach(input => {
            input.addEventListener("input", function () {
                let transaksiItem = input.closest(".transaksi-item");
                updateSubtotal(transaksiItem);
            });
        });

        toggleRemoveButtons(); //perbarui tampilan tombol hapus saat pertama kali halaman dimuat
    });
</script>