@extends('layouts.master', ['module' => 'messages'])

@section('title')
    Messages
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">

        {{-- title section --}}
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <h1 class="f-32 w-600 text-bl">
                    Messages
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
                                <th width="5%">Sr.</th>
                                <th width="5%">Image</th>
                                <th width="20%">Name & Email</th>
                                <th width="40%">Message</th>
                                <th widht="10%">Date</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $msg)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="edit table-action cursor-pointer">
                                                <a href='{{ URL::to("/messages/$msg->user_id") }}' class="btn btn-sm btn-light">
                                                    Messages
                                                </a>
                                            </div>
                                        </div>
                                    </td>
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.pay-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search brands..."
                }
            });
        });
    </script>
@endsection
