<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename tabel dari ayune_order_items_ (typo underscore) ke ayune_order_items
        Schema::rename('ayune_order_items_', 'ayune_order_items');
    }

    public function down(): void
    {
        Schema::rename('ayune_order_items', 'ayune_order_items_');
    }
};
