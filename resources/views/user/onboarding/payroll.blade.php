@php
    $layout = Auth::user()->role_id == 5 ? 'user.layouts.master' : 'layouts.master';
@endphp

@extends($layout, ['module' => 'onboarding'])
@section('title')

    Payroll Details - Onboarding
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
                                <button class="active">Payrolls</button>
                            </a>
                            @endif
                            @if(Auth::user()->is_ic)
                            <a href="{{ URL::to('/user/onboarding/ICTforms') }}">
                                <button class="">IC Aggrement</button>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Tab content -->
                    <div>
                        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
                            <div class="col-lg-10 mx-auto">
                                <p class="mt-3">Please choose your payment option</p>
                                <h1 class="f-32 w-600 text-primary">Payroll</h1>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-10 mx-auto">

                                <form action='{{ URL::to('/onboarding/payroll') }}' method="post" enctype="multipart/form-data">
                                    @csrf

                                    @if ($payroll)
                                        <div class="row mb-4">
                                            <div class="col-lg-10 mx-auto">

                                                {{-- include alerts --}}
                                                @include('common.alerts')

                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">1:</b>
                                                        Name (as shown on your income tax return)
                                                    </label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control input-blushed" placeholder="Enter Name"
                                                        value="{{ $payroll->name }}" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">2:</b>
                                                        Phone number *
                                                    </label>
                                                    <input type="text" name="phone_no" id="phone_no"
                                                        class="form-control input-blushed" placeholder="Enter Phone No"
                                                        value="{{ $payroll->phone_no }}" aria-describedby="helpId" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">3:</b>
                                                        Do you prefer direct deposit or a mailed check?
                                                    </label>
                                                    <div class="mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                value="direct-deposit" id="defaultCheck1"
                                                                name="payment_preference"
                                                                {{ $payroll->payment_preference == 'direct-deposit' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck1">
                                                                Direct Deposit
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                value="mailed-check" id="defaultCheck2"
                                                                name="payment_preference"
                                                                {{ $payroll->payment_preference == 'mailed-check' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck2">
                                                                Mailed check
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">4:</b>
                                                        Please put your current mailing address *
                                                    </label>
                                                    <input type="email" name="email_address" id="email_address"
                                                        class="form-control input-blushed" placeholder="Enter Name"
                                                        value="{{ $payroll->email_address }}" aria-describedby="helpId"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"> Exemption from
                                                        FATCA
                                                        reporting code
                                                        (if
                                                        any)
                                                    </label>
                                                    <input type="text" name="fatca_reporting_code"
                                                        id="fatca_reporting_code" class="form-control input-blushed"
                                                        placeholder="Enter exemption from FATCA"
                                                        value="{{ $payroll->fatca_reporting_code }}"
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label label-blushed">
                                                        <b>5</b>:Want direct deposit? Upload a voided
                                                        check or a screenshot of your routing and account numbers with your
                                                        name.
                                                        (mailed
                                                        check will be the default if nothing is uploaded or it can't be
                                                        verified)
                                                    </label>

                                                    @if ($payroll->voided_check)
                                                        <div class="payroll-img">
                                                            <img src='{{ URL::to("/storage/images/payrolls/lg/$payroll->voided_check") }}'
                                                                alt="" class="img-fluid">
                                                        </div>
                                                        <div class="mb-4 w-100 mt-4">
                                                            <label class="f-14 w-500 mb-2 text-gray">Upload Resume
                                                            </label>
                                                            <input type="file" name="voided_check"
                                                                class="form-control upload-input">
                                                        </div>
                                                    @else
                                                        <div class="mb-4 w-100 mt-4">
                                                            <label class="f-14 w-500 mb-2 text-gray">Upload Resume
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="file" name="voided_check"
                                                                class="form-control upload-input" required>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>6</b>:By
                                                        checking
                                                        this box, you
                                                        are
                                                        consenting to the payment method selected above. 100% of your pay
                                                        will be
                                                        delivered
                                                        to the checking account or mailing address you provided
                                                        above.</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="agreed" checked required>
                                                        <label class="form-check-label label-blushed" for="agreed">
                                                            Agree
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mb-4">
                                            <div class="col-lg-10 mx-auto">

                                                {{-- include alerts --}}
                                                @include('common.alerts')
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">1:</b>
                                                        Name (as shown on your income tax return)
                                                    </label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control input-blushed" placeholder="Enter Name"
                                                        value="" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">2:</b>
                                                        Phone number *
                                                    </label>
                                                    <input type="text" name="phone_no" id="phone_no"
                                                        class="form-control input-blushed" placeholder="Enter Phone No"
                                                        value="" aria-describedby="helpId" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">3:</b>
                                                        Do you prefer direct deposit or a mailed check?
                                                    </label>
                                                    <div class="mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                value="direct-deposit" id="defaultCheck1"
                                                                name="payment_preference">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck1">
                                                                Direct Deposit
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                value="mailed-check" id="defaultCheck2"
                                                                name="payment_preference">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck2">
                                                                Mailed check
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">4:</b>
                                                        Please put your current mailing address *
                                                    </label>
                                                    <input type="email" name="email_address" id="email_address"
                                                        class="form-control input-blushed"
                                                        placeholder="Enter Email Address" value=""
                                                        aria-describedby="helpId" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"> Exemption from
                                                        FATCA
                                                        reporting
                                                        code
                                                        (if
                                                        any)
                                                    </label>
                                                    <input type="text" name="fatca_reporting_code"
                                                        id="fatca_reporting_code" class="form-control input-blushed"
                                                        placeholder="Enter exemption from FATCA" value=""
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label label-blushed">
                                                        <b>5</b>:Want direct deposit? Upload a voided
                                                        check or a screenshot of your routing and account numbers with your
                                                        name.
                                                        (mailed
                                                        check will be the default if nothing is uploaded or it can't be
                                                        verified)
                                                    </label>

                                                    <div class="mb-4 w-100 mt-4">
                                                        <label class="f-14 w-500 mb-2 text-gray">Upload Resume
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="file" name="voided_check"
                                                            class="form-control upload-input" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>6</b>:By
                                                        checking
                                                        this box, you
                                                        are
                                                        consenting to the payment method selected above. 100% of your pay
                                                        will be
                                                        delivered
                                                        to the checking account or mailing address you provided
                                                        above.</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="defaultCheck10" required>
                                                        <label class="form-check-label label-blushed"
                                                            for="defaultCheck10">
                                                            Agree
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row mb-5">
                                        <div class="col-lg-10 mx-auto">
                                            <hr>
                                            <div class="d-flex align-items-center">
                                                {{-- <a href='{{ URL::to("/onboarding/w9from/$w9form->id") }}' class="main-btn-blank mt-3">Discard</a> --}}
                                                <button class="main-btn mt-3 w-auto">Save Changes</button>
                                            </div>
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
