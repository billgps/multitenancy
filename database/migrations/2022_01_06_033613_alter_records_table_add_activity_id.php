<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRecordsTableAddActivityId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('records', 'activity_id')) {
            Schema::table('records', function ($table){
                $table->unsignedBigInteger('activity_id')->after('result');
    
                // $table->foreign('activity_id')->reference('activities')->on('id')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('records', 'activity_id')) {
            Schema::table('records', function (Blueprint $table) {
                $table->dropColumn('activity_id');
            });
        }
    }
}
