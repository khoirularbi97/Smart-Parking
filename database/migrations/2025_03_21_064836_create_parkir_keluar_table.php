<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('parkir_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parkir_masuk_id')->constrained('parkir_masuk')->onDelete('cascade');
            $table->timestamp('waktu_keluar');
            $table->integer('durasi'); // dalam menit
            $table->decimal('biaya', 10, 2);
            $table->enum('metode_pembayaran', ['QRIS', 'NFC']);
            $table->enum('status_pembayaran', ['lunas', 'gagal'])->default('gagal');
        });
    }

    public function down() {
        Schema::dropIfExists('parkir_keluar');
    }
};
