<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'product_id',
        'transaction_sale_id',
        'name',
        'purchase_price',
        'sale_price',
        'quantity',
        'subtotal',
        'profit',
        'date',
        'action'
    ];

    // relasi ke tabel transaksi penjualan
    public function transaction_sale()
    {
        return $this->belongsTo(TransactionSale::class);
    }

    // relasi ke tabel produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // relasi ke tabel brand utk ambil data
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    // relasi ke tabel kategori utk ambil data
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}