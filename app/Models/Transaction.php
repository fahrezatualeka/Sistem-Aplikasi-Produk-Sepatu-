<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'transaction_type',
        'quantity',
        'price',
        'subtotal',
        'date',
    ];

    
    // relasi ke tabel produk (satu detail merujuk ke satu produk).
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    // hitung subtotal otomatis saat  price ⁠atau⁠ quantity berubah
    public static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            $detail->subtotal = $detail->price * $detail->quantity;
        });
    }

    // 1 data terkait ke tabel report dihubungkan pada kolom transaksi (setaip transaksi memiliki 1 laporan)
    public function report()
    {
        return $this->hasOne(Report::class, 'transaction_id', 'id');
    }

}