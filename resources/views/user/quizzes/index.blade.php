@extends('user.layouts.master', ['module' => 'quizzes'])

@section('title')
    Quizzes
@endsection

@section('customStyles')
@endsection

@section('content')
    <div class="main-content">
        <div class="container">

            <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h1 class="f-32 w-600 text-black">
                        Quizzes
                    </h1>
                </div>
            </div>

            <div class="row">

                {{-- tabs --}}
                <div class="col-md-12">
                    <div class="tab-div">
                        <div class="tab">
                            <a href="{{ URL::to('/user/quizzes') }}">
                                <button class="{{ $slug == null ? 'active' : '' }}">All</button>
                            </a>
                            <a href="{{ URL::to('/user/quizzes/completed') }}">
                                <button class="{{ $slug == 'due' ? 'active' : '' }}">Completed</button>
                            </a>
                            <a href="{{ URL::to('/user/quizzes/resubmit') }}">
                                <button class="{{ $slug == 'resubmit' ? 'active' : '' }}">Resubmit</button>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- table --}}
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table dashboard-table display tabcontent-table quiz-table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">BRAND @ STORE</th>
                                    <th>STATUS</th>
                                    {{-- <th>EVENT DATE</th> --}}
                                    {{-- <th>D  UE DATE</th> --}}
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_quizzes as $uq)
                                     <tr class="">
                                        <td scope="row">
                                            <p class="mb-0 pb-0">{{ $loop->iteration }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ URL::to("/user/quiz/$uq->id") }}" class="no-decoration"
                                                style="color: inherit;">
                                                <div class="d-flex align-items-center brand-info">
                                                    <div class="ms-3">
                                                        <h3 class="mb-0 pb-0 f-16 w-600">{{ $uq->quiz ? $uq->quiz->title : '' }}</h3>
                                                        <p class="mb-0 pb-0 text-muted">
                                                            {{ $uq->quiz->description ?? 'detail not specified' }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 pb-0">{{ $uq->quiz ? $uq->quiz->brand->title : '' }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($uq->status)
                                                <div class="approved text-capitalize">{{ $uq->getStatus($uq->quiz_id) }}</div>
                                            @else
                                                <div class="pending text-capitalize">{{ $uq->geStatus($uq->quiz_id) }}</div>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 pb-0">{{ $uq->due_date }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 pb-0">{{ $uq->due_date }}</p>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="eye  table-action cursor-pointer">
                                                    <a href="{{ URL::to("/user/quiz/$uq->quiz_id") }}" class="no-decoration">
                                                        <svg width="18" height="18" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" />
                                                        </svg>
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
    </div>
@endsection

@section('customScripts')
    <script>
        $(document).ready(function() {
            $('.quiz-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search Quizzes..."
                }
            });
        });


    </script>
@endsection
