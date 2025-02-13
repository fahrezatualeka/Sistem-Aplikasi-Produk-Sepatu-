<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Report;
use App\Models\Product;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //  tampilan index
     public function index()
    {
        $data = Report::latest()->get(); // urutkan data dari yang terbaru ditambahkan
        return view('report.index', compact('data'));
    }


    // controller filter data
    public function filter(Request $request)
    {
        $query = Report::query();
    
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        // Filter berdasarkan jenis transaksi
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }
    
        $data = $query->latest()->get();
        return view('report.index', compact('data'));
    }

    // EXPORT
    // excel
    public function exportExcel()
    {
        return Excel::download(new ReportExport, 'laporan_produk.xlsx'); //download berdasarkan nama yg diberikan
    }


    // pdf
    public function exportPdf()
    {
        $data = Report::latest()->get(); //urutkan

        $pdf = Pdf::loadView('report.pdf', compact('data'));
        return $pdf->download('laporan_produk.pdf'); 
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
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Report::findOrFail($id);
        
        $data->delete();

        return redirect()->route('report.index')->with('success', 'Data berhasil dihapus!');
    }
}
