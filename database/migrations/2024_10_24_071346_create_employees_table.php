<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pegawai
            $table->string('email')->unique(); // Email pegawai
            $table->string('position'); // Jabatan pegawai
            $table->string('phone_number')->nullable(); // Nomor telepon pegawai
            $table->date('entry_date'); // Tanggal masuk pegawai
            $table->text('photo')->nullable(); // Kolom untuk menyimpan path foto pegawai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
