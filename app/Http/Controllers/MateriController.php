<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_course' => 'required|exists:courses,id', 
            'judul' => 'required|string|max:255', 
            'deskripsi' => 'required|string', 
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        
        $materi = new Materi();
        $materi->id_course = $request->id_course;
        $materi->judul = $request->judul; 
        $materi->deskripsi = $request->deskripsi; 
        $materi->id_user = auth()->id();
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    
            $materi->file = $file->storeAs('materi_files', $fileName, 'public');
        }
        
        $materi->save();
        
        return redirect()->route('course.showDetail', $request->id_course)
                         ->with('success', 'Materi added successfully.');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_course' => 'required|exists:courses,id',
    //         'judul' => 'required|string|max:255',
    //         'deskripsi' => 'required|string',
    //         'file' => 'nullable|file|mimes:pdf|max:10240', 
    //     ]);
        
    //     $materi = new Materi();
    //     $materi->id_course = $request->id_course;
    //     $materi->judul = $request->judul;
    //     $materi->deskripsi = $request->deskripsi;
    //     $materi->id_user = auth()->id();
        
    //     if ($request->hasFile('file')) {
    //         $materi->file = $request->file('file')->store('materi_files', 'public');
    //     }
        
    //     $materi->save();
        
    //     return redirect()->route('course.showDetail', $request->id_course)->with('success', 'Materi added successfully.');
    // }
    
    
    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        $materi->judul = $request->judul;
        $materi->deskripsi = $request->deskripsi;
        if ($request->hasFile('file')) {
            if ($materi->file) {
                Storage::delete('public/' . $materi->file);
            }
            $materi->file = $request->file('file')->store('materi_files', 'public');
        }
        $materi->save();
        return redirect()->route('course.showDetail', $materi->id_course)->with('success', 'Materi updated successfully.');
    }
    
    public function destroy(Materi $materi)
    {
        $materi->is_delete = 1;
        $materi->save();
        return redirect()->route('course.showDetail', $materi->id_course)->with('success', 'Materi deleted successfully.');
    }
    
}
