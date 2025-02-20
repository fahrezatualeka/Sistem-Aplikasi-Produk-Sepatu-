<div class="modal fade" id="modalEdit{{ $transaction->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $transaction->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Transaksi Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaction_sale.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Produk</label>
                            <!-- Select tetap disabled -->
                            <select class="form-control" name="product_id_display" id="product_id_edit{{ $transaction->id }}" disabled>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-harga-beli="{{ $product->sale_price }}" 
                                        data-harga-jual="{{ $product->sale_price }}"
                                        data-stock="{{ $product->stock }}"
                                        {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="product_id" value="{{ $transaction->product_id }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="name" value="{{ $transaction->name }}" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jumlah</label>
                            <select class="form-control quantity-input" name="quantity" id="quantity_edit{{ $transaction->id }}" required>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Harga</label>
                            <input type="text" class="form-control" id="price_edit{{ $transaction->id }}" value="{{ $transaction->price }}" disabled>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control" id="subtotal_edit{{ $transaction->id }}" value="{{ $transaction->subtotal }}" disabled>
                        </div>

                        <div class="col-3 mb-3">
                            <label class="form-label">Tanggal Penjualan</label>
                            <input type="date" class="form-control" name="date" value="{{ $transaction->date }}" required>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ambil ID transaksi dari template Blade Laravel
        const transactionId = "{{ $transaction->id }}";

        // ambil elemen-elemen yang terkait dengan transaksi berdasarkan ID transaksi
        const priceInput = document.getElementById(`price_edit${transactionId}`);
        const quantityInput = document.getElementById(`quantity_edit${transactionId}`);
        const subtotalInput = document.getElementById(`subtotal_edit${transactionId}`);
        const productSelect = document.getElementById(`product_id_edit${transactionId}`);

        /**
         *fungsi untuk memperbarui daftar opsi jumlah berdasarkan stok produk yang tersedia
         */
        function updateQuantityOptions() {
            const selectedProduct = productSelect.options[productSelect.selectedIndex];
            if (!selectedProduct) return; // Jika tidak ada produk yang dipilih, hentikan fungsi

            let stock = parseInt(selectedProduct.getAttribute("data-stock")) || 0;

            //set opsi jumlah awal sesuai jumlah transaksi yang tersimpan
            quantityInput.innerHTML = `<option>{{$transaction->quantity}}</option>`;

            // tambah opsi jumlah dari 1 hingga stok maksimum
            for (let i = 1; i <= stock; i++) {
                quantityInput.innerHTML += `<option value="${i}">${i}</option>`;
            }
        }

        /**
         * fungsi untuk memperbarui harga dan subtotal berdasarkan produk dan jumlah yang dipilih
         */
        function updatePriceAndSubtotal() {
            const selectedProduct = productSelect.options[productSelect.selectedIndex];
            if (!selectedProduct) return; // jika tidak ada produk yang dipilih, hentikan fungsi

            let price = parseFloat(selectedProduct.getAttribute("data-harga-beli")) || 0;
            let quantity = parseInt(quantityInput.value) || 1; //ambil jumlah yang dipilih atau default ke 1

            priceInput.value = price; // Set harga produk
            subtotalInput.value = price * quantity; // itung subtotal berdasarkan jumlah yang dipilih
        }

        // event listener saat produk dipilih, memperbarui daftar jumlah & subtotal
        productSelect.addEventListener("change", () => {
            updateQuantityOptions();
            updatePriceAndSubtotal();
        });

        // event listener saat jumlah berubah, memperbarui subtotal
        quantityInput.addEventListener("change", updatePriceAndSubtotal);

        // inisialisasi data saat modal pertama kali dibuka
        updateQuantityOptions();
        updatePriceAndSubtotal();
    });
</script>

