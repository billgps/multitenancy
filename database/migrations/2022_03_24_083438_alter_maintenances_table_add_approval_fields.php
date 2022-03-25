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
            $table->date('approved_by_spv_at')->after('raw');
            $table->date('approved_by_ips_at')->after('approved_by_spv_at');
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
