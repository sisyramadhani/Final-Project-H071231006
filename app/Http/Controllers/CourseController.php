<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); 
        $query = \App\Models\Course::with('user');
    
        if ($search) {
            $query->where('nama_course', 'like', '%' . $search . '%');
        }
    
        $courses = $query->limit(5)->get();
    
        return view('course', compact('courses', 'search'));
    }
    
    
}
