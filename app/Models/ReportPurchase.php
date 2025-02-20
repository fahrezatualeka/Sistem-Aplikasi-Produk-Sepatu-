<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'product_id',
        'transaction_purchase_id',
        'name',
        'purchase_price',
        'sale_price',
        'quantity',
        'subtotal',
        'profit',
        'date',
        'action'
    ];

    // relasi ke tabel transaction pembelian utk ambil data
    public function transaction_purchase()
    {
        return $this->belongsTo(TransactionPurchase::class);
    }

    // relasi ke tabel produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // relasi utk ambik data di tabel brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // relasi pengambilan data di tabel kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}