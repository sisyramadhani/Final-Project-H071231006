<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // Kolom id, primary key
            $table->string('nama_course'); // Kolom nama_course
            $table->text('deskripsi'); // Kolom deskripsi
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel users (menyimpan user yang menambahkan)
            $table->boolean('is_delete')->default(0); // Kolom is_delete dengan default 0 (menandakan data belum dihapus)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
