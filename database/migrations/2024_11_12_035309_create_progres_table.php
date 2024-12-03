<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgresTable extends Migration
{
    public function up()
    {
        Schema::create('progres', function (Blueprint $table) {
            $table->id(); // Kolom id otomatis dibuat sebagai primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kolom user_id, terkoneksi dengan tabel users
            $table->foreignId('materi_id')->constrained()->onDelete('cascade'); // Kolom materi_id, terkoneksi dengan tabel materi (atau yang relevan)
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('progres');
    }
}
