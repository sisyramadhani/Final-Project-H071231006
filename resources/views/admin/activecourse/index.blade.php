@extends('layouts.app2')
@section('content')
<div class="col-xl-12">
    <div class="card card-flush h-xl-100">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Kursus Yang Aktif</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Kursus Yang Diambil Berdasarkan Progesnya</span>
            </h3>
        </div>
        <div class="card-body pt-5">
            @foreach($coursesProgress as $courseData)
                <div class="d-flex flex-stack mb-5">
                    <div class="d-flex align-items-center me-3">
                        <img src="{{ asset('admin/assets/media/svg/brand-logos/laravel-2.svg') }}" class="me-4 w-30px" alt="" />
                        <div class="flex-grow-1">
                            <a href="{{ route('course.showDetail', $courseData['course']->id) }}" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">
                                {{ $courseData['course']->nama_course }}
                            </a>
                            <span class="text-gray-500 fw-semibold d-block fs-6">{{ $courseData['course']->nama_course }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-100 mw-125px">
                        <div class="progress h-6px w-100 me-2 bg-light-success">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $courseData['progress'] }}%;" aria-valuenow="{{ $courseData['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="text-gray-500 fw-semibold">{{ $courseData['progress'] }}%</span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
            @endforeach
        </div>
    </div>
</div>
@endsection
