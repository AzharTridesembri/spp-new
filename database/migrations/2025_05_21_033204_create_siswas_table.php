<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->char('nisn', 10)->unique();
            $table->char('nis', 8)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama', 35);
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->text('alamat');
            $table->string('no_telp', 13);
            $table->foreignId('spp_id')->constrained('spps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
