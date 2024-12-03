@extends('layouts.app2')

@section('content')
<div class="card mb-5 mb-xl-8">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Detail Course: {{ $course->nama_course }}</span>
        </h3>
        @role('admin')
        <div class="card-toolbar">
            <button class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#createMateriModal">
                <i class="ki-outline ki-plus fs-2"></i> Add Materi
            </button>
        </div>
        @endrole
        @role('teacher')
        <div class="card-toolbar">
            <button class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#createMateriModal">
                <i class="ki-outline ki-plus fs-2"></i> Add Materi
            </button>
        </div>
        @endrole
    </div>
    @role('admin')
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">No</th>
                        <th class="min-w-200px">Judul</th>
                        <th class="min-w-100px">Deskripsi</th>
                        <th class="min-w-100px">File</th>
                        <th class="min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materis as $key => $materi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ $materi->deskripsi }}</td>
                            <td>
                                @if ($materi->file)
                                    <a href="{{ asset('storage/' . $materi->file) }}" target="_blank">Download</a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editMateriModal" data-materi="{{ json_encode($materi) }}">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </button>
                                    
                                    <form action="{{ route('materi.destroy', $materi->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-btn">
                                            <i class="ki-outline ki-trash fs-2"></i>
                                        </button>
                                    </form>   
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $materis->firstItem() }} to {{ $materis->lastItem() }} of {{ $materis->total() }} entries
            </div>
            {{ $materis->onEachSide(1)->links('vendor.pagination.custom-pagination') }}
        </div>
    </div>
    @endrole
    @role('teacher')
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">No</th>
                        <th class="min-w-200px">Judul</th>
                        <th class="min-w-100px">Deskripsi</th>
                        <th class="min-w-100px">File</th>
                        <th class="min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materis as $key => $materi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ $materi->deskripsi }}</td>
                            <td>
                                @if ($materi->file)
                                    <a href="{{ asset('storage/' . $materi->file) }}" target="_blank">Download</a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editMateriModal" data-materi="{{ json_encode($materi) }}">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </button>
                                    
                                    <form action="{{ route('materi.destroy', $materi->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-btn">
                                            <i class="ki-outline ki-trash fs-2"></i>
                                        </button>
                                    </form>   
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $materis->firstItem() }} to {{ $materis->lastItem() }} of {{ $materis->total() }} entries
            </div>
            {{ $materis->onEachSide(1)->links('vendor.pagination.custom-pagination') }}
        </div>
    </div>
    @endrole

    {{-- @role('student')
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">No</th>
                        <th class="min-w-200px">Judul</th>
                        <th class="min-w-100px">Deskripsi</th>
                        <th class="min-w-100px">File</th>
                        <th class="min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materis as $key => $materi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ $materi->deskripsi }}</td>
                            <td>
                                @if ($materi->file)
                                    <a href="{{ asset('storage/' . $materi->file) }}" target="_blank">Lihat</a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    @if ($user->hasProgress($materi->id)) 
                                        <i class="ki-outline ki-check-circle fs-2 text-success"></i>
                                    @else
                                        <form action="{{ route('student.completeCourse') }}" method="POST" class="follow-form d-inline">
                                            @csrf
                                            <input type="hidden" name="materi_id" value="{{ $materi->id }}">
                                            <button type="submit" class="btn btn-sm btn-light d-flex align-items-center">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ round($progressPercentage, 2) }}%
            </div>
        </div>
        
        @if ($isCompleted)
            <div class="mt-3 text-center">
                <a href="{{ route('student.printCertificate', $course->id) }}" class="btn btn-success btn-lg">
                    Cetak Sertifikat
                </a>
            </div>
        @endif
    
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $materis->firstItem() }} to {{ $materis->lastItem() }} of {{ $materis->total() }} entries
            </div>
            {{ $materis->onEachSide(1)->links('vendor.pagination.custom-pagination') }}
        </div>        
    </div>
    @endrole     --}}

    {{-- @role('student')
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">No</th>
                        <th class="min-w-200px">Judul</th>
                        <th class="min-w-100px">Deskripsi</th>
                        <th class="min-w-100px">File</th>
                        <th class="min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materis as $key => $materi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ $materi->deskripsi }}</td>
                            <td>
                                @if ($materi->file)
                                    <a href="{{ asset('storage/' . $materi->file) }}" target="_blank" class="lihat-materi" data-materi-id="{{ $materi->id }}">Lihat</a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    @if ($user->hasProgress($materi->id)) 
                                        <i class="ki-outline ki-check-circle fs-2 text-success"></i>
                                    @else
                                        <form action="{{ route('student.completeCourse') }}" method="POST" class="follow-form d-inline complete-form">
                                            @csrf
                                            <input type="hidden" name="materi_id" value="{{ $materi->id }}">
                                            <button type="submit" class="btn btn-sm btn-light d-flex align-items-center" data-materi-id="{{ $materi->id }}">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ round($progressPercentage, 2) }}%
            </div>
        </div>
        
        @if ($isCompleted)
            <div class="mt-3 text-center">
                <a href="{{ route('student.printCertificate', $course->id) }}" class="btn btn-success btn-lg">
                    Cetak Sertifikat
                </a>
            </div>
        @endif

        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $materis->firstItem() }} to {{ $materis->lastItem() }} of {{ $materis->total() }} entries
            </div>
            {{ $materis->onEachSide(1)->links('vendor.pagination.custom-pagination') }}
        </div>        
    </div>
    @endrole --}}

    @role('student')
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">No</th>
                        <th class="min-w-200px">Judul</th>
                        <th class="min-w-100px">Deskripsi</th>
                        <th class="min-w-100px">File</th>
                        <th class="min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materis as $key => $materi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ $materi->deskripsi }}</td>
                            <td>
                                @if ($materi->file)
                                    <a href="{{ asset('storage/' . $materi->file) }}" target="_blank" class="lihat-materi" data-materi-id="{{ $materi->id }}">Lihat</a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    @if ($user->hasProgress($materi->id)) 
                                        <i class="ki-outline ki-check-circle fs-2 text-success"></i>
                                    @else
                                        <form action="{{ route('student.completeCourse') }}" method="POST" class="follow-form d-inline complete-form">
                                            @csrf
                                            <input type="hidden" name="materi_id" value="{{ $materi->id }}">
                                            <button type="submit" class="btn btn-sm btn-light d-flex align-items-center" data-materi-id="{{ $materi->id }}">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ round($progressPercentage, 2) }}%
            </div>
        </div>
        
        @if ($isCompleted)
            <div class="mt-3 text-center">
                <a href="{{ route('student.printCertificate', $course->id) }}" class="btn btn-success btn-lg">
                    Cetak Sertifikat
                </a>
            </div>
        @endif

        <div class="mt-3 text-center">
            <button 
                class="btn btn-primary" 
                onclick="contactTeacher()">
                Hubungi Teacher
            </button>
        </div>

        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $materis->firstItem() }} to {{ $materis->lastItem() }} of {{ $materis->total() }} entries
            </div>
            {{ $materis->onEachSide(1)->links('vendor.pagination.custom-pagination') }}
        </div>        
    </div>
    @endrole


<div class="modal fade" id="createMateriModal" tabindex="-1" aria-labelledby="createMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_course" value="{{ $course->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMateriModalLabel">New Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File (PDF)</label>
                        <input type="file" name="file" class="form-control" accept=".pdf">
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

<div class="modal fade" id="editMateriModal" tabindex="-1" aria-labelledby="editMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMateriForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editMateriModalLabel">Edit Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-judul" class="form-label">Judul</label>
                        <input type="text" name="judul" id="edit-judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit-deskripsi" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-file" class="form-label">File (PDF)</label>
                        <input type="file" name="file" class="form-control" accept=".pdf">
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
    let materiSeen = {};
    document.querySelectorAll('.lihat-materi').forEach(item => {
        item.addEventListener('click', function() {
            const materiId = this.getAttribute('data-materi-id');
            materiSeen[materiId] = true;
        });
    });
    document.querySelectorAll('.complete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            const materiId = this.querySelector('button').getAttribute('data-materi-id');
            
            if (!materiSeen[materiId]) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silahkan Baca Materi Terlebih Dahulu!',
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
            });
        @endif
        $('#editMateriModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var materi = button.data('materi'); 
            $('#edit-nama_materi').val(materi.nama_materi);
            $('#edit-judul').val(materi.judul);
            $('#edit-deskripsi').val(materi.deskripsi);
            $('#editMateriForm').attr('action', '/materi/' + materi.id);
        });
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form'); 
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
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
    function contactTeacher() {
        var phoneNumber = "{{ $teacherPhone }}"; 

        if (!phoneNumber) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Teacher Belum Memasukan No Telponnya',
                confirmButtonText: 'OK',
            });
            return;
        }
        var url = "https://wa.me/" + phoneNumber;
        window.open(url, "_blank");
    }
</script>
@endpush
