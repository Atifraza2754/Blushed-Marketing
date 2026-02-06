@extends('user.layouts.master', ['module' => "learning-center"])

@section('title')
    Trainings
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="main-content">
        <div class="container">

            <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h1 class="f-32 w-600 text-black">
                        Learning Center
                    </h1>
                </div>
            </div>

            <div class="row">

                {{-- tabs --}}
                <div class="col-md-12">
                    <div class="tab-div">
                        <div class="tab">
                            <a href="{{ URL::to('/user/learning-center/trainings') }}">
                                <button class="{{ $slug == null ? 'active' : '' }}">All</button>
                            </a>
                            <a href="{{ URL::to('/user/learning-center/trainings/complete') }}">
                                <button class="{{ $slug == 'complete' ? 'active' : '' }}">Complete</button>
                            </a>
                            <a href="{{ URL::to('/user/learning-center/trainings/incomplete') }}">
                                <button class="{{ $slug == 'incomplete' ? 'active' : '' }}">Incomplete</button>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- table --}}
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table dashboard-table display tabcontent-table training-table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Brand @ Store</th>
                                    <th>STATUS</th>
                                    <th>DUE DATE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_trainings as $ut)
                                {{-- @dd($ut->training->title) --}}
                                    <tr class="">
                                        <td scope="row">
                                            <p class="mb-0 pb-0">{{ $loop->iteration }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ URL::to("/user/learning-center/training/$ut->id") }}" class="no-decoration" style="color: inherit;">
                                                <div class="d-flex align-items-center brand-info">
                                                    <img src="{{ URL::to('/user-assets/images/vp.svg') }}" alt="">
                                                    <div class="ms-3">
                                                        <h3 class="mb-0 pb-0 f-16 w-600">{{ $ut->training->title }}</h3>
                                                        <p class="mb-0 pb-0 text-muted">
                                                            {{ $ut->training->description ?? 'detail not specified' }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                        @if ($ut->status == 'pending')
                                        <div class="rejected">Pending</div>
                                    @else
                                        <div class="approved">Completed</div>
                                    @endif
                                </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 pb-0">{{ $ut->due_date }}</p>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="dropdown ms-1 ">
                                                <button class="  p-0 border-0 bg-transparent" type="button"
                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M15 10C16.375 10 17.5 8.875 17.5 7.5C17.5 6.125 16.375 5 15 5C13.625 5 12.5 6.125 12.5 7.5C12.5 8.875 13.625 10 15 10ZM15 12.5C13.625 12.5 12.5 13.625 12.5 15C12.5 16.375 13.625 17.5 15 17.5C16.375 17.5 17.5 16.375 17.5 15C17.5 13.625 16.375 12.5 15 12.5ZM15 20C13.625 20 12.5 21.125 12.5 22.5C12.5 23.875 13.625 25 15 25C16.375 25 17.5 23.875 17.5 22.5C17.5 21.125 16.375 20 15 20Z"
                                                            fill="#84818A" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li class="text-center">
                                                        <a class="dropdown-item"
                                                            href='{{ URL::to("/user/learning-center/training/$ut->training_id") }}'>
                                                            View Detail</a>
                                                    </li>
                                                </ul>
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
    </div>
@endsection

@section('customScripts')
    <script>
        $(document).ready(function() {
            $('.training-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search Training..."
                }
            });
        });
    </script>
@endsection
