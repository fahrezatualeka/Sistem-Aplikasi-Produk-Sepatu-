<div class="modal fade" id="modalEdit{{ $transaction->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $transaction->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaction.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Produk</label>
                            <select class="form-control" name="product_id" id="product_id_edit{{ $transaction->id }}" disabled>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-harga-beli="{{ $product->purchase_price }}" 
                                        data-harga-jual="{{ $product->sale_price }}"
                                        data-stock="{{ $product->stock }}"
                                        {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" name="name" value="{{ $transaction->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Transaksi</label>
                            <div>
                                <input type="radio" id="Pembelian_edit{{ $transaction->id }}" name="transaction_type" value="Pembelian" 
                                    {{ $transaction->transaction_type == 'Pembelian' ? 'checked' : '' }} required>
                                <label for="Pembelian_edit{{ $transaction->id }}">Pembelian</label>

                                <input type="radio" id="Penjualan_edit{{ $transaction->id }}" name="transaction_type" value="Penjualan" 
                                    {{ $transaction->transaction_type == 'Penjualan' ? 'checked' : '' }} required>
                                <label for="Penjualan_edit{{ $transaction->id }}">Penjualan</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="quantity" id="quantity_edit{{ $transaction->id }}" value="{{ $transaction->quantity }}" min="1" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga</label>
                            <input type="text" class="form-control" id="price_edit{{ $transaction->id }}" value="{{ $transaction->price }}" disabled>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control" id="subtotal_edit{{ $transaction->id }}" value="{{ $transaction->subtotal }}" disabled>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="date" value="{{ $transaction->date }}" required>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const transactionId = "{{ $transaction->id }}"; // ambil ID transaksi dari template blade
    const transactionTypeInputs = document.querySelectorAll(`input[name='transaction_type'][value='Pembelian'], input[name='transaction_type'][value='Penjualan']`); // ambil radio button jenis transaksi
    const priceInput = document.getElementById(`price_edit${transactionId}`); // input   harga untuk transaksi tertentu
    const quantityInput = document.getElementById(`quantity_edit${transactionId}`); // input jumlah untuk transaksi tertentu
    const subtotalInput = document.getElementById(`subtotal_edit${transactionId}`); // input subtotal untuk transaksi tertentu
    const productSelect = document.getElementById(`product_id_edit${transactionId}`); // dropdown produk untuk transaksi tertentu

    function updatePriceAndSubtotal() {
        const selectedProduct = productSelect.options[productSelect.selectedIndex]; ///Produk yang dipilih
        const selectedTransactionType = document.querySelector(`input[name='transaction_type']:checked`); // jenis transaksi yang dipilih

        if (!selectedProduct || !selectedTransactionType) return; // hterhanti jika tidak ada data yang dipilih

        let price = selectedTransactionType.value === "Pembelian"
            ? parseFloat(selectedProduct.getAttribute("data-harga-beli")) || 0 // gunakan harga beli jika transaksi adalah pembelian
            : parseFloat(selectedProduct.getAttribute("data-harga-jual")) || 0; // gunakan harga jual jika transaksi adalah penjualan

        let quantity = parseInt(quantityInput.value) || 0; // ambil jumlah  yang diinputkan

        if (quantity > 0) {
            priceInput.value = price; // atuur harga produk
            subtotalInput.value = price * quantity; // hitung subtotal
        }
    }

    // tambahkan event listener untuk  mengupdate subtotal saat jumlah  diinputkan
    quantityInput.addEventListener("input", updatePriceAndSubtotal);

    // tambahkan  event listener untuk mengupdate subtotal saat jenis transaksi berubah
    transactionTypeInputs.forEach(input => input.addEventListener("change", updatePriceAndSubtotal));
});
</script>