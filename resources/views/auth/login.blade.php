@extends('auth.master')

@section('title')
    Login
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="sign__frame-right">
        <div class="sign__frame-right--logo">
            <img src="{{ URL::to('/assets/images/logo-black.png') }}" alt="">
        </div>

        <form class="sign__frame-right--form" action="{{ URL::to('/login') }}" method="POST">
            @csrf

            <h1 class="f-36 w-600">Sign in</h1>
            <div class="d-flex align-items-center mb-4">
                <p class="mb-0 pb-0 f-14 w-500 me-2">New user?</p>
                <a href="{{ URL::to('/register/step-1') }}" class="p-0 m-0 f-14 w-600 sign-link">Create an account</a>
            </div>

            {{-- include alerts --}}
            <div class="d-flex align-items-center mb-3 w-100">
                @include('common.alerts')
            </div>

            {{-- role --}}
            {{-- <div class="form-floating w-100 mb-4">
                <select class="form-select w-100 sign-input px-2 " id="floatingSelect" name="role_id"
                    aria-label="Floating label select example" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                    @endforeach
                </select>
                <label for="floatingSelect sign-label">Select Role</label>
            </div> --}}
            @php
                $role_id = 5;
                $currentUrl = request()->segment(1);
                if ($currentUrl == 'admin-login') {
                    $role_id = 1;

                }
             @endphp
<input type="hidden" value="{{ $role_id ?? 5 }}" name="role_id">
{{-- email --}}
            <div class="form-floating mb-4 w-100">
                <input type="email" class="form-control sign-input" id="floatingInput" name="email"
                    placeholder="name@example.com" required>
                <label for="floatingInput sign-label">Email address</label>
            </div>
            {{-- password --}}
            <div class="form-floating w-100 mb-5">
                <input type="password" class="form-control sign-input" id="id_password" name="password"
                    placeholder="Password" required>
                <i class="far fa-eye" id="togglePassword"></i>
                <label for="floatingPassword sign-label">Password</label>
            </div>

            <div class="d-flex w-100 align-items-center justify-content-between">
                <div>
                    <a href="{{ URL::to('/forget-password') }}" class="p-0 m-0 f-14 w-600 sign-link">Forgot password?</a>
                </div>
                <div>
                    <button class="sign-btn">Sign In</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('customScripts')
@endsection
