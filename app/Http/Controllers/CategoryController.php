<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // tampilkan data
    public function index()
    {
        $data = Category::orderBy('created_at', 'desc')->get(); // mengambil semua data diproduk dan mengurutkannya dari yang terbaru
        
         // menampilkan view dengan data produk
        return view('category.index', compact('data'));
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

     // proses simpan
    public function store(Request $request)
    {
        // validasi input kategori
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|max:255'
        ]);
        
        // menyimpan setiap nama kategori yang dikirim
        foreach ($request->name as $categoryName) {
            Category::create(['name' => $categoryName]);
        }
    
        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    //  fungsi edit data
    public function update(Request $request, $id)
    {
        // validasi input kategori
        $request->validate(['name' => 'required|string|max:255']);

        // mencari kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // memperbarui nama kategori
        $category->update(['name' => $request->name]);

        return redirect()->route('category.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  hapus data
    public function destroy($id)
    {
        // mencari kategori berdasarkan ID
        $data = Category::findOrFail($id);

        // menghapus kategori
        $data->delete();

        return redirect()->route('category.index')->with('success', 'Data berhasil dihapus!');
    }
}
