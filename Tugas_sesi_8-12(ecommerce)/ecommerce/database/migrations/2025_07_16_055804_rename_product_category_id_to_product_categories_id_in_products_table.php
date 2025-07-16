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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_category_id']);
            $table->renameColumn('product_category_id', 'product_categories_id');
            $table->foreign('product_categories_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Langkah 1: Hapus foreign key constraint yang baru
            // Nama constraint baru akan sama dengan nama kolom baru, karena belum ada history lain
            $table->dropForeign(['product_categories_id']);

            // Langkah 2: Kembalikan nama kolom ke semula
            $table->renameColumn('product_categories_id', 'product_category_id');

            // Langkah 3: Tambahkan kembali foreign key constraint yang lama
            $table->foreign('product_category_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('set null'); // Sesuai dengan yang ada di database dump Anda
        });
    }
};
