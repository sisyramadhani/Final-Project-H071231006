@extends('layouts.app2')

@section('content')
<head>
    <style>
        form.d-flex input.form-control {
            flex: 1;
            height: calc(2.5rem + 2px);
        }

        form.d-flex button {
            height: calc(2.5rem + 2px); 
            line-height: 1.5; 
            white-space: nowrap; 
        }

    </style>
</head>
<div class="card mb-5 mb-xl-8">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Daftar Course</span>
        </h3>
        <form action="{{ route('admin.course.index') }}" method="GET" class="d-flex align-items-center">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search courses..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="ki-outline ki-magnifier fs-2"></i> Search
            </button>
        </form>
        @role('admin')
        <div class="card-toolbar">
            <button class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                <i class="ki-outline ki-plus fs-2"></i> New Course
            </button>
        </div>
        @endrole
        @role('teacher')
        <div class="card-toolbar">
            <button class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                <i class="ki-outline ki-plus fs-2"></i> New Course
            </button>
        </div>
        @endrole
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">No</th>
                        <th class="min-w-150px">Course Name</th>
                        <th class="min-w-200px">Description</th>
                        <th class="min-w-100px">Added By</th>
                        <th class="min-w-150px">Waktu Mulai</th>
                        <th class="min-w-150px">Waktu Selesai</th>
                        <th class="min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $key => $course)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $course->nama_course }}</td>
                            <td>{{ $course->deskripsi }}</td>
                            <td>{{ $course->user->name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($course->start_time)->isoFormat('D MMMM YYYY [Pukul] HH:mm') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($course->end_time)->isoFormat('D MMMM YYYY [Pukul] HH:mm') }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    @role('admin')
                                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editCourseModal" data-course="{{ json_encode($course) }}">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </button>
                                    @endrole
                                    @role('teacher')
                                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editCourseModal" data-course="{{ json_encode($course) }}">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </button>
                                    @endrole
                                    @role('admin')
                                    <form action="{{ route('course.destroy', $course->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-btn">
                                            <i class="ki-outline ki-trash fs-2"></i>
                                        </button>
                                    </form>  
                                    &nbsp; 
                                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <a href="{{ route('course.showDetail', $course->id) }}" class="text-decoration-none">
                                            <i class="ki-outline ki-eye fs-2"></i>
                                        </a>
                                    </button>  
                                    @endrole
                                    @role('teacher')
                                    <form action="{{ route('course.destroy', $course->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-btn">
                                            <i class="ki-outline ki-trash fs-2"></i>
                                        </button>
                                    </form>    
                                    &nbsp; 
                                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <a href="{{ route('course.showDetail', $course->id) }}" class="text-decoration-none">
                                            <i class="ki-outline ki-eye fs-2"></i>
                                        </a>
                                    </button>
                                    @endrole
                                    @role('student')
                                    @if (!in_array($course->id, auth()->user()->myCourses->pluck('course_id')->toArray()))
                                        <button class="btn btn-sm btn-light btn-active-primary follow-course" data-course-id="{{ $course->id }}">
                                            Ikuti
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-light ">
                                            <a href="{{ route('course.showDetail', $course->id) }}" class="text-decoration-none">Lihat Materi</a>
                                        </button>
                                    @endif
                                    @endrole                                                                 
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} entries
            </div>
            {{ $courses->onEachSide(1)->links('vendor.pagination.custom-pagination') }}
        </div>
    </div>    
</div>

<div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createCourseForm" action="{{ route('course.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCourseModalLabel">New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create-nama_course" class="form-label">Course Name</label>
                        <input type="text" name="nama_course" id="create-nama_course" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="create-deskripsi" class="form-label">Description</label>
                        <textarea name="deskripsi" id="create-deskripsi" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create-start_time" class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" id="create-start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="create-end_time" class="form-label">End Time</label>
                        <input type="datetime-local" name="end_time" id="create-end_time" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCourseForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-nama_course" class="form-label">Course Name</label>
                        <input type="text" name="nama_course" id="edit-nama_course" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-deskripsi" class="form-label">Description</label>
                        <textarea name="deskripsi" id="edit-deskripsi" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-start_time" class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" id="edit-start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-end_time" class="form-label">End Time</label>
                        <input type="datetime-local" name="end_time" id="edit-end_time" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).on('click', '.follow-course', function () {
        const courseId = $(this).data('course-id');

        Swal.fire({
            title: 'Apakah Anda yakin ingin mengikuti kursus ini?',
            text: 'Anda akan bisa mengakses materi setelah mengikuti kursus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, ikuti!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("course.follow") }}',
                    method: 'POST',
                    data: {
                        course_id: courseId,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire('Sukses!', response.message, 'success');
                        location.reload();
                    },
                    error: function(error) {
                        Swal.fire('Gagal!', error.responseJSON.message, 'error');
                    }
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,  
                showConfirmButton: false, 
            });
        @endif

        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editCourseModal = document.getElementById('editCourseModal');
        editCourseModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const course = JSON.parse(button.getAttribute('data-course'));

            const editCourseForm = document.getElementById('editCourseForm');
            editCourseForm.action = `{{ url('/course') }}/${course.id}`;

            document.getElementById('edit-nama_course').value = course.nama_course;
            document.getElementById('edit-deskripsi').value = course.deskripsi;
        });
    });
</script>
@endpush
