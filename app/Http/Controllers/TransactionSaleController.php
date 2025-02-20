<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use App\Models\ReportSale;
use App\Models\TransactionSale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransactionSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  tampil data
    public function index()
    {
        // ambil semua transaksi penjualan, diurutkan dari yang terbaru
        $data = TransactionSale::orderBy('created_at', 'desc')->get();
        
        // ambil semua produk untuk keperluan pemilihan di form transaksi
        $products = Product::all();

        // ttampilkan halaman transaksi penjualan
        return view('transaction_sale.index', compact('data', 'products'));
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
        // validasi input
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
    
        // looping untuk menyimpan banyak transaksi dalam satu permintaan
        foreach ($request->product_id as $key => $productId) {
            $product = Product::findOrFail($productId);
            $quantity = $request->quantity[$key];
    
            // cek apakah stok mencukupi
            if ($product->stock < $quantity) {
                return redirect()->back()->with('error', 'Stok produk ' . $product->name . ' tidak mencukupi!');
            }
    
            // hitung harga dan subtotal
            $price = $product->sale_price;
            $subtotal = $quantity * $price;
    
            // simpan transaksi
            $transaction_sale = TransactionSale::create([
                'product_id' => $product->id,
                'name' => $request->name[$key],
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
                'date' => $request->date[$key]
            ]);
    
            // kurangi stok produk setelah transaksi
            $product->decrement('stock', $quantity);
    
            // hitung profit
            $profit = $product->sale_price - $product->purchase_price;
    
            // simpan laporan transaksi penjualan
            ReportSale::create([
                'transaction_sale_id' => $transaction_sale->id,
                'brand_id' => $product->brand_id ?? null,
                'category_id' => $product->category_id ?? null,
                'product_id' => $product->id,
                'purchase_price' => $product->purchase_price,
                'sale_price' => $product->sale_price,
                'profit' => $profit,
                'name' => $request->name[$key],
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'date' => $request->date[$key],
                'action' => 'created',
            ]);
        }
    
        return redirect()->route('transaction_sale.index')->with('success', 'Data berhasil ditambah!');
    }
    

    /**
     * Display the specified resource.
     */

    public function show(TransactionSale $transaction)
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
        // validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);
    
        // ambil transaksi lama
        $transaction_sale = TransactionSale::findOrFail($id);
        $oldProduct = Product::findOrFail($transaction_sale->product_id);
        $newProduct = Product::findOrFail($request->product_id);
        $oldQuantity = $transaction_sale->quantity;
        $newQuantity = $request->quantity;
    
        // kembalikan stok produk lama
        $oldProduct->increment('stock', $oldQuantity);
    
        // cek stok produk baru
        if ($newProduct->stock < $newQuantity) {
            return redirect()->back()->with('error', 'Stok produk ' . $newProduct->name . ' tidak mencukupi!');
        }
    
        // kurangi stok produk baru
        $newProduct->decrement('stock', $newQuantity);
    
        // update transaksi
        $transaction_sale->update([
            'product_id' => $newProduct->id,
            'name' => $request->name,
            'quantity' => $newQuantity,
            'price' => $newProduct->sale_price,
            'subtotal' => $newQuantity * $newProduct->sale_price,
            'date' => $request->date
        ]);
    
        // hapus laporan lama dan buat laporan baru
        ReportSale::where('transaction_sale_id', $id)->delete();
        ReportSale::create([
            'transaction_sale_id' => $transaction_sale->id,
            'brand_id' => $newProduct->brand_id,
            'category_id' => $newProduct->category_id,
            'product_id' => $newProduct->id,
            'purchase_price' => $newProduct->purchase_price,
            'sale_price' => $newProduct->sale_price,
            'profit' => $newProduct->sale_price - $newProduct->purchase_price,
            'name' => $request->name,
            'quantity' => $newQuantity,
            'subtotal' => $newQuantity * $newProduct->sale_price,
            'date' => $request->date,
            'action' => 'updated',
        ]);
    
        return redirect()->route('transaction_sale.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  penghapusan data berelasi ke tabel Laporan
    public function destroy(string $id)
    {
        // cari transaksi berdasarkan ID
        $transaction_sale = TransactionSale::findOrFail($id);
        
        // ambil produk terkait transaksi (jika ada)
        $product = Product::find($transaction_sale->product_id);
    
        if ($product) {
            // Tambahkan kembali stok produk
            $product->increment('stock', $transaction_sale->quantity);
        }
    
        // hapus data laporan dari tabel ReportSale
        ReportSale::where('transaction_sale_id', $id)->delete();
    
        // hapus transaksi setelah stok dikembalikan dan laporan dihapus
        $transaction_sale->delete();
    
        return redirect()->route('transaction_sale.index')->with('success', 'Data berhasil dihapus!');
    }


    public function invoice($id)
    {
        $data = TransactionSale::findOrFail($id);

        // ambil nama pelanggan dan buat format nama file
        $name = str_replace(' ', '_', strtolower($data->name)); // Ganti spasi dengan underscore dan ubah ke lowercase
        $product = str_replace(' ', '_', strtolower($data->product->name)); // Ganti spasi dengan underscore dan ubah ke lowercase
        $fileName = 'Nota Transaksi Penjualan_' . $name . ' (' . $product . ').pdf';

        // generate PDF
        $pdf = Pdf::loadView('transaction_sale.invoice', compact('data'))->setPaper('A5', 'portrait');

        // unduh file dengan nama pelanggan
        return $pdf->download($fileName);
    }
}