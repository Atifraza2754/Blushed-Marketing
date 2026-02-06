@extends('layouts.master', ['module' => 'settings'])

@section('title')
    Settings
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="col-lg-3">

                <h1 class="f-32 mb-0 w-600 ">Settings</h1>
                <p class="f-14 text-gray w-500 mt-1">Update and manage your account</p>

                {{-- settings tabs --}}
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

                <div id="profile" class="tabcontent-side">
                    <h1 class="f-18 w-500">Update Profile Information</h1>

                    {{-- profile form --}}
                    <form action="{{ URL::to('/settings/profile') }}" method="post" enctype="multipart/form-data"
                        class="sign__frame-right--form">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="user_id">

                        <div class="row">
                            <div class="col-lg-8 order-lg-1 order-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="form-control sign-input" id="floatingInput" placeholder="" required>
                                            <label for="floatingInput sign-label">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="email" name="email" value="{{ $user->email }}"
                                                class="form-control sign-input" id="floatingInput" readonly>
                                            <label for="floatingInput sign-label">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class=" mb-4 w-100 mt-2">
                                            <!-- <label for="phone sign-label">Your Role</label><br> -->
                                            <input id="mobile_no" name="mobile_no" value="{{ $user->mobile_no }}"
                                                type="tel" class=" sign-input w-100" required>
                                            <p class="f-12 text-gray w-400 mb-0 pb-0 mt-1">Standard call,
                                                messaging or data rates may apply.</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="text" class="form-control sign-input" id="floatingRole"
                                                placeholder="" value="{{ $user->role->role }}" readonly>
                                            <label for="floatingRole sign-label">Your Role</label>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="text" name="state" value="{{ $user->state }}"
                                                class="form-control sign-input" id="floatingInput" placeholder="">
                                            <label for="floatingInput sign-label">State</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="text" name="city" value="{{ $user->city }}"
                                                class="form-control sign-input" id="floatingInput" placeholder="">
                                            <label for="floatingInput sign-label">City</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="text" name="zipcode" value="{{ $user->zipcode }}"
                                                class="form-control sign-input" id="floatingInput" placeholder="">
                                            <label for="floatingInput sign-label">Postal Code</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="text" name="address" value="{{ $user->address }}"
                                                class="form-control sign-input" id="floatingInput" placeholder="">
                                            <label for="floatingInput sign-label">Complete Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- profile image --}}
                            <div class="col-lg-4 order-lg-2 order-1 mb-4">
                                <div class="display-pictute text-center">
                                    <div class="mb-0 mx-auto position-relative">
                                        @if ($user->profile_image)
                                            <img class="edit-img2  mx-auto rounded rounded-circle mw-100"
                                                src='{{ URL::to("/storage/images/users/sm/$user->profile_image") }}'
                                                id="output" />
                                        @else
                                            <img class="edit-img2  mx-auto "
                                                src="{{ URL::to('/assets/images/placeholders/user.png') }}"
                                                id="output" />
                                        @endif
                                        <div class="gradient"></div>
                                    </div>
                                    <p class="mb-0">
                                        <input type="file" accept="image/*" name="profile_image" id="file"
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
                                <div class="d-flex  mt-4">
                                    {{-- <button type="button" class="main-btn-blank text-dark border-dark  ">Cancel</button> --}}
                                    <button type="submit" class="main-btn-blank ms-3 text-white bg-primary">Save
                                        Changes</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div id="password" class="tabcontent-side">
                    <h1 class="f-18 w-500">Update Old Password</h1>

                    {{-- password form --}}
                    <form action="{{ URL::to('/settings/password') }}" method="post" class="sign__frame-right--form">
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
                                    <button type="submit" class="main-btn-blank ms-3 text-white bg-primary">Save
                                        Changes</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
@endsection


@section('customScripts')
    <script>
        function settings(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent-side");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tab-li");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active-side2", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active-side2";
        }
        document.getElementById("defaultOpen-side").click();
    </script>

    <script src="assets/Js/intlTelInput.js"></script>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            event.stopPropagation();
        };
    </script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript: "assets/Js/utils.js",
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.togglePassword').click(function(e) {
                const $password = $(this).siblings('.id_password');
                const type = $password.attr('type') === 'password' ? 'text' : 'password';
                $password.attr('type', type);
                $(this).toggleClass('bi-eye-slash-fill');
            });
        });
    </script>
@endsection
