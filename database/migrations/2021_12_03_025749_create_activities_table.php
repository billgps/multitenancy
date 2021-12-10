<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            // $table->string('facility_code');
            // $table->string('name');
            $table->string('order_no');
            $table->date('started_at')->nullable();
            $table->date('finished_at')->nullable();
            $table->integer('active_at');
            $table->boolean('is_active')->default(false);
            $table->enum('status', ['on going', 'queued', 'finished', 'on hold']);
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
        Schema::dropIfExists('activities');
    }
}
