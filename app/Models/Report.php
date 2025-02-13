<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'category',
        'purchase_price',
        'sale_price',
        'stock',
        'profit',
        'name',
        'transaction_type',
        'quantity',
        'subtotal',
        'date',
        'action'
    ];

    // relasi ke tabel transaction (1 transaksi memiliki banyak banyak data, dan setiap data hanya memiliki 1 transaksi)
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // relasi ke tabel product (satu produk memiliki banyak banyak data, dan setiap data hanya memiliki 1 transaksi
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
