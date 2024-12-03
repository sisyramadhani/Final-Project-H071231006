<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyCourse extends Model
{
    use HasFactory;

    protected $table = 'my_course';

    protected $fillable = [
        'user_id',
        'course_id',
    ];

    // Menetapkan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Menetapkan relasi dengan model Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    // MyCourse.php (Model)
    public function progress()
    {
        return $this->hasMany(Progres::class); // Relasi ke progress atau penyelesaian materi
    }


}
