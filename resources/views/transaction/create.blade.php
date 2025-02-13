<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">- Pilih -</label>
                            <select class="form-control" id="product_id" name="product_id">
                                <option value="" disabled selected>- Pilih Produk -</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-harga-beli="{{ $product->purchase_price }}" 
                                        data-harga-jual="{{ $product->sale_price }}"
                                        data-stock="{{ $product->stock }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>


                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Transaksi</label>
                            <div>
                                <input type="radio" id="Pembelian" name="transaction_type" value="Pembelian" required>
                                <label for="Pembelian">Pembelian</label>
                                <input type="radio" id="Penjualan" name="transaction_type" value="Penjualan" required>
                                <label for="Penjualan">Penjualan</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <select class="form-control d-none" id="quantity_select" name="quantity">
                                <option value="" disabled selected>- Pilih -</option>
                            </select>
                            <input type="number" class="form-control d-none" id="quantity_input" name="quantity" min="1">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="text" class="form-control d-none" id="price" name="price" readonly>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="subtotal" class="form-label">Subtotal</label>
                            <input type="text" class="form-control d-none" id="subtotal" name="subtotal" readonly>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>

document.addEventListener("DOMContentLoaded", function () {
    const productSelect = document.getElementById("product_id"); // ambil elemen select produk
    const transactionTypeInputs = document.querySelectorAll("input[name='transaction_type']"); // ambil radio button jenis transaksi
    const priceInput = document.getElementById("price"); // iinput harga
    const quantitySelect = document.getElementById("quantity_select"); // dropdown jumlah untuk penjualan
    const quantityInput = document.getElementById("quantity_input"); // input jumlah untuk pembelian
    const subtotalInput = document.getElementById("subtotal"); // input subtotal

    // reset semua field terkait jumlah, harga, dan subtotal
    function resetFields() {
        quantityInput.classList.add("d-none");
        quantityInput.value = "";
        quantityInput.disabled = true;

        quantitySelect.classList.add("d-none");
        quantitySelect.innerHTML = '<option value="" disabled selected>- Pilih -</option>';

        priceInput.classList.add("d-none");
        priceInput.value = "";

        subtotalInput.classList.add("d-none");
        subtotalInput.value = "";
    }

    // menentukan harga dan metode input jumlah berdasarkan jenis  transaksi
    function updatePriceAndQuantity() {
        resetFields(); // Reset form sebelum memperbarui

        const selectedProduct = productSelect.options[productSelect.selectedIndex]; // produk dipili
        const selectedTransactionType = document.querySelector("input[name='transaction_type']:checked"); //jenis transaksi terpilih

        if (!selectedProduct || !selectedTransactionType) return;

        let stock = parseInt(selectedProduct.getAttribute("data-stock")) || 0; // ambil stok dari atribut data-stock

        if (selectedTransactionType.value === "Pembelian") {
            // jika pembelian, gunakan input number/angka
            quantityInput.classList.remove("d-none");
            quantityInput.disabled = false;
        } else if (selectedTransactionType.value === "Penjualan") {
            // jika penjualan, gunakan select dropdown yang menampilkan stok tersedia
            quantitySelect.classList.remove("d-none");

            // isi dropdown dengan stok yang tersedia
            quantitySelect.innerHTML = '<option value="" disabled selected>- Pilih -</option>';
            for (let i = 1; i <= stock; i++) {
                let option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                quantitySelect.appendChild(option);
            }
        }
    }

    // menghitung subtotal berdasarkan jumlah dan harga
    function updateSubtotal() {
        const selectedProduct = productSelect.options[productSelect.selectedIndex];
        const selectedTransactionType = document.querySelector("input[name='transaction_type']:checked");

        if (!selectedProduct || !selectedTransactionType) return;

        let price = selectedTransactionType.value === "Pembelian"
            ? parseFloat(selectedProduct.getAttribute("data-harga-beli")) || 0 // harga beli jika pembelian
            : parseFloat(selectedProduct.getAttribute("data-harga-jual")) || 0; // harga jual jika penjualan

        let quantity = parseInt(quantityInput.value) || parseInt(quantitySelect.value) || 0; // ambil  total jumlah

        if (quantity > 0) {
            // jika jumlah valid, tampilkan harga dan subtotal ny
            priceInput.classList.remove("d-none");
            subtotalInput.classList.remove("d-none");
            priceInput.value = price;
            subtotalInput.value = price * quantity;
        } else {
            // jika  jumlah tidak valid, sembunyikan harga dan subtotal
            priceInput.classList.add("d-none");
            subtotalInput.classList.add("d-none");
        }
    }

    // event listener untuk memperbarui tampilan jumlah dan harga
    productSelect.addEventListener("change", updatePriceAndQuantity);
    transactionTypeInputs.forEach(input => input.addEventListener("change", updatePriceAndQuantity));
    quantitySelect.addEventListener("change", updateSubtotal);
    quantityInput.addEventListener("input", updateSubtotal);
});

</script>