<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMaintenacnesTableNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropColumn(['scheduled_date', 'personnel', 'done_date']);
            $table->unsignedBigInteger('user_id')->after('inventory_id');
            $table->enum('result', ['Alat Bekerja dengan Baik', 'Alat Tidak Bekerja dengan Baik'])->after('user_id');
            $table->json('raw')->after('result');
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
