<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // total stok keseluruhan
        $totalStock = Product::sum('stock');

        // total harga beli & harga jual keseluruhan
        $totalPurchasePrice = Product::sum('purchase_price');
        $totalSalePrice = Product::sum('sale_price');
        $totalSelisihPrice = $totalPurchasePrice-$totalSalePrice ;

        return view('dashboard', compact(
            'totalStock',
            'totalPurchasePrice',
            'totalSalePrice',
            'totalSelisihPrice',
        ));
    }
}