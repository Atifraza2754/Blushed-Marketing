@php
    $layout = Auth::user()->role_id == 5 ? 'user.layouts.master' : 'layouts.master';
@endphp

@extends($layout, ['module' => 'onboarding'])
@section('title')
    W9 Form
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
                                <button class="active">W-9 Form</button>
                            </a>
                            @endif
                            @if(Auth::user()->is_pr)
                            <a href="{{ URL::to('/user/onboarding/payroll') }}">
                                <button class="">Payrolls</button>
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
                                <p class="mt-3">Your taxpayer identification information will be included as an
                                    Blushed App W-9 series substitute form.
                                </p>
                                <h1 class="f-32 w-600 text-primary">
                                    W-9 Form
                                </h1>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-10 mx-auto">

                                <form action='{{ URL::to('/onboarding/w9form') }}' method="post">
                                    @csrf

                                    @if ($w9form)
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
                                                        value="{{ $w9form->name }}" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">2:</b>
                                                        Business name/disregarded entity name, if different from above
                                                    </label>
                                                    <input type="text" name="business_name" id="business_name"
                                                        class="form-control input-blushed" placeholder="Enter Name"
                                                        value="{{ $w9form->business_name }}" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">3:</b>
                                                        Check appropriate box for federal tax classification of the person
                                                        whose
                                                        name is
                                                        entered on line 1. Check only one of the following seven boxes.
                                                    </label>
                                                    <div class=" mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="individual" id="defaultCheck1"
                                                                {{ $w9form->federal_tax_classification == 'individual' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck1">
                                                                Individual/sole proprietor or single-member LLC
                                                            </label>
                                                        </div>

                                                        <div class="form-check ">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="c-corporate" id="defaultCheck2"
                                                                {{ $w9form->federal_tax_classification == 'c-corporate' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck2">
                                                                C Corporation
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="s-corporate" id="defaultCheck3"
                                                                {{ $w9form->federal_tax_classification == 's-corporate' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck3">
                                                                S Corporation
                                                            </label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="partnership" id="defaultCheck4"
                                                                {{ $w9form->federal_tax_classification == 'partnership' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck4">
                                                                Partnership
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="trust" id="defaultCheck5"
                                                                {{ $w9form->federal_tax_classification == 'trust' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck5">
                                                                Trust/estate
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="llc" id="defaultCheck6"
                                                                {{ $w9form->federal_tax_classification == 'llc' ? 'checked' : '' }}>
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck6">
                                                                Limited liability company. Enter the tax classification (C=C
                                                                corporation,
                                                                S=S corporation, P=Partnership) _________________
                                                            </label>
                                                            <p class="form-label label-blushed mt-2"><b
                                                                    class="text-black">Note:</b> Check the
                                                                appropriate
                                                                box in
                                                                the line above for the tax classification of the
                                                                single-member
                                                                owner. Do not check LLC if the LLC is classified as a
                                                                single-member LLC that is disregarded from the owner unless
                                                                the
                                                                owner of the LLC is another LLC that is not disregarded from
                                                                the
                                                                owner for U.S. federal tax purposes. Otherwise, a
                                                                single-member
                                                                LLC that is disregarded from the owner should check the
                                                                appropriate box for the tax classification of its owner.
                                                            </p>
                                                            <!-- other instruction -->
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="other" id="defaultCheck7"
                                                                {{ $w9form->federal_tax_classification == 'other' ? 'checked' : '' }}>
                                                            <label class="form-label label-blushed" for="defaultCheck7">
                                                                Other (see instructions)
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">4:</b>
                                                        Exemptions (codes apply only to certain entities, not individuals;
                                                        see
                                                        instructions
                                                        on page 3):<br>
                                                        Exempt payee code (if any)
                                                    </label>
                                                    <input type="text" name="exempt_payee_code" id="exempt_payee_code"
                                                        class="form-control input-blushed" placeholder="Enter Name"
                                                        value="{{ $w9form->exempt_payee_code }}"
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"> Exemption from
                                                        FATCA
                                                        reporting code (if
                                                        any)
                                                    </label>
                                                    <input type="text" name="fatca_reporting_code"
                                                        id="fatca_reporting_code" class="form-control input-blushed"
                                                        placeholder="Enter exemption from FATCA"
                                                        value="{{ $w9form->fatca_reporting_code }}"
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b>5</b>: Address (number,
                                                        street, and
                                                        apt. or suite no.) *
                                                    </label>
                                                    <input type="text" name="address" id="address"
                                                        class="form-control input-blushed" placeholder="Enter address"
                                                        value="{{ $w9form->address }}" aria-describedby="helpId"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>6</b>: City,
                                                        state, and
                                                        ZIP code
                                                        *
                                                    </label>
                                                    <input type="text" name="city_state_zipcode"
                                                        id="city_state_zipcode" class="form-control input-blushed"
                                                        placeholder="Enter address"
                                                        value="{{ $w9form->city_state_zipcode }}"
                                                        aria-describedby="helpId" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>7</b>: List
                                                        account
                                                        number(s)
                                                        here
                                                    </label>
                                                    <input type="text" name="account_number" id="account_number"
                                                        class="form-control input-blushed" placeholder="00000000000"
                                                        value="{{ $w9form->account_number }}" aria-describedby="helpId">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>8</b>:
                                                        Requester’s name
                                                        and
                                                        address</label>
                                                    <input type="text" name="requester_name" id="requester_name"
                                                        class="form-control input-blushed"
                                                        placeholder="Enter requester name and address"
                                                        value="{{ $w9form->requester_name }}" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>9</b>:
                                                        Social
                                                        security
                                                        number</label>
                                                    <input type="text" name="social_security_number"
                                                        id="social_security_number" class="form-control input-blushed"
                                                        placeholder="000-00-0000"
                                                        value="{{ $w9form->social_security_number }}"
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for=""
                                                        class="form-label label-blushed"><b>10</b>:Employer
                                                        identification
                                                        number</label>
                                                    <input type="text" name="employer_identification_number"
                                                        id="employer_identification_number"
                                                        class="form-control input-blushed" placeholder="000-00-0000"
                                                        value="{{ $w9form->employer_identification_number }}"
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for=""
                                                        class="form-label label-blushed"><b>11</b>:Date</label>
                                                    <input type="date" name="date" id="date"
                                                        class="form-control input-blushed" placeholder="dd/mm/yyyy"
                                                        value="{{ $w9form->date }}" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for=""
                                                        class="form-label label-blushed"><b>12</b>:Digital
                                                        Signature
                                                        *</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="agreed" checked required>
                                                        <label class="form-check-label label-blushed" for="agreed">
                                                            Agree to the terms and conditions as outlined in the Blushed
                                                            Marketing LLC IC
                                                            Agreement linked to above. Your submission will count as your
                                                            digital signature.
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
                                                        Business name/disregarded entity name, if different from above
                                                    </label>
                                                    <input type="text" name="business_name" id="business_name"
                                                        class="form-control input-blushed" placeholder="Enter Name"
                                                        value="" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">3:</b>
                                                        Check appropriate box for federal tax classification of the person
                                                        whose
                                                        name is
                                                        entered on line 1. Check only one of the following seven boxes.
                                                    </label>
                                                    <div class=" mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="individual" id="defaultCheck1">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck1">
                                                                Individual/sole proprietor or single-member LLC
                                                            </label>
                                                        </div>

                                                        <div class="form-check ">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="c-corporate" id="defaultCheck2">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck2">
                                                                C Corporation
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="s-corporate" id="defaultCheck3">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck3">
                                                                S Corporation
                                                            </label>
                                                        </div>
                                                        <div class="form-check ">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="partnership" id="defaultCheck4">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck4">
                                                                Partnership
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="trust" id="defaultCheck5">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck5">
                                                                Trust/estate
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="llc" id="defaultCheck6">
                                                            <label class="form-check-label label-blushed"
                                                                for="defaultCheck6">
                                                                Limited liability company. Enter the tax classification (C=C
                                                                corporation,
                                                                S=S corporation, P=Partnership) _________________
                                                            </label>
                                                            <p class="form-label label-blushed mt-2"><b
                                                                    class="text-black">Note:</b> Check the
                                                                appropriate
                                                                box in
                                                                the line above for the tax classification of the
                                                                single-member
                                                                owner. Do not check LLC if the LLC is classified as a
                                                                single-member LLC that is disregarded from the owner unless
                                                                the
                                                                owner of the LLC is another LLC that is not disregarded from
                                                                the
                                                                owner for U.S. federal tax purposes. Otherwise, a
                                                                single-member
                                                                LLC that is disregarded from the owner should check the
                                                                appropriate box for the tax classification of its owner.
                                                            </p>
                                                            <!-- other instruction -->
                                                            <input class="form-check-input"
                                                                name="federal_tax_classification" type="checkbox"
                                                                value="other" id="defaultCheck7">
                                                            <label class="form-label label-blushed" for="defaultCheck7">
                                                                Other (see instructions)
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b class="text-black">4:</b>
                                                        Exemptions (codes apply only to certain entities, not individuals;
                                                        see
                                                        instructions
                                                        on page 3):<br>
                                                        Exempt payee code (if any)
                                                    </label>
                                                    <input type="text" name="exempt_payee_code" id="exempt_payee_code"
                                                        class="form-control input-blushed" placeholder="Enter Name"
                                                        value=""
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"> Exemption from
                                                        FATCA
                                                        reporting code (if
                                                        any)
                                                    </label>
                                                    <input type="text" name="fatca_reporting_code"
                                                        id="fatca_reporting_code" class="form-control input-blushed"
                                                        placeholder="Enter exemption from FATCA"
                                                        value=""
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed">
                                                        <b>5</b>: Address (number,
                                                        street, and
                                                        apt. or suite no.) *
                                                    </label>
                                                    <input type="text" name="address" id="address"
                                                        class="form-control input-blushed" placeholder="Enter address"
                                                        value="" aria-describedby="helpId"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>6</b>: City,
                                                        state, and
                                                        ZIP code
                                                        *
                                                    </label>
                                                    <input type="text" name="city_state_zipcode"
                                                        id="city_state_zipcode" class="form-control input-blushed"
                                                        placeholder="Enter address"
                                                        value=""
                                                        aria-describedby="helpId" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>7</b>: List
                                                        account
                                                        number(s)
                                                        here
                                                    </label>
                                                    <input type="text" name="account_number" id="account_number"
                                                        class="form-control input-blushed" placeholder="00000000000"
                                                        value="" aria-describedby="helpId">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>8</b>:
                                                        Requester’s name
                                                        and
                                                        address</label>
                                                    <input type="text" name="requester_name" id="requester_name"
                                                        class="form-control input-blushed"
                                                        placeholder="Enter requester name and address"
                                                        value="" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label label-blushed"><b>9</b>:
                                                        Social
                                                        security
                                                        number</label>
                                                    <input type="text" name="social_security_number"
                                                        id="social_security_number" class="form-control input-blushed"
                                                        placeholder="000-00-0000"
                                                        value=""
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for=""
                                                        class="form-label label-blushed"><b>10</b>:Employer
                                                        identification
                                                        number</label>
                                                    <input type="text" name="employer_identification_number"
                                                        id="employer_identification_number"
                                                        class="form-control input-blushed" placeholder="000-00-0000"
                                                        value=""
                                                        aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for=""
                                                        class="form-label label-blushed"><b>11</b>:Date</label>
                                                    <input type="date" name="date" id="date"
                                                        class="form-control input-blushed" placeholder="dd/mm/yyyy"
                                                        value="" aria-describedby="helpId">
                                                </div>
                                                <div class="mb-3">
                                                    <label for=""
                                                        class="form-label label-blushed"><b>12</b>:Digital
                                                        Signature
                                                        *</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="defaultCheck1" required>
                                                        <label class="form-check-label label-blushed" for="defaultCheck1">
                                                            Agree to the terms and conditions as outlined in the Blushed
                                                            Marketing LLC IC
                                                            Agreement linked to above. Your submission will count as your
                                                            digital signature.
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
