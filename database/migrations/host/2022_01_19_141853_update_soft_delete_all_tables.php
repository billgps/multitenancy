<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoftDeleteAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('administrators', function ($table) {
            $table->softDeletes();
        });

        Schema::table('tenants', function ($table) {
            $table->softDeletes();
        });

        Schema::table('nomenclatures', function ($table) {
            $table->softDeletes();
        });

        Schema::table('queues', function ($table) {
            $table->softDeletes();
        });

        Schema::table('logs', function ($table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
