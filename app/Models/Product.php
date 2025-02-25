<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'category',
        'purchase_price',
        'sale_price',
        'stock',
        'image'
    ];

    // relasi ke transaksi pembelian untuk mengirimkan data
    public function transaction_purchase()
    {
        return $this->hasMany(TransactionPurchase::class, 'product_id');
    }

    // relasi ke transaksi penjualan utk mengirimkan data
    public function transaction_sale()
    {
        return $this->hasMany(TransactionSale::class, 'product_id');
    }

    // relasi untuk mengambil data tabel brand/merek
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // relasi untuk mengambil data tabel kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}