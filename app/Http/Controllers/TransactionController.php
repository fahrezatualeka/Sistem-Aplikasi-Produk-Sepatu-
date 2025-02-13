<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  tampil data
    public function index()
    {
        $data = Transaction::orderBy('created_at', 'desc')->get(); // urutkan data dari yang terbaru ditambahkan
        $products = Product::all(); // ambil semua produk

        // tampilkan ke halaman
        return view('transaction.index', compact('data', 'products'));
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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'transaction_type' => 'required|in:Pembelian,Penjualan',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date'
        ]);
    
        // ambil data produk berdasarkan product_id
        $product = Product::findOrFail($request->product_id);
    
        // tentukan harga berdasarkan jenis transaksi
        $price = $request->transaction_type === 'Pembelian' ? $product->purchase_price : $product->sale_price;
        $subtotal = $request->quantity * $price;
    
        // simpan  transaksi ke tabel transactions
        $transaction = Transaction::create([
            'product_id' => $product->id,
            'name' => $request->name,
            'transaction_type' => $request->transaction_type,
            'quantity' => $request->quantity,
            'price' => $price,
            'subtotal' => $subtotal,
            'date' => $request->date
        ]);
    
        // Update stok produk
        if ($request->transaction_type === 'Pembelian') {
            $product->stock += $request->quantity; // Tambahstok jika pembelian
        } else {
            //pastikan stok tidak negatif setelah penjualan
            if ($product->stock >= $request->quantity) {
                $product->stock -= $request->quantity; // kurangi stok jika penjualan
            } else {
                return redirect()->route('transaction.index')->with('error', 'Stok tidak mencukupi untuk penjualan!');
            }
        }
    
        $product->save();
    
        // hitung profit berdasarkan purchase_price - sale_price
        $profit = $product->sale_price - $product->purchase_price;
    
        Report::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'category' => $product->category,
            'purchase_price' => $product->purchase_price,
            'sale_price' => $product->sale_price,
            'stock' => $product->stock,
            'profit' => $profit,
            'name' => $request->name,
            'transaction_type' => $request->transaction_type,
            'quantity' => $transaction->quantity,
            'subtotal' => $transaction->subtotal,
            'date' => $transaction->date,
            'action' => 'created',
        ]);
    
        return redirect()->route('transaction.index')->with('success', 'Data berhasil ditambah!');
    }
    

    /**
     * Display the specified resource.
     */

    public function show(Transaction $transaction)
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
            'name' => 'required|string',
            'transaction_type' => 'required|in:Pembelian,Penjualan',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date'
        ]);
    
        $transaction = Transaction::findOrFail($id);
        $product = Product::findOrFail($transaction->product_id); //  pastikan produk terkait ditemukan
    
        // hitung selisih jumlah sebelum dan sesudah update
        $oldQuantity = $transaction->quantity;
        $newQuantity = $request->quantity;
        $quantityDiff = $newQuantity - $oldQuantity; // bisa negatif jika jumlah dikurangi
    
        // Update stok berdasarkan jenis transaksi sebelumnya
        if ($transaction->transaction_type === 'Pembelian') {
            $product->stock -= $oldQuantity; // kurangi stok dengan jumlah lama
        } else {
            $product->stock += $oldQuantity; // tambah stok dengan jumlah lama
        }
    
        //tentukan harga berdasarkan jenis transaksi baru
        $price = $request->transaction_type === 'Pembelian' ? $product->purchase_price : $product->sale_price;
        $subtotal = $newQuantity * $price;
    
        // perbarui stok sesuai transaksi baru
        if ($request->transaction_type === 'Pembelian') {
            $product->stock += $newQuantity; // tambahkan stok baru jika pembelian
        } else {
            $product->stock -= $newQuantity; // kurang stok baru jika penjualan
        }
    
        // Pastikan stok tidak negatif
        if ($product->stock < 0) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk transaksi ini!');
        }
    
        // simpan perubahan  pada stok produk
        $product->save();
    
        // Hapus data lama di tabel reports
        Report::where('transaction_id', $id)->delete();
    
        // perbarui transaksi
        $transaction->update([
            'name' => $request->name,
            'transaction_type' => $request->transaction_type,
            'quantity' => $newQuantity,
            'price' => $price,
            'subtotal' => $subtotal,
            'date' => $request->date
        ]);
    
        // hitung keuntungan
        $profit = $product->sale_price - $product->purchase_price;
    
        //masukkan data baru ke tabel reports
        Report::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'category' => $product->category,
            'purchase_price' => $product->purchase_price,
            'sale_price' => $product->sale_price,
            'stock' => $product->stock,
            'profit' => $profit,
            'name' => $request->name,
            'transaction_type' => $request->transaction_type,
            'quantity' => $transaction->quantity,
            'subtotal' => $transaction->subtotal,
            'date' => $transaction->date,
            'action' => 'updated', // perubahan action menjadi "updated"
        ]);
    
        return redirect()->route('transaction.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  penghapusan data berelasi ke tabel Laporan
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
    
        // simpan transaksi yang dihapus ke dalam tabel reports sebelum dihapus
        Report::create([
            'transaction_id' => $transaction->id,
            'product_id' => $transaction->product_id,
            'name' => $transaction->name,
            'category' => $transaction->product->category,
            'purchase_price' => $transaction->product->purchase_price,
            'sale_price' => $transaction->product->sale_price,
            'stock' => $transaction->product->stock,
            'profit' => ($transaction->product->sale_price - $transaction->product->purchase_price) * $transaction->quantity,
            'transaction_type' => $transaction->transaction_type,
            'quantity' => $transaction->quantity,
            'price' => $transaction->price,
            'subtotal' => $transaction->subtotal,
            'date' => $transaction->date,
            'action' => 'created',
        ]);
    
        // hapus transaksi setelah dicatat di laporan
        $transaction->delete();
    
        return redirect()->route('transaction.index')->with('success', 'Data berhasil dihapus!');
    }
}