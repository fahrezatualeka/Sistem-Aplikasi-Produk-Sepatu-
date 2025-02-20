<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\TransactionPurchase;
use App\Models\TransactionSale;

class DashboardController extends Controller
{
    public function index()
    {
        // menghitung total stok keseluruhan
        $product = Product::sum('stock');
        $purchaseProduct = Product::sum('purchase_price');
        $saleProduct = Product::sum('sale_price');
        $profitProduct = $saleProduct - $purchaseProduct;

        // menghitung transaksi pembelian
        $purchase = TransactionPurchase::count();
        $pricePurchase = TransactionPurchase::sum('price');
        $totalPurchase = TransactionPurchase::sum('subtotal');

        // menghitung transaksi penjualan
        $sale = TransactionSale::count();
        $priceSale = TransactionSale::sum('price');
        $totalSale = TransactionSale::sum('subtotal');

        return view('dashboard', compact(
            'product', 'purchaseProduct', 'saleProduct', 'profitProduct', 
            'purchase', 'pricePurchase', 'totalPurchase', 
            'sale', 'priceSale', 'totalSale'
        ));
    }
}