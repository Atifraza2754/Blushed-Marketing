@extends('admin.layouts.master', ['module' => 'settings'])

@section('title')
    Update Old Password
@endsection

@section('customStyles')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            {{-- breadcrumb --}}
            <div class="page-header mb-2">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('/admin/dashboard') }}">Dashboad</a>
                        </li>

                        {{-- include common links --}}
                        @include('admin.settings.common-links')

                    </ol>
                </nav>
            </div>

            {{-- form row --}}
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card border-0">

                        {{-- include alerts --}}
                        @include('admin.layouts.alerts')

                        <div class="card-header bg-white border-0">
                            <h6 class="my-2"><strong>Update Old Password</strong></h6>
                        </div>

                        <div class="card-body">
                            <form action='{{ URL::to('/admin/settings/password') }}' method="POST">
                                @csrf

                                <div class="form-row mb-4">

                                    <div class="col-md-12 mb-3">
                                        <input type="password" class="form-control" id="old_password" name="old_password"
                                            value="" placeholder="Old Password *" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="" placeholder="New Password *" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" value="" placeholder="Confirm Password *"
                                            required>
                                    </div>
                                </div>

                                <button type="submit" class="mb-3 btn btn-primary float-right">Update</button>
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
