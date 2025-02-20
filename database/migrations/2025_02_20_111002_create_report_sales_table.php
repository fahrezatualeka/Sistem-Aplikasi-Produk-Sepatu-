<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade'); // menghubungkan id dari tabel brand agar dapat beralasi antar tabel
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // menghubungkan id dari tabel kategori agar dapat beralasi antar tabel
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // menghubungkan id dari tabel produk
            $table->foreignId('transaction_sale_id')->constrained('transaction_sales')->onDelete('cascade'); // menghubungkan id dari tabel transaksi
            $table->string('name')->nullable();
            $table->integer('purchase_price');
            $table->integer('sale_price');
            $table->integer('quantity');
            $table->decimal('subtotal', 15, 2);
            $table->integer('profit')->nullable();
            $table->date('date');
            $table->string('action')->default('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_sales');
    }
};
