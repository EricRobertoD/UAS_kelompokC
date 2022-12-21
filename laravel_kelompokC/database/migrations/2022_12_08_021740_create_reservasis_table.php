<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barber')->constrained("barbers")->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_pelanggan')->constrained("users")->onUpdate('cascade')->onDelete('cascade');
            $table->Date('tanggal');
            $table->String('waktu');
            $table->String('service');
            $table->Boolean('status');
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
        Schema::dropIfExists('reservasis');
    }
};
