<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function index()
    // {
    //     $courses = Course::with('user')->limit(5)->get();

    //     return view('index', compact('courses'));
    // }

    public function index()
    {
        $courses = Course::with('user')
            ->orderBy('hit', 'desc') 
            ->limit(5)
            ->get();

        return view('index', compact('courses'));
    }

}
