@extends('auth.master')

@section('title')
    Register
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="sign__frame-right sign-up-step-1">
        <div class="sign__frame-right--logo">
            <img src="{{ URL::to('/assets/images/logo-black.png') }}" alt="">
        </div>

        {{-- signup form --}}
        <form action="{{ URL::to('/register/step-1') }}" method="post" class="sign__frame-right--form">
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

            {{-- name --}}
            <div class="d-flex flex-md-row flex-column w-100">
                <div class="form-floating mb-4 w-48 me-md-2">
                    <input type="text" class="form-control sign-input" id="floatingInput" name="name"
                        placeholder="john" required>
                    <label for="floatingInput" class="sign-label">First Name *</label>
                </div>
            </div>
            <div class="d-flex flex-md-row flex-column w-100">
                <div class="form-floating mb-4 w-48 me-md-2">
                    <input type="text" class="form-control sign-input" id="floatingInput" name="last_name"
                        placeholder="john" required>
                    <label for="floatingInput" class="sign-label">Last Name *</label>
                </div>
            </div>
            {{-- email --}}
            @if (isset($invite))
                <div class="form-floating mb-4 w-100">
                    <input type="email" class="form-control sign-input" id="floatingInput" name="email"
                        placeholder="test@test.com" value="{{ $invite->email }}" readonly>
                    <label for="floatingInput" class="sign-label">Email address *</label>
                </div>

                {{-- is_invited_user --}}
                <input type="hidden" name="is_invited_user" value="1">
            @else
                <div class="form-floating mb-4 w-100">
                    <input type="email" class="form-control sign-input" id="floatingInput" name="email"
                        placeholder="test@test.com" required>
                    <label for="floatingInput" class="sign-label">Email address *</label>
                </div>
            @endif

            {{-- password --}}
            <div class="form-floating w-100 mb-4">
                <input type="password" class="form-control sign-input" id="id_password" name="password" min="8"
                    placeholder="Password" required>
                <i class="far fa-eye" id="togglePassword"></i>
                <label for="floatingPassword sign-label">Password</label>
            </div>
            <div class="w-100">
                {{-- checkbox --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked required>
                    <label class="form-check-label sign-check-label" for="flexCheckChecked">
                        By clicking Create account, I agree that I have read and accepted the
                        <a href="{{ URL::to('/terms-and-conditions') }}">Terms of Use</a> and
                        <a href="{{ URL::to('/privacy-policy') }}">Privacy Policy</a>.
                    </label>
                </div>
                {{-- button --}}
                <div class="w-100">
                    <button type="submit" class="sign-btn w-100 sign-btn-next">Next</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('customScripts')
    {{-- password toggle --}}
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#id_password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
