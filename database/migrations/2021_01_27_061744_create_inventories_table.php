<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->integer('device_id');
            $table->integer('identity_id');
            // $table->integer('brand_id');
            $table->integer('room_id');
            $table->string('serial')->nullable();
            $table->string('picture')->default('/images/no_image.jpg');
            $table->string('supplier')->default('PT Global Promedika Service');
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
        Schema::dropIfExists('inventories');
    }
}
