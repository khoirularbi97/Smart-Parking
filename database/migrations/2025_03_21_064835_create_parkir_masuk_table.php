<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('parkir_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->timestamp('waktu_masuk');
            $table->string('lokasi_parkir', 50);
            $table->enum('status', ['aktif', 'keluar'])->default('aktif');
        });
    }

    public function down() {
        Schema::dropIfExists('parkir_masuk');
    }
};