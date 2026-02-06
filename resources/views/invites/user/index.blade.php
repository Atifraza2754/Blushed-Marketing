@extends('layouts.master', ['module' => 'user-invites'])

@section('title')
    User invites
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
                    User Invites
                </h1>

                <div class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                    <a href="{{ URL::to('/user/invites/create') }}"
                        class="main-btn-blank ms-sm-3 ms-0 text-white bg-primary">Invite New Users</a>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">

                {{-- tabs --}}
                <div class="tab-div">
                    <div class="tab">
                        <form action="{{URL::to('/admin/invites')}}" method="get">
                            <input type="hidden" name="tab" value="all">
                            <button type="submit" class="{{ $tab == 'all' ? 'selected-tab' : '' }}">All</button>
                        </form>
                        <form action="{{URL::to('/admin/invites')}}" method="get">
                            <input type="hidden" name="tab" value="joined">
                            <button class="{{ $tab == 'joined' ? 'selected-tab' : '' }}">Joined</button>
                        </form>
                        <form action="{{URL::to('/admin/invites')}}" method="get">
                            <input type="hidden" name="tab" value="pending">
                            <button class="{{ $tab == 'pending' ? 'selected-tab' : '' }}">Pending</button>
                        </form>
                    </div>
                </div>

                {{-- table --}}
                <div class="table-responsive">
                    <table class="table dashboard-table tabcontent-table pay-table">
                        <thead>
                            <tr>
                                <th width="5%">Sr.</th>
                                <th width="30%">Email</th>
                                <th width="10%">Role</th>
                                <th width="10%">Has Signup?</th>
                                <th width="10%">Invited On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invites as $invite)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="mb-0 pb-0">{{ $invite->email }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 pb-0">{{ $invite->role->role }}</p>
                                    </td>
                                    <td scope="row">
                                        @if ($invite->has_signup)
                                            <div class="approved">Yes</div>
                                        @else
                                            <div class="due">No</div>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="mb-0 pb-0">{{ $invite->created_at }}</p>
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
                    searchPlaceholder: "Search Invites..."
                }
            });
        });
    </script>
@endsection
