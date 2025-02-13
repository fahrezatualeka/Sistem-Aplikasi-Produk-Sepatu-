<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'purchase_price',
        'sale_price',
        'stock',
        'image',
        'date',
        'description',
    ];

    // relasi ke transaksi detail untuk menyimpan harga historis transaksi
    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'product_id');
    }
}