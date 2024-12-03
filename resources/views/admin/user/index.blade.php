@extends('layouts.app2')

@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <form id="kt_account_profile_details_form" class="form" action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')  
            <div class="card-body border-top p-9">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                    <div class="col-lg-8">
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ asset('assets/media/svg/avatars/blank.svg') }}')">
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/media/svg/avatars/blank.svg') }}')"></div>
                            
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="ki-outline ki-cross fs-2"></i>
                            </span>
                        </div>
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    </div>
                </div>                
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Your name" value="{{ Auth::user()->name }}" />
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Phone Number</label>
                    <div class="col-lg-8 fv-row">
                        <input 
                            type="text" 
                            name="no_telp" 
                            class="form-control form-control-lg form-control-solid" 
                            placeholder="Your Phone Number" 
                            value="{{ Auth::user()->no_telp }}" 
                            maxlength="13" 
                            oninput="formatPhoneNumber(this)" 
                        />
                    </div>
                </div>               
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span class="">Email</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email address" value="{{ Auth::user()->email }}" disabled />
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Role</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" class="form-control form-control-lg form-control-solid" value="{{ Auth::user()->getRoleNames()->implode(', ') }}" disabled />
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
            </div>
        </form>
        
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Sign-in Method</h3>
        </div>
    </div>
    <div id="kt_account_settings_signin_method" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="d-flex flex-wrap align-items-center">
                <div id="kt_signin_email">
                    <div class="fs-6 fw-bold mb-1">Email Address</div>
                    <div class="fw-semibold text-gray-600">{{ Auth::user()->email }}</div>
                </div>
                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                    <form id="kt_signin_change_email" action="{{ route('user.updateEmail') }}" method="POST">
                        @csrf
                        <div class="row mb-6">
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="fv-row mb-0">
                                    <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New Email Address</label>
                                    <input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="emailaddress" value="{{ Auth::user()->email }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="fv-row mb-0">
                                    <label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="confirmemailpassword" id="confirmemailpassword" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button id="kt_signin_submit" type="submit" class="btn btn-primary me-2 px-6">Update Email</button>
                            <button id="kt_signin_cancel" type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>
                </div>
                <div id="kt_signin_email_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">Change Email</button>
                </div>
            </div>
            <div class="separator separator-dashed my-6"></div>
            <div class="d-flex flex-wrap align-items-center mb-10">
                <div id="kt_signin_password">
                    <div class="fs-6 fw-bold mb-1">Password</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>
                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                    <form id="kt_signin_change_password" action="{{ route('user.updatePassword') }}" method="POST">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="newpassword_confirmation" class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword_confirmation" id="newpassword_confirmation" />
                                </div>
                            </div>
                        </div>                        
                        <div class="form-text mb-5">Password must be at least 8 characters and contain symbols</div>
                        <div class="d-flex">
                            <button id="kt_password_submit" type="submit" class="btn btn-primary me-2 px-6">Update Password</button>
                            <button id="kt_password_cancel" type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>
                </div>
                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">Reset Password</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#kt_signin_email_button button').click(function() {
            $(this).addClass('d-none');
            $('#kt_signin_email').addClass('d-none');
            $('#kt_signin_email_edit').removeClass('d-none');
        });

        $('#kt_signin_cancel').click(function() {
            $('#kt_signin_email_edit').addClass('d-none');
            $('#kt_signin_email').removeClass('d-none');
            $('#kt_signin_email_button button').removeClass('d-none');
        });

        $('#kt_signin_password_button button').click(function() {
            $(this).addClass('d-none');
            $('#kt_signin_password').addClass('d-none');
            $('#kt_signin_password_edit').removeClass('d-none');
        });

        $('#kt_password_cancel').click(function() {
            $('#kt_signin_password_edit').addClass('d-none');
            $('#kt_signin_password').removeClass('d-none');
            $('#kt_signin_password_button button').removeClass('d-none');
        });

        @if(session('email_updated'))
            Swal.fire({
                icon: 'success',
                title: 'Email Updated!',
                text: 'Your email has been successfully updated.',
            });
        @endif
        @if($errors->has('currentpassword'))
                Swal.fire({
                    icon: 'error',
                    title: 'Password Lama Salah',
                    text: '{{ $errors->first('currentpassword') }}',
                });
        @endif
        @if(session('password_updated'))
            Swal.fire({
                icon: 'success',
                title: 'Password Updated!',
                text: 'Your password has been successfully updated.',
            });
        @endif
        @if(session('profile_updated'))
                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated',
                    text: 'Your profile details have been successfully updated!',
                    confirmButtonText: 'Okay'
                });
        @endif

    });
    function formatPhoneNumber(input) {
        let phoneNumber = input.value.replace(/[^0-9]/g, '');
        
        if (phoneNumber.startsWith('0')) {
            phoneNumber = '62' + phoneNumber.substring(1);
        } else if (!phoneNumber.startsWith('62')) {
            phoneNumber = '62' + phoneNumber;
        }
        
        phoneNumber = phoneNumber.slice(0, 13);
        
        input.value = phoneNumber;
    }
</script>
@endpush
