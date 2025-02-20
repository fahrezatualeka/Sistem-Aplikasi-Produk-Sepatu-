<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    // relasi ke tabel kategori
    public function category()
    {
        return $this->hasMany(Category::class, 'brand_id');
    }

    // relasi ke tabel produk
    public function product()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
    // relasi ke tabel transaksi pembelian
    public function transaction_purchase()
    {
        return $this->hasMany(TransactionPurchase::class, 'brand_id');
    }

    // relasi ke tabel transaksi penjualan
    public function transaction_sale()
    {
        return $this->hasMany(TransactionSale::class, 'brand_id');
    }
}
