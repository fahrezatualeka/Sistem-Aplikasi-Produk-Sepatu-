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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade'); // menghubungkan id dari tabel transaction agar dapat beralasi antar tabel
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // menghubungkan id dari tabel product agar dapat beralasi antar tabel
            $table->string('category');
            $table->integer('purchase_price');
            $table->integer('sale_price');
            $table->integer('stock');
            $table->integer('profit')->nullable();
            $table->string('name')->nullable();
            $table->string('transaction_type');
            $table->integer('quantity');
            $table->decimal('subtotal', 15, 2);
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
        Schema::dropIfExists('reports');
    }
};
