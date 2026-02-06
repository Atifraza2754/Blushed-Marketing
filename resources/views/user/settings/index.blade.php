@extends('user.layouts.master', ['module' => "settings"])
@section('title')
    Settings
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="main-content">
        <div class="container">

            <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

                <div class="col-lg-3">
                    <h1 class="f-32 mb-0 w-600 ">
                        Settings
                    </h1>
                    <p class="f-14 text-gray w-500 mt-1">
                        Update and manage your account
                    </p>
                    <div class="side-nav2">
                        <ul class="ms-0 ps-0">
                            <li onclick="settings(event, 'profile')" class="tab-li" id="defaultOpen-side">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4 2C2.89543 2 2 2.89543 2 4V20C2 21.1046 2.89543 22 4 22H20C21.1046 22 22 21.1046 22 20V4C22 2.89543 21.1046 2 20 2H4ZM15 9C15 10.6575 13.6575 12 12 12C10.3425 12 9 10.6575 9 9C9 7.3425 10.3425 6 12 6C13.6575 6 15 7.3425 15 9ZM6 16.6667C6 14.8933 9.9975 14 12 14C14.0025 14 18 14.8933 18 16.6667V18H6V16.6667Z" />
                                </svg>
                                Profile
                            </li>
                            <li onclick="settings(event, 'documents')" class="tab-li">

                                <svg width="18" height="20" viewBox="0 0 18 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16 2H11.82C11.4 0.84 10.3 0 9 0C7.7 0 6.6 0.84 6.18 2H2C0.9 2 0 2.9 0 4V18C0 19.1 0.9 20 2 20H16C17.1 20 18 19.1 18 18V4C18 2.9 17.1 2 16 2ZM9 2C9.55 2 10 2.45 10 3C10 3.55 9.55 4 9 4C8.45 4 8 3.55 8 3C8 2.45 8.45 2 9 2ZM7 16L3 12L4.41 10.59L7 13.17L13.59 6.58L15 8L7 16Z" />
                                </svg>

                                Documents
                            </li>
                            <li onclick="settings(event, 'password')" class="tab-li">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18 8H17V6C17 3.24 14.76 1 12 1C9.24 1 7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM12 17C10.9 17 10 16.1 10 15C10 13.9 10.9 13 12 13C13.1 13 14 13.9 14 15C14 16.1 13.1 17 12 17ZM15.1 8H8.9V6C8.9 4.29 10.29 2.9 12 2.9C13.71 2.9 15.1 4.29 15.1 6V8Z" />
                                </svg>
                                Change Password
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">

                    {{-- include alerts --}}
                    @include('common.alerts')

                    {{-- profile tab content --}}
                    <div id="profile" class="tabcontent-side">
                        <h1 class="f-18 w-500">Profile</h1>
                        <form action="{{ URL::to('/user/settings/profile') }}" class="sign__frame-right--form" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="user_id">

                            <div class="row">
                                <div class="col-lg-8 order-lg-1 order-2">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="name" value="{{ $user->name }}" placeholder="">
                                                <label for="floatingInput sign-label">First Name <sup>*</sup></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="last_name" value="{{ $user->last_name }}" placeholder="">
                                                <label for="floatingInput sign-label">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="email" class="form-control sign-input" id="floatingInput"
                                                    name="email" value="{{ $user->email }}"
                                                    placeholder="name@example.com">
                                                <label for="floatingInput sign-label">Email Address <sup>*</sup></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-4 w-100 mt-2">
                                                <!-- <label for="phone sign-label">Your Role</label><br> -->
                                                <input id="phone" name="mobile_no" value="{{ $user->mobile_no }}"
                                                    type="tel" class=" sign-input w-100" required>
                                                <p class="f-12 text-gray w-400 mb-0 pb-0 mt-1">Standard call,
                                                    messaging or data rates may apply.</p>
                                            </div>
                                        </div>
                                        {{-- <div class="form-floating  mb-4 w-100">
                                            <div class="sign-input px-0 ps-0">
                                                <select class="js-example-basic-multiple  px-0 ps-0" id="floatingSelect"
                                                    name="states[]" multiple="multiple">
                                                    <option value="AL" selected>Market 1</option>
                                                    <option value="WY" selected>Market 2</option>
                                                    <option value="AL">Market 3</option>
                                                    <option value="WY">Market 4</option>
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div class="form-floating mb-4 w-100">
                                            <input type="date" class="form-control sign-input" id="floatingRole"
                                                name="date_of_birth" value="{{ $user->date_of_birth }}"
                                                placeholder="name@example.com" value="12/12/200">
                                            <label for="floatingRole sign-label">Date of Birth</label>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="address" value="{{ $user->address }}" placeholder="">
                                                <label for="floatingInput sign-label">Address</label>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-12">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    placeholder="">
                                                <label for="floatingInput sign-label">Address Line 02</label>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="state" value="{{ $user->state }}" placeholder="">
                                                <label for="floatingInput sign-label">State</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="city" value="{{ $user->city }}" placeholder="">
                                                <label for="floatingInput sign-label">City</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="zipcode" value="{{ $user->zipcode }}" placeholder="">
                                                <label for="floatingInput sign-label">Postal Code</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 order-lg-2 order-1 mb-4">
                                    <div class="display-pictute text-center">
                                        <div class="mb-0 mx-auto position-relative">
                                            @if ($user->profile_image)
                                                <img class="edit-img2 mx-auto mw-100"
                                                    src='{{ URL::to("/storage/images/users/md/$user->profile_image") }}'
                                                    id="output"  />
                                            @else
                                                <img class="edit-img2 mx-auto mw-100"
                                                    src="{{ URL::to('/assets/images/Asset2.png') }}" id="output" />
                                            @endif
                                            <div class="gradient"></div>
                                        </div>
                                        <p class="mb-0">
                                            <input type="file" accept="image/*" id="file" name="profile_image"
                                                onchange="loadFile(event)" style="display: none;">
                                        </p>
                                        <button type="button" class="upload-img-btn mx-auto">
                                            <label for="file" class="cursor-pointer">
                                                Upload Picture
                                            </label>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-12 order-3">
                                    {{-- <hr class="sign-line my-3"> --}}
                                    <div class="d-flex mt-4">
                                        {{-- <button type="button"
                                            class="main-btn-blank text-dark border-dark  ">Cancel</button> --}}
                                        <button type="submit" class="main-btn-blank ms-3 text-white bg-primary">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    {{-- documents tab content --}}
                    <div id="documents" class="tabcontent-side">

                        <h1 class="f-18 w-500">Documents</h1>
                        <form action="{{ URL::to('/user/settings/documents') }}" class="sign__frame-right--form "
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="user_id">

                            <div class="row w-100 ">
                                <div class="col-lg-12 ">
                                    <div class=" mt-4 mb-3">
                                        <p class="mb-0 pb-0 f-14 w-500 me-2">
                                            Upload your Photos*
                                        </p>
                                        <p class="p-0 m-0 f-12 w-500 text-gray-light">headshot, full body, photo from event
                                            worked</p>
                                    </div>

                                    <div class="d-flex flex-lg-row  flex-wrap  justify-content-around w-100">

                                        {{-- image 1 --}}
                                        <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                                            <div class="display-pictute text-center">
                                                <div class="mb-0 mx-auto position-relative">
                                                    @if ($user->image_1)
                                                        <img class="edit-img  mx-auto "
                                                            src='{{ URL::to("/storage/images/users/docs/md/$user->image_1") }}'
                                                            id="output1" />
                                                    @else
                                                        <img class="edit-img  mx-auto "
                                                            src="{{ URL::to('/assets/images/Asset2.png') }}"
                                                            id="output1" />
                                                    @endif
                                                    <div class="gradient"></div>
                                                    <div class="remove-picture remove-picture1 d-none">X</div>
                                                </div>
                                                <p class="mb-0">
                                                    <input type="file" accept="image/*" name="image_1" id="file1"
                                                        onchange="loadFile1(event)" style="display: none;">
                                                </p>
                                                <button type="button" class="upload-img-btn ">
                                                    <label for="file1" class="">
                                                        Upload Picture
                                                    </label>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- image 2 --}}
                                        <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                                            <div class="display-pictute text-center">
                                                <div class="mb-0 mx-auto position-relative">
                                                    @if ($user->image_2)
                                                        <img class="edit-img  mx-auto "
                                                            src='{{ URL::to("/storage/images/users/docs/md/$user->image_2") }}'
                                                            id="output2" />
                                                    @else
                                                        <img class="edit-img  mx-auto "
                                                            src="{{ URL::to('/assets/images/Asset2.png') }}"
                                                            id="output2" />
                                                    @endif
                                                    <div class="gradient"></div>
                                                    <div class="remove-picture remove-picture2 d-none">X</div>
                                                </div>
                                                <p class="mb-0">
                                                    <input type="file" accept="image/*" name="image_2" id="file2"
                                                        onchange="loadFile2(event)" style="display: none;">
                                                </p>
                                                <button type="button" class="upload-img-btn ">
                                                    <label for="file2" class="">
                                                        Upload Picture
                                                    </label>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- image 3 --}}
                                        <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                                            <div class="display-pictute text-center">
                                                <div class="mb-0 mx-auto position-relative">
                                                    @if ($user->image_3)
                                                        <img class="edit-img  mx-auto "
                                                            src='{{ URL::to("/storage/images/users/docs/md/$user->image_3") }}'
                                                            id="output3" />
                                                    @else
                                                        <img class="edit-img  mx-auto "
                                                            src="{{ URL::to('/assets/images/Asset2.png') }}"
                                                            id="output3" />
                                                    @endif
                                                    <div class="gradient"></div>
                                                    <div class="remove-picture remove-picture3 d-none">X</div>
                                                </div>
                                                <p class="mb-0">
                                                    <input type="file" accept="image/*" name="image_3" id="file3"
                                                        onchange="loadFile3(event)" style="display: none;">
                                                </p>
                                                <button type="button" class="upload-img-btn ">
                                                    <label for="file3" class="">
                                                        Upload Picture
                                                    </label>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- image 4 --}}
                                        <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                                            <div class="display-pictute text-center">
                                                <div class="mb-0 mx-auto position-relative">
                                                    @if ($user->image_4)
                                                        <img class="edit-img  mx-auto "
                                                            src='{{ URL::to("/storage/images/users/docs/md/$user->image_4") }}'
                                                            id="output4" />
                                                    @else
                                                        <img class="edit-img  mx-auto "
                                                            src="{{ URL::to('/assets/images/Asset2.png') }}"
                                                            id="output4" />
                                                    @endif
                                                    <div class="gradient"></div>
                                                    <div class="remove-picture remove-picture4 d-none">X</div>
                                                </div>
                                                <p class="mb-0">
                                                    <input type="file" accept="image/*" name="image_4" id="file4"
                                                        onchange="loadFile4(event)" style="display: none;">
                                                </p>
                                                <button type="button" class="upload-img-btn ">
                                                    <label for="file4" class="">
                                                        Upload Picture
                                                    </label>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- resume --}}
                                    <div class="mb-4 w-100 mt-4">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if ($user->resume)
                                                    <img class="edit-img mx-auto mw-100"
                                                        src='{{ URL::to("/storage/images/users/docs/md/$user->resume") }}'
                                                        id="output2" style="height: auto;" />
                                                @else
                                                    <img class="edit-img mx-auto mw-100"
                                                        src="{{ URL::to('/assets/images/Asset2.png') }}"
                                                        id="output2" style="height: auto;" />
                                                @endif
                                            </div>
                                            <div class="col-md-10">
                                                <label class="f-14 w-500 mb-2 text-gray">Upload Resume
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" name="resume" class="form-control upload-input " @if ($user->resume) @else required @endif>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- certificate --}}
                                    <div class="mb-4 w-100">
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if ($user->certificate)
                                                    <img class="edit-img mx-auto mw-100"
                                                        src='{{ URL::to("/storage/images/users/docs/md/$user->certificate") }}'
                                                        id="output2" style="height: auto;" />
                                                @else
                                                    <img class="edit-img mx-auto mw-100"
                                                        src="{{ URL::to('/assets/images/Asset2.png') }}"
                                                        id="output2" style="height: auto;" />
                                                @endif
                                            </div>
                                            <div class="col-md-10">
                                                <label class="f-14 w-500 mb-2 text-gray">Upload Certificate/license
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" name="certificate" class="form-control  upload-input" @if ($user->certificate) @else required @endif>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- expiry date --}}
                                    <div class="form-floating mb-4 w-100">
                                        <input type="date" class="form-control sign-input" id="floatingRole"
                                            name="expiry_date" value="{{ $user->expiry_date }}" required>
                                        <label for="floatingRole sign-label">Expiry Date
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex  mt-4">
                                        <button type="submit" class="main-btn-blank ms-3 text-white bg-primary"  >Upload
                                            Documents</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    {{-- password tab content --}}
                    <div id="password" class="tabcontent-side">

                        <h1 class="f-18 w-500">Profile</h1>
                        {{-- password form --}}
                        <form action="{{ URL::to('/settings/password') }}" method="post"
                            class="sign__frame-right--form">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="user_id">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating w-100 mb-5">
                                                <input type="password" name="old_password"
                                                    class="form-control sign-input id_password" placeholder="Password">
                                                <i class="bi bi-eye-fill togglePassword"></i>
                                                <label for="floatingPassword sign-label">Old Password</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-floating w-100 mb-5">
                                                <input type="password" name="password"
                                                    class="form-control sign-input id_password" placeholder="Password">
                                                <i class="bi bi-eye-fill togglePassword"></i>
                                                <label for="floatingPassword sign-label">New Password</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-floating w-100 mb-5">
                                                <input type="password" name="password_confirmation"
                                                    class="form-control sign-input id_password" placeholder="Password">
                                                <i class="bi bi-eye-fill togglePassword"></i>
                                                <label for="floatingPassword sign-label">Confirm Password</label>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12">
                                    {{-- <hr class="sign-line my-3"> --}}
                                    <div class="d-flex  mt-4">
                                        {{-- <button type="button" class="main-btn-blank text-dark border-dark  ">Cancel</button> --}}
                                        <button type="submit" class="main-btn-blank ms-3 text-white bg-primary">Update
                                            Password</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection

