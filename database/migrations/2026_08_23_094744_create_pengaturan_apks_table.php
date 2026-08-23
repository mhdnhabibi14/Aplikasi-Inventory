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
        Schema::create('pengaturan_apks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi');
            $table->date('tanggal_analisa_awal')->nullable();
            $table->date('tanggal_analisa_akhir')->nullable();
            $table->unsignedInteger('minimal_stok')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_apks');
    }
};
