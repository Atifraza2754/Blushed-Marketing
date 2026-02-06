@extends('admin.layouts.master', ['module' => 'agents'])

@section('title')
    Edit Agent Info
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
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ URL::to('/admin/agents') }}">Agents</a>
                        </li>
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
                            <h6 class="my-2"><strong>Edit Agent Info</strong></h6>
                        </div>

                        <div class="card-body">
                            <form action='{{ URL::to("/admin/agents/$agent->id") }}' method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-row mb-4">

                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $agent->name }}" placeholder="Full Name *" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $agent->email }}" placeholder="Email *" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                            value="{{ $agent->mobile_no }}" placeholder="Mobile No *" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <textarea type="text" class="form-control" id="address" name="address" placeholder="Address (optional)">{{ $agent->address }}</textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                            value="{{ $agent->date_of_birth }}" placeholder="Date of Birth">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <select class="form-control" id="gender" name="gender">
                                            <option selected disabled>Gender</option>
                                            <option value="male" {{ $agent->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $agent->gender == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="other" {{ $agent->gender == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled>Status</option>
                                            <option value="1" {{ $agent->status ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $agent->status ? '' : 'selected' }}>
                                                Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        @if ($agent->profile_image)
                                            <img src='{{ URL::to("/storage/images/users/sm/$agent->profile_image") }}'
                                                class="rounded mw-100" alt="profile image">
                                        @else
                                            <img src="{{ URL::to('/assets/img/placeholders/user.png') }}"
                                                class="rounded mw-100" alt="avatar">
                                        @endif
                                    </div>

                                    <div class="col-md-10 mt-5">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="profile_image">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
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
