<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {

            // Primary Key khusus transaksi
            $table->id('transaction_id');

            // Machine type (AXI / AOI)
            $table->enum('machine_type', ['AXI', 'AOI'])
                ->index()
                ->comment('Jenis mesin transaksi');

            // Item identity (snapshot)
            $table->string('part_number', 100)->index();
            $table->string('part_description')->nullable();

            // Transaction info
            $table->enum('transaction_type', ['IN', 'OUT', 'ADJUST'])
                ->index();
            $table->decimal('quantity', 15, 2);
            $table->string('uom', 20)->default('pcs');

            // Location
            $table->string('warehouse_code', 50)->nullable()->index();
            $table->string('bin_code', 50)->nullable()->index();

            // Reference (AXI / AOI / PO / MANUAL / SYSTEM)
            $table->string('reference_type', 50)->nullable()->index();
            $table->string('reference_id', 100)->nullable()->index();

            // Transaction date & remarks
            $table->dateTime('transaction_date')->index();
            $table->text('remarks')->nullable();

            // Audit
            $table->string('created_by')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
