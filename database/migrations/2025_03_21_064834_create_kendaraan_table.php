<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('member')->onDelete('cascade');
            $table->string('plat_nomor', 15)->unique();
            $table->enum('tipe_kendaraan', ['mobil', 'motor']);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('kendaraan');
    }
};
