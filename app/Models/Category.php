<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // relasi ke tabel brand untuk mengambil data
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // relasi ke tabel produk untuk mengirimkan data
    public function product()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
    // relasi ke tabel transaksi pembelian utk mengirimkan data
    public function transaction_purchase()
    {
        return $this->hasMany(TransactionPurchase::class, 'brand_id');
    }

    // relasi ke tabel transaksi penjualan untuk mengirimkan data
    public function transaction_sale()
    {
        return $this->hasMany(TransactionSale::class, 'brand_id');
    }
}
