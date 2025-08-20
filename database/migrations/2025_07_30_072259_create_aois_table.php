<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aois', function (Blueprint $table) {
            $table->id();
            $table->string('PartNum')->nullable();
            $table->string('PartDesc')->nullable();
            $table->string('WareHouseCode')->nullable();
            $table->string('BinNum')->nullable();
            $table->string('MainTranQty')->nullable();
            $table->string('PhysicalQty')->nullable();
            $table->string('mtscbat_remarks')->nullable();
            $table->string('MTSCBAT')->nullable();
            $table->text('Remarks')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aois');
    }
}
