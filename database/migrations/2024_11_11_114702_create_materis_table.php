<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->id();  // ID materi
            $table->unsignedBigInteger('id_course'); // Relasi dengan course
            $table->string('nama_materi'); // Nama materi
            $table->string('judul'); // Judul materi
            $table->text('deskripsi'); // Deskripsi materi
            $table->string('file')->nullable(); // Nama file (PDF)
            $table->boolean('is_delete')->default(0); // Soft delete
            $table->unsignedBigInteger('id_user'); // User yang membuat materi
            $table->timestamps();
    
            // Menambahkan foreign key untuk relasi dengan course
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');
    
            // Menambahkan foreign key untuk relasi dengan user
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
