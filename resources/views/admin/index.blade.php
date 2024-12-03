@extends('layouts.app2')

@section('content')
<head>
    <style>
        h2 {
            color: #ffffff !important;
        }
    </style>
</head>
@role('student')
    <div class="container mt-5 text-center">
        <section class="welcome-section py-5" style="background-color: #010e31;">
            <div class="container text-white">
                <h2 class="display-4 mb-4">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="lead mb-4">
                    Selamat datang di platform pembelajaran kami. 
                </p>
                <a href="{{ route('admin.course.index') }}" class="btn btn-lg btn-light text-dark px-5 py-3 shadow-lg">
                    Lanjutkan Belajar
                </a>
            </div>
        </section>
        
        <div class="row mt-5 text-center">
            <div class="col-md-12">
                <h3 class="text-primary">Jelajahi Kursus</h3>
                <p>Temukan berbagai kursus menarik yang dapat membantu Anda mengembangkan kemampuan baru.</p>
            </div>
    </div>
@endrole

@role('teacher')
    <div class="container mt-5 text-center">
        <section class="welcome-section py-5" style="background-color: #010e31;">
            <div class="container text-white">
                <h2 class="display-4 mb-4">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <a href="{{ route('admin.course.index') }}" class="btn btn-lg btn-light text-dark px-5 py-3 shadow-lg">
                    Tambahkan Kursus
                </a>
            </div>
        </section>
        
        <div class="row mt-5 text-center">
            <div class="col-md-12">
                <h3 class="text-primary">Jelajahi Kursus yang Telah Anda Buat</h3>
                <p>Buatlah berbagai kursus menarik yang dapat membantu untuk mengembangkan kemampuan baru.</p>
            </div>
    </div>
@endrole

@role('admin')
    <div class="container mt-5 text-center">
        <section class="welcome-section py-5" style="background-color: #010e31;">
            <div class="container text-white">
                <h2 class="display-4 mb-4">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <a href="{{ route('admin.course.index') }}" class="btn btn-lg btn-light text-dark px-5 py-3 shadow-lg">
                    Pantau Kursus
                </a>
            </div>
        </section>
    </div>
@endrole
@endsection
