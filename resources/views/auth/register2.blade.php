@extends('auth.master')

@section('title')
    Register
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="sign__frame-right">
        <div class="sign__frame-right--logo">
            <img src="{{ URL::to('/assets/images/logo-black.png') }}" alt="">
        </div>

        {{-- signup form --}}
        <form action="{{ URL::to('/register/step-2') }}" method="post" enctype="multipart/form-data"
            class="sign__frame-right--form">
            @csrf

            <h3 class="f-22 w-700 ">Blushed</h3>
            <h1 class="f-36 w-600 ">Create an account</h1>
            <div class="d-flex align-items-center mb-4 ps-1">
                <p class="mb-0 pb-0 f-14 w-500 me-2">
                    Already have an account?
                </p>
                <a href="{{ URL::to('/login') }}" class="p-0 m-0 f-14 w-600 sign-link">Sign in </a>
            </div>

            {{-- include alerts --}}
            <div class="d-flex align-items-center mb-3 w-100">
                @include('common.alerts')
            </div>

            {{-- profile_image --}}
            <div class="d-flex flex-column justify-content-center align-items-center w-100 mb-3">
                <div class="display-pictute text-center">
                    <div class="mb-0 mx-auto position-relative"><img class="edit-img  mx-auto "
                            src="{{ URL::to('/assets/images/placeholders/user.png') }}" id="output" />
                        <div class="gradient"></div>
                        <div class="remove-picture d-none">X</div>
                    </div>
                    <p class="mb-0">
                        <input type="file" accept="image/*" name="profile_image" id="file"
                            onchange="loadFile(event)" style="display: none;">
                    </p>
                    <button type="button" class="upload-img-btn ">
                        <label for="file" class="">
                            Upload Picture
                        </label>
                    </button>
                </div>
            </div>
            {{-- mobile_no --}}
            <div class="form-floating mb-4 w-100">
                <input type="text" class="form-control sign-input" id="floatingRole" name="mobile_no"
                    placeholder="+123 2121 313">
                <label for="floatingRole sign-label">Mobile No <small>(optional)</small></label>
            </div>
            {{-- role_id --}}
            {{-- <div class="form-floating mb-4 w-100">
                <input type="text" class="form-control sign-input" id="floatingRole" name="role_id"
                    placeholder="admin">
                <label for="floatingRole sign-label">Your Role</label>
            </div> --}}
            {{-- role_id --}}
            <div class="form-floating mb-4 w-100">
                <select type="text" class="form-control sign-input" id="floatingRole" name="role_id">
                    @if ($invite)
                        <option value="{{ $invite->role->id }}">{{ $invite->role->role }}</option>
                    @else
                        @foreach ($roles as $role)
                            @if ($role->id != 1)
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                <label for="floatingRole sign-label">Role</label>
            </div>
            {{-- address --}}
            <div class="form-floating mb-4 w-100">
                <input type="text" class="form-control sign-input" id="floatingRole" name="address"
                    placeholder="110 cox creek parkway south Florence USA">
                <label for="floatingRole sign-label">Address</label>
            </div>

            <div class=" w-100 ">
                <div class="w-100">
                    <button class="sign-btn w-100">Sign Up</button>
                </div>
                {{-- <div class=" mt-3 text-center">
                    <a href="" class="sign-link w-500">Skip Setup</a>
                </div> --}}
            </div>
        </form>

    </div>
@endsection

@section('customScripts')
    {{-- password toggle  --> --}}
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#id_password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
    {{-- image upload --> --}}
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            $(".remove-picture").removeClass("d-none")
            event.stopPropagation();
        };

        $(".remove-picture").click(function() {
            $("#output").attr('src', 'assets/images/Asset 2.png')
            $(this).addClass("d-none")
        })
    </script>
    {{-- Country code --}}
    <script src="{{ URL::to('/assets/Js/intlTelInput.js') }}"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript: "assets/Js/utils.js",
        });
    </script>
@endsection
