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

                <h1 class="f-32 mb-0 w-600 "> Site Settings</h1>
                <p class="f-14 text-gray w-500 mt-1">Update and manage site settings</p>

            </div>

            <div class="col-lg-8">

                {{-- include alerts --}}
                @include('common.alerts')

                <div id="profile" class="">
                    <h1 class="f-18 w-500">Set Default Rate</h1>

                    {{-- profile form --}}
                    <form action="{{ URL::to('/site-setting-update') }}" method="post" enctype="multipart/form-data"
                        class="sign__frame-right--form">
                        @csrf

                        <div class="row">
                            <div class="col-lg-8 order-lg-1 order-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-4 w-100">
                                            <input type="text" name="flat_rate" value="{{ $flatRate ?? 0}}"
                                                class="form-control sign-input" id="floatingInput" placeholder="" required>
                                            <label for="floatingInput sign-label">Default Rate</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 order-3">
                                        {{--
                                        <hr class="sign-line my-3"> --}}
                                        <div class="d-flex  mt-4">
                                            {{-- <button type="button"
                                                class="main-btn-blank text-dark border-dark  ">Cancel</button> --}}
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

@endsection
