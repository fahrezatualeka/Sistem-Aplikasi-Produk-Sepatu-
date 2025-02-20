<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use App\Models\ReportPurchase;
use App\Models\TransactionPurchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransactionPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  tampil data
    public function index()
    {
        $data = TransactionPurchase::orderBy('created_at', 'desc')->get(); // urutkan data dari yang terbaru ditambahkan
        $products = Product::all(); // ambil semua produk

        // tampilkan ke halaman
        return view('transaction_purchase.index', compact('data', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    //  tambah data
    public function store(Request $request)
    {
        // validasi input dari request
        $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'name' => 'required|array',
            'name.*' => 'string|max:255',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'date' => 'required|array',
            'date.*' => 'date',
        ]);

        // loop melalui setiap produk yang dibeli
        foreach ($request->product_id as $key => $productId) {
            $product = Product::findOrFail($productId);
            $quantity = $request->quantity[$key];
            $price = $product->purchase_price;
            $subtotal = $quantity * $price;

            // simpan transaksi pembelian
            $transaction_purchase = TransactionPurchase::create([
                'product_id' => $product->id,
                'name' => $request->name[$key],
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
                'date' => $request->date[$key]
            ]);

            // tambah stok produk setelah pembelian
            $product->increment('stock', $quantity);

            // simpan ke dalam laporan pembelian
            ReportPurchase::create([
                'brand_id' => $product->brand_id,
                'category_id' => $product->category_id,
                'product_id' => $product->id,
                'transaction_purchase_id' => $transaction_purchase->id,
                'name' => $request->name[$key],
                'purchase_price' => $product->purchase_price,
                'sale_price' => $product->sale_price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'profit' => ($product->sale_price - $product->purchase_price),
                'date' => $request->date[$key],
                'action' => 'created',
            ]);
        }

        return redirect()->route('transaction_purchase.index')->with('success', 'Data berhasil ditambahkan!');
    }
    

    /**
     * Display the specified resource.
     */

    public function show(TransactionPurchase $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    //  update ketika data di edit
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        // ambil transaksi lama
        $transaction_purchase = TransactionPurchase::findOrFail($id);
        $oldProduct = Product::findOrFail($transaction_purchase->product_id);
        $newProduct = Product::findOrFail($request->product_id);
        $oldQuantity = $transaction_purchase->quantity;
        $newQuantity = $request->quantity;

        // perbarui stok produk lama dan baru
        $oldProduct->decrement('stock', $oldQuantity);
        $newProduct->increment('stock', $newQuantity);

        // hitung ulang harga dan subtotal
        $price = $newProduct->purchase_price;
        $subtotal = $newQuantity * $price;

        // update transaksi pembelian
        $transaction_purchase->update([
            'product_id' => $newProduct->id,
            'name' => $request->name,
            'quantity' => $newQuantity,
            'price' => $price,
            'subtotal' => $subtotal,
            'date' => $request->date,
        ]);

        // hapus laporan lama dan buat yang baru
        ReportPurchase::where('transaction_purchase_id', $id)->delete();
        ReportPurchase::create([
            'transaction_purchase_id' => $transaction_purchase->id,
            'brand_id' => $newProduct->brand_id,
            'category_id' => $newProduct->category_id,
            'product_id' => $newProduct->id,
            'purchase_price' => $newProduct->purchase_price,
            'sale_price' => $newProduct->sale_price,
            'profit' => ($newProduct->sale_price - $newProduct->purchase_price),
            'name' => $request->name,
            'quantity' => $newQuantity,
            'subtotal' => $subtotal,
            'date' => $request->date,
            'action' => 'updated',
        ]);

        return redirect()->route('transaction_purchase.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  penghapusan data berelasi ke tabel Laporan
    public function destroy(string $id)
    {
        $transaction_purchase = TransactionPurchase::findOrFail($id);
        $product = Product::findOrFail($transaction_purchase->product_id);

        // kurangi stok produk sesuai jumlah transaksi yang dihapus
        $product->decrement('stock', $transaction_purchase->quantity);

        // hapus laporan terkait
        ReportPurchase::where('transaction_purchase_id', $id)->delete();

        // hapus transaksi
        $transaction_purchase->delete();

        return redirect()->route('transaction_purchase.index')->with('success', 'Data berhasil dihapus dan stok dikurangi!');
    }


    // cetak nota PDF
    public function invoice($id)
    {
        $data = TransactionPurchase::findOrFail($id);
        $name = str_replace(' ', '_', strtolower($data->name));
        $product = str_replace(' ', '_', strtolower($data->product->name));
        $fileName = "Nota_Transaksi_Pembelian_{$name}_({$product}).pdf";

        // generate PDF dan unduh
        $pdf = Pdf::loadView('transaction_purchase.invoice', compact('data'))->setPaper('A5', 'portrait');
        return $pdf->download($fileName);
    }
}