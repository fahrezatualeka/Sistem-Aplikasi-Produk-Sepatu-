<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // controller untuk menampilkan data
    public function index()
    {
        $data = Product::orderBy('created_at', 'desc')->get(); // mengambil semua data diproduk dan mengurutkannya dari yang terbaru
        
         // menampilkan view dengan data produk
        return view('product.index', compact('data'));
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

    // fungsi tambah data berhasil    
    public function store(Request $request)
    {

        //validasi input
        $request->validate([
            'name' => 'required',
            'category' => 'required|in:training,running,originals,outdoor',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'description' => 'required'
        ]);
    
        // simpan  gambar ke penyimpanan
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images', 'public');
        } else {
            return redirect()->back()->with('error', 'Gambar wajib diunggah.');
        }
    
        // menyimpan produk ke database
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
            'image' => $image,
            'date' => $request->date,
            'description' => $request->description
        ]);
    
        return redirect()->route('product.index')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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

    // proses simpan daata yg diedit
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string',
            'category' => 'nullable|in:training,running,originals,outdoor',
            'purchase_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'nullable|date',
            'description' => 'nullable|string'
        ]);
    
        $product = Product::findOrFail($id);
    
        // *cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Simpan gambar baru
            $image = $request->file('image')->store('images', 'public');
    
            // hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        } else {
            // jika tidak ada gambar baru, gunakan gambar lama
            $image = $product->image;
        }
    
        // simpan data lama untuk perbandingan**
        $oldSalePrice = $product->sale_price;
        $oldPurchasePrice = $product->purchase_price;
        $oldName = $product->name;
    
        // update data produk
        $product->update([
            'name' => $request->name ?? $product->name,
            'category' => $request->category ?? $product->category, // kategori tetap bisa diperbarui meskipun readonly
            'purchase_price' => $request->purchase_price ?? $product->purchase_price,
            'sale_price' => $request->sale_price ?? $product->sale_price,
            'stock' => $request->stock ?? $product->stock,
            'image' => $image, // gunakan gambar baru jika ada, atau tetap gunakan gambar lama
            'date' => $request->date ?? $product->date,
            'description' => $request->description ?? $product->description
        ]);
    
        // **update transaksi terkait produk (jika ada perubahan harga jual)**
        if ($request->sale_price !== null && $request->sale_price != $oldSalePrice) {
            Transaction::where('product_id', $id)->update([
                'price' => $request->sale_price
            ]);
        }
    
        // update laporan terkait produk
        Report::where('product_id', $id)->update([
            'sale_price' => $request->sale_price ?? $oldSalePrice,
            'purchase_price' => $request->purchase_price ?? $oldPurchasePrice
        ]);
    
        return redirect()->route('product.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    // penghapusan data
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
    
        // hapus gambar jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
    
        // hapus transaksi dan laporan terkait produk ini
        Transaction::where('product_id', $id)->delete();
        Report::where('product_id', $id)->delete();
    
        $product->delete();
    
        return redirect()->route('product.index')->with('success', 'Data berhasil dihapus!');
    }
}
