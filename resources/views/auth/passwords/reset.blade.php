@extends('auth.master')

@section('title')
    Setup New Password
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="sign__frame-right">
        <div class="sign__frame-right--logo">
            <img src="{{ URL::to('/assets/images/logo-black.png') }}" alt="">
        </div>

        {{-- setup new password form --}}
        <form action="{{ URL::to('/reset-password') }}" method="post" class="sign__frame-right--form">
            @csrf

            <h3 class="f-22 w-700 ">
                <img src="{{ URL::to('/assets/images/Round-icon.png') }}" alt="">
            </h3>
            <h1 class="f-36 w-600 ">Update password</h1>
            <div class="d-flex align-items-center mb-4 ps-1">
                <p class="mb-0 pb-0 f-14 w-500 me-2">Type New Password</p>
            </div>

            {{-- include alerts --}}
            <div class="d-flex align-items-center mb-3 w-100">
                @include('common.alerts')
            </div>

            {{-- password --}}
            <div class="form-floating w-100 mb-5">
                <input type="password" name="password" class="form-control sign-input" placeholder="Password" required>
                <label for="floatingPassword sign-label">New Password *</label>
            </div>
            {{-- password_confirmation --}}
            <div class="form-floating w-100 mb-5">
                <input type="password" name="password_confirmation" class="form-control sign-input" placeholder="Password"
                    required>
                <label for="floatingPassword sign-label">Confirm Password *</label>
            </div>
            <div class="d-flex w-100 align-items-center justify-content-between">
                <div>
                    <a href="{{ URL::to('/login') }}" class="p-0 m-0 f-14 w-600 sign-link">Go Back</a>
                </div>
                <div>
                    <button class="sign-btn">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('customScripts')
    <script>
        // Login
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#id_password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
