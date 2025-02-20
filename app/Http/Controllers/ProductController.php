<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Report;
use App\Models\ReportPurchase;
use App\Models\ReportSale;
use App\Models\TransactionPurchase;
use App\Models\TransactionSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // controller untuk menampilkan data
    public function index()
    {
        $data = Product::orderBy('created_at', 'desc')->get(); // mengambil semua data diproduk dan mengurutkannya dari yang terbaru

        $brands = Brand::all(); // ambil semua brand
        $categories = Category::all(); // ambil semua kategori

        
         // menampilkan view dengan data produk
        return view('product.index', compact('data', 'brands', 'categories'));
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
        $request->validate([
            'brand_id' => 'required|array',
            'brand_id.*' => 'integer|exists:brands,id',
            'category_id' => 'required|array',
            'category_id.*' => 'integer|exists:categories,id',
            'name' => 'required|array',
            'name.*' => 'string',
            'purchase_price' => 'required|array',
            'purchase_price.*' => 'numeric',
            'sale_price' => 'required|array',
            'sale_price.*' => 'numeric',
            'stock' => 'required|array',
            'stock.*' => 'integer',
            'image' => 'sometimes|nullable|array',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        foreach ($request->name as $key => $name) {
            $imagePath = null;
    
            // cek apakah ada file gambar yang diunggah
            if ($request->hasFile("image.$key")) {
                $imagePath = $request->file("image.$key")->store('images', 'public');
            }
    
            Product::create([
                'brand_id' => $request->brand_id[$key],
                'category_id' => $request->category_id[$key],
                'name' => $name,
                'purchase_price' => $request->purchase_price[$key],
                'sale_price' => $request->sale_price[$key],
                'stock' => $request->stock[$key],
                'image' => $imagePath, // Jika kosong, akan bernilai null
            ]);
        }
    
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
            'name' => 'required|string',
            'purchase_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images', 'public');

            // hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        } else {
            $image = $product->image;
        }

        // perbarui data produk
        $product->update([
            'name' => $request->filled('name') ? $request->name : $product->name,
            'purchase_price' => $request->filled('purchase_price') ? $request->purchase_price : $product->purchase_price,
            'sale_price' => $request->filled('sale_price') ? $request->sale_price : $product->sale_price,
            'stock' => $request->filled('stock') ? $request->stock : $product->stock,
            'image' => $image,
        ]);

        return redirect()->route('product.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    // penghapusan data
    public function destroy($id)
    {
            $data = Product::findOrFail($id);
    
            // hapus produk berdasarkan id dari data
            $data->delete();
    
            return redirect()->route('product.index')->with('success', 'Data berhasil dihapus!');
    }
}
