@extends('layouts.master', ['module' => 'shifts'])

@section('title')
   Import Shifts
@endsection

@section('customStyles')
@endsection
@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="col-md-8 mx-auto">

                {{-- include alerts --}}
                @include('common.alerts')

                <h1 class="f-32 w-600 ">Shifts / Schedule</h1>
                <div class="blushed-card mt-3 py-lg-4 px-lg-4">
                    <h1 class="f-24 w-600">Import shifts</h1>
                    <p class="f-18 w-500 " style="color: #84818A !important;">
                        Please attach the xlxs file to import shifts / schedules
                    </p>

                    <div class="card">
                        <div class="card-header mt-2 me-2 align-items-start">
                            <div>
                                <h5 class="f-22" style=" font-weight: 600;">Add members to this job</h5>
                                <p class="mb-0 pb-0 f-600 text-gray f-14">Enter email with hour rate job</p>
                            </div>
                        </div>
                        <div class="card-body pt-0 mt-3">
                            <form action="" class="sign__frame-right--form">
                                <div class="row w-100 align-items-center">
                                    <div class="col-lg-5 col-md-5 col-12">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="email" class="form-control sign-input " id="floatingInput">
                                            <label for="floatingInput" class="sign-label">Email address</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-10">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="email" class="form-control sign-input " id="floatingInput">
                                            <label for="floatingInput" class="sign-label">Flat rate</label>
                                        </div>
                                    </div>
                                    <div class="col-2 ">
                                        <div class="d-flex align-items-end  justify-content-md-start justify-content-center">
                                            <svg class="me-2 cursor-pointer add-role" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM17 13H13V17H11V13H7V11H11V7H13V11H17V13Z"
                                                    fill="#CD7FAF" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class=" appended-row w-100 ">

                                </div>
                                <hr class="sign-line">
                                <div class="col-lg-12">
                                    <div class="d-flex mt-4">
                                        <button class="sign-btn">Assign</button>
                                    </div>
                                </div>


                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
@endsection
