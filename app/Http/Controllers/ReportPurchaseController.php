<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\ReportPurchaseExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ReportPurchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //  tampilan data
     public function index()
    {
        $data = ReportPurchase::latest()->get(); // urutkan data dari yang terbaru ditambahkan

        // ambil data brand & kategori
        $brands = Brand::all();
        $categories = Category::all();
        return view('report_purchase.index', compact('data', 'brands', 'categories'));
    }


    // controller filter data
    public function filter(Request $request)
    {
        $query = ReportPurchase::query();
    
        // filter pencarian berdasarkan produk atau pelanggan
        if ($request->filled('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('name', 'like', '%' . $request->search . '%');
        }
    
        // filter berdasarkan brand
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
    
        // filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        // filter berdasarkan bulan
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }
    
        // filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
    
        // ambil data untuk tabel
        $data = $query->latest()->get();
    
        // pastikan semuaa brand dan kategori dikirim ke view
        $brands = Brand::all(); 
        $categories = Category::all();
    
        return view('report_purchase.index', compact('data', 'brands', 'categories'));
    }

    // EXPORT
    // excel
    public function exportExcel(Request $request)
    {
        $query = ReportPurchase::query();
    
        // terapkan filter
        if ($request->search) {
            $query->where('product->name', 'like', "%{$request->search}%");
        }
        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->month) {
            $query->whereMonth('date', $request->month);
        }
        if ($request->year) {
            $query->whereYear('date', $request->year);
        }
    
        $data = $query->latest()->get();
    
        return Excel::download(new ReportPurchaseExport($data), 'Laporan_Pembelian_Produk.xlsx');
    }


    // pdf
    public function exportPdf(Request $request)
    {
        $query = ReportPurchase::query();
    
        // terapkan filter
        if ($request->search) {
            $query->where('product->name', 'like', "%{$request->search}%");
        }
        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->month) {
            $query->whereMonth('date', $request->month);
        }
        if ($request->year) {
            $query->whereYear('date', $request->year);
        }
    
        $data = $query->latest()->get();
    
        $pdf = Pdf::loadView('report_purchase.pdf', compact('data'));
        return $pdf->download('Laporan_Pembelian_Produk.pdf');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ReportPurchase $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportPurchase $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportPurchase $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    //  hapus data
    public function destroy(string $id)
    {
        $data = ReportPurchase::findOrFail($id);
        
        // ambil data dari id untuk dihapus
        $data->delete();

        return redirect()->route('report_purchase.index')->with('success', 'Data berhasil dihapus!');
    }
}
