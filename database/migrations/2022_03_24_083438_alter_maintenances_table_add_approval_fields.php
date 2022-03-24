<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMaintenancesTableAddApprovalFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->boolean('is_approved_spv')->after('id');
            $table->boolean('is_approved_ips')->after('is_approved_spv');
            $table->unsignedBigInteger('spv_id')->after('user_id');
            $table->unsignedBigInteger('ips_id')->after('spv_id');
            $table->date('approved_at')->after()
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
