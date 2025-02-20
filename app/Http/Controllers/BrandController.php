<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // controller untuk menampilkan data
    public function index()
    {
        $data = Brand::orderBy('created_at', 'desc')->get(); // mengambil semua data diproduk dan mengurutkannya dari yang terbaru
        
         // menampilkan view dengan data produk
        return view('brand.index', compact('data'));
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
    // fungsi untuk tambah data brand
    public function store(Request $request)
    {
        // validasi input yang diterima
        $request->validate([
            'name.*' => 'required|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $brands = [];
        
        // memproses data yang diterima
        if ($request->has('name')) {
            foreach ($request->name as $key => $name) {
                $imagePath = null;
    
                // jika ada gambar, simpan ke dalam penyimpanan
                if ($request->hasFile("image.$key")) {
                    $imagePath = $request->file("image.$key")->store('images', 'public');
                }
    
                $brands[] = [
                    'name' => $name,
                    'image' => $imagePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
    
        // menyimpan data brand ke database
        Brand::insert($brands);
    
        return redirect()->route('brand.index')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    //  proses edit data
    public function update(Request $request, $id)
    {
        // validasi input yang diterima
        $request->validate([
            'name' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $brand = Brand::findOrFail($id);
    
        // cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Simpan gambar baru
            $image = $request->file('image')->store('images', 'public');
    
            // Hapus gambar lama jika ada
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
        } else {
            // jika tidak ada gambar baru, pake gambar lama
            $image = $brand->image;
        }
    
        // update data brand
        $brand->update([
            'name' => $request->name ?? $brand->name,
            'image' => $image, // Gunakan gambar baru jika ada, atau tetap gunakan gambar lama
        ]);
    
        return redirect()->route('brand.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  penghapusan data
    public function destroy($id)
    {
        // mencari data berdasarkan ID
        $data = Brand::findOrFail($id);

        // menghapus data berdasarkan id yang dipilih
        $data->delete();

        return redirect()->route('brand.index')->with('success', 'Data berhasil dihapus!');
    }
}
