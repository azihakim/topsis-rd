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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('status')->default('Cek Administrasi');
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('nib')->nullable();
            $table->string('sertifikasi_halal')->nullable();
            $table->string('hki')->nullable();
            $table->string('pirt')->nullable();
            $table->string('bpom')->nullable();
            $table->string('sni')->nullable();
            $table->string('proposal')->nullable();
            $table->string('legalitas')->nullable();
            $table->string('nama_produk')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->string('perizinan_usaha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
