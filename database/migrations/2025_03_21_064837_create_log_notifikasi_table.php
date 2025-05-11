<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('log_notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('member')->onDelete('cascade');
            $table->enum('jenis', ['masuk', 'keluar', 'pembayaran']);
            $table->text('pesan');
            $table->enum('status', ['terkirim', 'gagal'])->default('terkirim');
            $table->timestamp('waktu_kirim');
        });
    }

    public function down() {
        Schema::dropIfExists('log_notifikasi');
    }
};
