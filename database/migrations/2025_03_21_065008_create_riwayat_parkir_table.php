<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('riwayat_parkir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('total_durasi'); // dalam menit
            $table->decimal('total_biaya', 10, 2);
            $table->integer('jumlah_transaksi');
        });
    }

    public function down() {
        Schema::dropIfExists('riwayat_parkir');
    }
};
