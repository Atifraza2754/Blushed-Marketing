@extends('layouts.master', ['module' => 'messages'])

@section('title')
    Messages Listing
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="container">

        {{-- title section --}}
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <h1 class="f-32 w-600 text-bl">
                    {{ $user->name }} Messages
                </h1>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">

                {{-- table --}}
                <div class="table-responsive">
                    <table class="table dashboard-table tabcontent-table pay-table">
                        <thead>
                            <tr>
                                <th width="5%">Image</th>
                                <th width="20%">Name & Email</th>
                                <th width="50%">Message</th>
                                <th width="50%">Date and Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $msg)
                                <tr>
                                    <td>
                                        @if ($msg->user->profile_image)
                                            <img src='{{ URL::to('/storage/images/users/sm/' . $msg->user->profile_image) }}'
                                                alt="" class="dp-img-lg">
                                        @else
                                            <img src="{{ URL::to('/assets/images/Avatar.png') }}" alt=""
                                                class="dp-img-lg">
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $msg->user->name }}</h6>
                                        <p class="mb-0">{{ $msg->user->email }}</p>
                                    </td>
                                    <td>{{ $msg->message }}</td>
                                    <td>{{ $msg->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
@endsection
