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
        Schema::create('detail_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date_of_birth')->nullable(); // Tanggal lahir pegawai
            $table->enum('gender', ['male', 'female'])->nullable(); // Jenis kelamin
            $table->string('province')->nullable(); // Provinsi
            $table->string('city')->nullable(); // Kota
            $table->string('district')->nullable(); // Kecamatan
            $table->string('village')->nullable(); // Desa
            $table->string('address')->nullable(); // Alamat pegawai
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_employees');
    }
};
