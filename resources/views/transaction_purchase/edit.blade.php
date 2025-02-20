<div class="modal fade" id="modalEdit{{ $transaction->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $transaction->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Transaksi Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaction_purchase.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Produk</label>
                            <select class="form-control" name="product_id_display" id="product_id_edit{{ $transaction->id }}" disabled>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-harga-beli="{{ $product->purchase_price }}" 
                                        data-harga-jual="{{ $product->purchase_price }}"
                                        data-stock="{{ $product->stock }}"
                                        {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- input hidden untuk mengirim product_id ke server -->
                            <input type="hidden" name="product_id" value="{{ $transaction->product_id }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pemasok</label>
                            <input type="text" class="form-control" name="name" value="{{ $transaction->name }}" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="quantity" id="quantity_edit{{ $transaction->id }}" value="{{ $transaction->quantity }}" min="1" required>
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
                            <label class="form-label">Tanggal Pembelian</label>
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
            // ambil ID transaksi dari blade template
            const transactionId = "{{ $transaction->id }}"; 

            //mendapatkan elemen input harga, jumlah, subtotal, dan dropdown produk berdasarkan ID transaksi
            const priceInput = document.getElementById(`price_edit${transactionId}`);
            const quantityInput = document.getElementById(`quantity_edit${transactionId}`);
            const subtotalInput = document.getElementById(`subtotal_edit${transactionId}`);
            const productSelect = document.getElementById(`product_id_edit${transactionId}`);

            // Fungsi untuk memperbarui harga dan subtotal saat produk atau jumlah berubah
            function updatePriceAndSubtotal() {
                // dapatkan opsi produk yang dipilih
                const selectedProduct = productSelect.options[productSelect.selectedIndex];

                // jika tidak ada produk yang dipilih, hentikan fungsi
                if (!selectedProduct) return;

                //mengambil harga beli dari atribut data-harga-beli
                let price = parseFloat(selectedProduct.getAttribute("data-harga-beli")) || 0;

                // ambil jumlah dari input dan mengonversinya ke integer
                let quantity = parseInt(quantityInput.value) || 1;

                // perbaharui nilai input harga
                priceInput.value = price;

                // hitung subtotal dan memperbarui input subtotal
                subtotalInput.value = price * quantity;
            }

            // tamba event listener untuk memperbarui subtotal saat jumlah diubah
            quantityInput.addEventListener("input", updatePriceAndSubtotal);

            // memastikan subtotal sudah benar ketika modal pertama kali dibuka
            updatePriceAndSubtotal();
        });
</script>