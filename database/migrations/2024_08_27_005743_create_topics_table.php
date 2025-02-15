<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Topik
            $table->timestamps(); // Dibuat
        });
    }

    public function down()
    {
        Schema::dropIfExists('topics');
    }
};
