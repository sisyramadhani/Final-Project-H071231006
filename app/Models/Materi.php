<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materis';

    // Tentukan field yang dapat diisi
    protected $fillable = [
        'id_course',
        'nama_materi',
        'judul',
        'deskripsi',
        'file',
        'is_delete',
        'id_user'
    ];

    // Relasi dengan course
    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    // App\Models\Materi.php
    public function progres()
    {
        return $this->hasMany(Progres::class, 'materi_id');
    }

}

