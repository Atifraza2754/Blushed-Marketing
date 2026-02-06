@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
    User Quizzes - Learning Center
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .tab-btn {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 7px 16px;
            transition: 0.3s;
            border-bottom: 2px solid transparent;
            color: #2E2C34;
            text-align: center;
            font-family: Manrope;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 18px;
        }

        .tab-btn-active {
            border-bottom: 2px solid #CD7FAF;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

            <div class="col-lg-12">
                <h1 class="f-32 mb-0 w-600">Learning Center</h1>
                <p class="f-14 text-gray w-500 mt-1">Update and manage your account</p>
            </div>

            {{-- include menu --}}
            <div class="col-lg-3">
                @include('learning-center.menu')
            </div>

            {{-- main content --}}
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="d-flex justify-content-between align-items-center flex-md-row flex-column mb-3">
                            <h1 class="f-22 w-600 text-bl">User Quizzes</h1>

                            <div
                                class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                                <div class="dropdown ">
                                    <button class="  main-btn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#create-quiz">
                                        Add Quiz
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Tab links --}}
                        <div class="tab-div">
                            <div class="tab">
                                <a href="{{ URL::to('/learning-center/quizzes') }}" class="tab-btn">Quizzes
                                    List</a>
                                <a href="{{ URL::to('/learning-center/user-quizzes') }}" class="tab-btn tab-btn-active">User
                                    Submitted Quizzes</a>
                            </div>
                        </div>

                        {{-- user-tranings table --}}
                        <div class="table-responsive">
                            <table class="table dashboard-table dashboard-table-sm tabcontent-table learning-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">User Info</th>
                                        <th width="25%">Quiz Info</th>
                                        <th>Status</th>
                                        <th>Shifted (DATE/TIME)</th>
                                        <th>Sumbit (DATE/TIME)</th>
                                        <th with="15%">Quiz Scores</th>
                                        <th with="10%">View Quiz</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quizzes as $quiz)
                                    @if($quiz->quiz != null )
                                        <tr class="">
                                            <td scope="row">
                                                <p class="mb-0 pb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <div class="dp-div">
                                                    @if ($quiz->user->profile_image)
                                                        <img src="{{ URL::to('/storage/images/users/sm/' . $quiz->user->profile_image) }}"
                                                            alt="user profile image" class="dp-img">
                                                    @else
                                                        <img src="{{ URL::to('/assets/images/placeholders/user.png') }}"
                                                            alt="user placeholder image" class="dp-img">
                                                    @endif
                                                    <h4 class="mb-0 pb-0 ms-2">{{ $quiz->user->name }}</h4>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 pb-0">{{ $quiz->title }}</p>
                                                <small>{{ $quiz->quiz->brand ? $quiz->quiz->brand->title : '' }}</small>
                                            </td>
                                            <td>
                                                @if ($quiz->status == 'submitted')
                                                    <div class="approved">Submitted</div>
                                                @elseif($quiz->status == 're-attempt')
                                                    <div class="re-attempt">Submitted</div>
                                                @else
                                                    <div class="rejected">Pending</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 pb-0">{{ $quiz->created_at->toDateString() }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 pb-0">{{ $quiz->created_at->toDateString() }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 pb-0">{{ $quiz->right_answers }} /
                                                        {{ $quiz->total_questions }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center ">
                                                    {{-- <div class="edit table-action cursor-pointer">
                                                        <a href="recap-edit.html">
                                                            <svg width="18" height="18" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M3 17.2501V21.0001H6.75L17.81 9.94006L14.06 6.19006L3 17.2501ZM20.71 7.04006C21.1 6.65006 21.1 6.02006 20.71 5.63006L18.37 3.29006C17.98 2.90006 17.35 2.90006 16.96 3.29006L15.13 5.12006L18.88 8.87006L20.71 7.04006Z" />
                                                            </svg>
                                                        </a>
                                                    </div> --}}
                                                    <div class="eye mx-3 table-action cursor-pointer">
                                                        <a href="{{ URL::to('/learning-center/user-quiz/?quiz_id='.$quiz->quiz_id.'&user_id='.$quiz->user_id) }}" class="no-decoration">
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
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- include brand modal --}}
    @include('learning-center.quizzes.brands-modal')
@endsection

@section('customScripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.learning-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search User Quizzes..."
                }
            });
        });
    </script>
@endsection
