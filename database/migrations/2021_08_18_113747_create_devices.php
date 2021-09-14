<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('app_id')->constrained('apps')->onDelete('no action')->onUpdate('cascade')->default(1); 
            $table->string('uid', 100);
            $table->integer('language')->default(1);
            $table->tinyInteger('os')->default(1);
            $table->tinyInteger('timezone')->default(16);
            $table->string('token', 100)->nullable();

            $table->unique(['app_id', 'uid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
