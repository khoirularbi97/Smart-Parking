<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parkir_keluar_id')->constrained('parkir_keluar')->onDelete('cascade');
            $table->decimal('total_bayar', 10, 2);
            $table->enum('metode_pembayaran', ['QRIS', 'NFC']);
            $table->enum('status', ['lunas', 'gagal'])->default('gagal');
            $table->timestamp('waktu_pembayaran');
        });
    }

    public function down() {
        Schema::dropIfExists('pembayaran');
    }
};
