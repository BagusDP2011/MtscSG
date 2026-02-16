<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aoi_images', function (Blueprint $table) {
            $table->id('aoi_images_id');
            $table->unsignedBigInteger('aoi_id')->nullable();
            $table->string('image_path');
            $table->string('filename');
            $table->timestamps();

            // Anti duplikat
            $table->unique(['aoi_id', 'image_path']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aoi_images');
    }
};
