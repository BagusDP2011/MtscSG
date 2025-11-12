<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxisTable extends Migration
{
    public function up(): void
    {
        Schema::create('axis', function (Blueprint $table) {
            $table->id();
            $table->string('PartNum')->nullable();
            $table->string('PartDesc')->nullable();
            $table->string('WareHouseCode')->nullable();
            $table->string('BinNum')->nullable();
            $table->integer('MainTranQty')->nullable();
            $table->integer('PhysicalQty')->nullable();
            $table->text('mtscbat_remarks')->nullable();
            $table->text('Remarks')->nullable();
            $table->text('pictures')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('axis');
    }
}
