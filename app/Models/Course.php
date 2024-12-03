<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['nama_course', 'deskripsi', 'user_id','start_time','end_time'];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }
    public function materis()
    {
        return $this->hasMany(Materi::class, 'id_course');
    }
    public function myCourses()
    {
        return $this->hasMany(MyCourse::class);
    }

    public function isCompletedByUser(User $user)
    {
        $myCourse = MyCourse::where('course_id', $this->id)
                            ->where('user_id', $user->id)
                            ->first();

        if (!$myCourse) {
            return false;
        }

        return $this->materis->every(function ($materi) use ($user) {
            return $user->progres()->where('materi_id', $materi->id)->exists();
        });
    }

}
