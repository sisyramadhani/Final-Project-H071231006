<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Materi;
use App\Models\MyCourse;
use App\Models\Progres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class CourseAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user(); 
        $search = $request->input('search');
        
        $query = Course::where('is_delete', 0);
    
        if ($user->hasRole('teacher')) {
            $query->where('user_id', $user->id);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_course', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('user', function($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
            });
        }
    
        $courses = $query->paginate(10);
    
        return view('admin.course.index', compact('courses', 'search'));
    }
    
    
    

    public function store(Request $request)
    {
        $request->validate([
            'nama_course' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time', 
        ]);
    
        Course::create([
            'nama_course' => $request->nama_course,
            'deskripsi' => $request->deskripsi,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'user_id' => Auth::id(),
        ]);
    
        return redirect()->route('admin.course.index')->with('success', 'Course successfully created!');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_course' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
    
        $course = Course::findOrFail($id);
    
        $course->update([
            'nama_course' => $request->nama_course,
            'deskripsi' => $request->deskripsi,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    
        return redirect()->route('admin.course.index')->with('success', 'Course successfully updated!');
    }
    

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course) {
            $course->is_delete = 1;
            $course->save();
    
            Materi::where('id_course', $id)->update(['is_delete' => 1]);
    
            return redirect()->route('admin.course.index')->with('success', 'Course and its materials successfully marked as deleted!');
        }
    
        return redirect()->route('admin.course.index')->with('error', 'Course not found!');
    }
    
    

    // public function showDetail($id)
    // {
    //     $user = auth()->user();
    //     $course = Course::findOrFail($id);
    //     $materis = $course->materis()->where('is_delete',0)->paginate(10); 
    
    //     $totalMateri = $course->materis()->where('is_delete',0)->count();
    
    //     $completedMateriCount = $user->progres()
    //         ->whereIn('materi_id', $course->materis->pluck('id'))
    //         ->count();
    
    //     $progressPercentage = $totalMateri > 0 ? ($completedMateriCount / $totalMateri) * 100 : 0;
    
    //     $isCompleted = $completedMateriCount === $totalMateri;
    
    //     return view('admin.course.detail', compact('course', 'materis', 'user', 'isCompleted', 'progressPercentage'));
    // }   
    
    public function showDetail($id)
    {
        $user = auth()->user();
        $course = Course::findOrFail($id);
        $materis = $course->materis()->where('is_delete', 0)->paginate(10);

        $totalMateri = $course->materis()->where('is_delete', 0)->count();

        $completedMateriCount = $user->progres()
            ->whereIn('materi_id', $course->materis->pluck('id'))
            ->count();

        $progressPercentage = $totalMateri > 0 ? ($completedMateriCount / $totalMateri) * 100 : 0;

        $isCompleted = $completedMateriCount === $totalMateri;

        $teacher = $course->user;
        $teacherPhone = $teacher ? $teacher->no_telp : null;

        return view('admin.course.detail', compact('course', 'materis', 'user', 'isCompleted', 'progressPercentage', 'teacherPhone'));
    }



    // public function followCourse(Request $request)
    // {
    //     $user = auth()->user();
    //     $courseId = $request->course_id;

    //     if (MyCourse::where('user_id', $user->id)->where('course_id', $courseId)->exists()) {
    //         return response()->json(['message' => 'Anda sudah mengikuti kursus ini.'], 400);
    //     }

    //     MyCourse::create([
    //         'user_id' => $user->id, 
    //         'course_id' => $courseId, 
    //     ]);

    //     return response()->json(['message' => 'Kursus berhasil diikuti.'], 200);
    // }

    public function followCourse(Request $request)
    {
        $user = auth()->user();
        $courseId = $request->course_id;

        if (MyCourse::where('user_id', $user->id)->where('course_id', $courseId)->exists()) {
            return response()->json(['message' => 'Anda sudah mengikuti kursus ini.'], 400);
        }

        MyCourse::create([
            'user_id' => $user->id, 
            'course_id' => $courseId, 
        ]);

        $course = Course::find($courseId);
        if ($course) {
            $course->increment('hit');
        }

        return response()->json(['message' => 'Kursus berhasil diikuti.', 'hit' => $course ? $course->hit : 0], 200);
    }


    public function completeCourse(Request $request)
    {
        $user = auth()->user();
        $materiId = $request->materi_id;

        if (Progres::where('user_id', $user->id)->where('materi_id', $materiId)->exists()) {
            return redirect()->back()->with('message', 'Anda sudah menyelesaikan materi ini.');
        }

        Progres::create([
            'user_id' => $user->id,
            'materi_id' => $materiId,
        ]);

        return redirect()->back()->with('message', 'Materi berhasil diselesaikan.');
    }
    public function printCertificate($courseId)
    {
        $user = auth()->user();
        $course = Course::findOrFail($courseId);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('student.certificate', compact('user', 'course'))->render();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        return $dompdf->stream('certificate.pdf');
    }

    public function activecourses()
    {
        $user = auth()->user();
    
        $courses = Course::whereHas('materis', function ($query) {
            $query->where('is_delete', 0);
        })->whereHas('materis.progres', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    
        $coursesProgress = $courses->map(function ($course) use ($user) {
            $totalMateri = $course->materis()->where('is_delete', 0)->count();
            $completedMateriCount = $user->progres()
                ->whereIn('materi_id', $course->materis()->where('is_delete', 0)->pluck('id')) 
                ->count();
    
            $progressPercentage = $totalMateri > 0 ? ($completedMateriCount / $totalMateri) * 100 : 0;
    
            return [
                'course' => $course,
                'progress' => round($progressPercentage, 2),
            ];
        });
    
        return view('admin.activecourse.index', compact('coursesProgress'));
    }
    


    public function progresstudent()
    {
        $user = auth()->user();
    
        if ($user->hasRole('teacher')) {
            $courses = Course::where('user_id', $user->id)
                ->with(['materis' => function ($query) {
                    $query->where('is_delete', 0); 
                }, 'materis.progres.user'])
                ->get();
        } else {
            $courses = Course::with([
                'materis' => function ($query) {
                    $query->where('is_delete', 0); 
                }, 'materis.progres.user'])
                ->get();
        }
    
        $coursesProgress = $courses->map(function ($course) {
            $totalMateri = $course->materis->count(); 
    
            $studentsProgress = $course->materis->flatMap->progres
                ->groupBy('user_id')
                ->map(function ($progress, $userId) use ($totalMateri) {
                    $completedMateriCount = $progress->count();
                    $progressPercentage = $totalMateri > 0 ? ($completedMateriCount / $totalMateri) * 100 : 0;
    
                    return [
                        'user_id' => $userId,
                        'progress' => round($progressPercentage, 2),
                    ];
                });
    
            return [
                'course' => $course,
                'studentsProgress' => $studentsProgress,
            ];
        });
        return view('admin.progresstudent.index', compact('coursesProgress'));
    }
    
    

}

