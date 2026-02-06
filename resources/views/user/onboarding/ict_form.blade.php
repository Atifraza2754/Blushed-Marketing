@php
$layout = Auth::user()->role_id == 5 ? 'user.layouts.master' : 'layouts.master';
@endphp

@extends($layout, ['module' => 'onboarding'])
@section('title')

IC Aggrment Form
@endsection

@section('customStyles')
<link rel="stylesheet" href="{{ URL::to('/student-assets/css/style.css') }}">
@endsection

@section('content')
<div class="main-content">
    <div class="container">

        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class=" ">
                <h1 class="f-32 w-600 text-bl mb-3">
                    Onboarding
                </h1>
                <p class="f-14 w-500">Go to <a href="" class="text-primary"> www.irs.gov/FormW9</a> for
                    instructions and the latest information</p>
            </div>
        </div>

        <!-- tabs -->
        <div class="row">
            <div class="col-lg-12">

                {{-- tabs --}}
                <div class="tab-div">
                    <div class="tab">
                        @if(Auth::user()->is_w9)
                        <a href="{{ URL::to('/user/onboarding/w9form') }}">
                            <button class="">W-9 Form</button>
                        </a>
                        @endif
                        @if(Auth::user()->is_pr)
                        <a href="{{ URL::to('/user/onboarding/payroll') }}">
                            <button class="">Payrolls</button>
                        </a>
                        @endif
                        @if(Auth::user()->is_ic)
                        <a href="{{ URL::to('/user/onboarding/ICTforms') }}">
                            <button class="active">IC Aggrement</button>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Tab content -->
                <div>
                    <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
                        <div class="col-lg-10 mx-auto">
                            {{-- <p class="mt-3">Your taxpayer identification information will be included as an
                                    Blushed App W-9 series substitute form.
                                </p> --}}
                            <h1 class="f-32 w-600 text-primary">
                                IC Aggrement Form
                            </h1>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-10 mx-auto">

                            <form action="{{ URL::to('/onboarding/ic-aggrement') }}" method="POST">
                                @csrf

                                {{-- Alerts --}}
                                @include('common.alerts')

                                <div class="row mb-4">
                                    <div class="col-lg-10 mx-auto">

                                        {{-- Name --}}
                                        <div class="mb-3">
                                            <label class="form-label label-blushed">
                                                Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                name="name"
                                                class="form-control input-blushed"
                                                placeholder="Enter Name"
                                                value="{{ $ict_form->name ?? '' }}"
                                                required>
                                            <small class="text-danger d-none">Name is required.</small>
                                        </div>

                                        {{-- Email --}}
                                        <div class="mb-3">
                                            <label class="form-label label-blushed">
                                                Email Address <span class="text-danger">*</span>
                                            </label>
                                            <input type="email"
                                                name="email"
                                                class="form-control input-blushed"
                                                placeholder="Enter Email"
                                                value="{{ $ict_form->user->email ?? '' }}"
                                                required>
                                            <small class="text-muted">
                                                A copy will be emailed to you for your records.
                                            </small>
                                        </div>

                                        {{-- IC Contract --}}
                                        <div class="mb-4">
                                            <label class="form-label label-blushed">
                                                IC Contract
                                            </label>
                                            <div>
                                                <a href="{{ url('https://drive.google.com/file/d/1WbWT4HlWQwGpaG0q-IAot1MA6WDB3aIn/view') }}"
                                                    target="_blank"
                                                    class="fw-bold text-decoration-underline">
                                                    Click Here For IC Agreement
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Date --}}
                                        <div class="mb-3">
                                            <label class="form-label label-blushed">
                                                Date <span class="text-danger">*</span>
                                            </label>
                                            <input type="date"
                                                name="date"
                                                class="form-control input-blushed"
                                                value="{{ $ict_form->date ?? date('Y-m-d') }}"
                                                required>
                                        </div>

                                        {{-- Digital Signature --}}
                                        <div class="mb-4">
                                            <label class="form-label label-blushed">
                                                Digital Signature <span class="text-danger">*</span>
                                            </label>

                                            <div class="form-check">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="digital_signature"
                                                    value="1"
                                                    id="digitalSignature"
                                                    {{ isset($ict_form) ? 'checked' : '' }}
                                                    required>

                                                <label class="form-check-label label-blushed"
                                                    for="digitalSignature">
                                                    By clicking, you agree to the terms and conditions as outlined
                                                    in the Blushed Marketing LLC IC Agreement linked above.
                                                    Your submission will count as your digital signature.
                                                </label>
                                            </div>

                                            <small class="text-danger d-none">
                                                This field is required. Please check it.
                                            </small>
                                        </div>

                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="row mb-5">
                                    <div class="col-lg-10 mx-auto">
                                        <hr>
                                        <button type="submit" class="main-btn mt-3">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customScripts')
@endsection