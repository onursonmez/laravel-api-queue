<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivities extends Migration
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
            $table->timestamps();      
            $table->timestamp('callback_at')->nullable(); 
            $table->foreignId('app_id')->constrained('apps')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('uid')->constrained('devices')->onDelete('no action')->onUpdate('cascade');
            $table->tinyInteger('status'); //1 started, 2 renewed, 3 cancelled
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
