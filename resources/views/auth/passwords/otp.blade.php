@extends('auth.master')

@section('title')
    Verify OTP
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="sign__frame-right sign__frame-right2">
        <div class="sign__frame-right--logo ">
            <img src="{{ URL::to('/assets/images/logo-black.png') }}" alt="">
        </div>

        {{-- forget password form --}}
        <form action="{{ URL::to('/verify-otp') }}" method="post" class="sign__frame-right--form">
            @csrf

            <h1 class="f-36 w-600 ">Verify OTP</h1>
            <div class="d-flex align-items-center mb-4 ps-1">
                <p class="mb-0 pb-0 f-14 w-500 me-2">
                    Please enter OTP received at your email address
                </p>
            </div>

            {{-- include alerts --}}
            <div class="d-flex align-items-center mb-3 w-100">
                @include('common.alerts')
            </div>

            <div class="d-flex align-items-start">
                <svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M26.6667 5.83334H5.33335C3.86669 5.83334 2.68002 7.03334 2.68002 8.50001L2.66669 24.5C2.66669 25.9667 3.86669 27.1667 5.33335 27.1667H26.6667C28.1334 27.1667 29.3334 25.9667 29.3334 24.5V8.50001C29.3334 7.03334 28.1334 5.83334 26.6667 5.83334ZM26.6667 11.1667L16 17.8333L5.33335 11.1667V8.50001L16 15.1667L26.6667 8.50001V11.1667Z"
                        fill="#CD7FAF" />
                </svg>
                <div class="forget-text ms-3 mb-0">
                    <p class="mb-0 pb-0 pt-1">Enter OTP *</p>
                </div>
            </div>

            {{-- otp --}}
            <div class="form-floating w-100 mb-3">
                <input type="text" name="otp" class="form-control sign-input pt-1" placeholder="abc@example.com"
                    required>
            </div>

            {{-- <div class="mb-5">
                <a href="" class="p-0 m-0 f-14 w-600 sign-link">Resend code</a>
            </div> --}}
            <button type="submit" class="sign-btn w-100">Continue</button>
        </form>
    </div>
@endsection

@section('customScripts')
@endsection
