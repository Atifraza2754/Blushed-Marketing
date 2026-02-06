@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
    User Trainings - Learning Center
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
                            <h1 class="f-22 w-600 text-bl">Trainings</h1>

                            <div
                                class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                                <div class="dropdown ">
                                    <button class="  main-btn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#create-training">
                                        Add Training
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Tab links --}}
                        <div class="tab-div">
                            <div class="tab">
                                <a href="{{ URL::to('/learning-center/trainings') }}" class="tab-btn">Training
                                    List</a>
                                <a href="{{ URL::to('/learning-center/user-trainings') }}"
                                    class="tab-btn tab-btn-active">User Training
                                    Status</a>
                            </div>
                        </div>

                        {{-- user-tranings table --}}

                        <div class="table-responsive">
                            <button id="approveTraining" class="btn btn-warning btn-sm mt-2 float-end text-white
                            ">Approve Training</button>

                            <table class="table dashboard-table  dashboard-table-sm tabcontent-table learning-table">
                                <thead>
                                    <tr>
                                        <th width="5%"><input type="checkbox" id="selectAll"></th>
                                        <th width="5%">No</th>

                                        <th width="25%">User Info</th>
                                        <th width="30%">Training Info</th>
                                        <th>Status</th>
                                        <th with="15%">Due Date</th>
                                        {{-- <th with="10%">Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trainings as $training)
                                        @if($training->training != null)
                                            <tr class="">
                                                <td><input type="checkbox" class="row-checkbox" value="{{ $training->id }}"></td>

                                                <td scope="row">
                                                    <p class="mb-0 pb-0">{{ $loop->iteration }}</p>
                                                </td>
                                                <td>
                                                    <div class="dp-div">
                                                        @if ($training->user->profile_image)
                                                            <img src="{{ URL::to('/storage/images/users/sm/' . $training->user->profile_image) }}"
                                                                alt="user profile image" class="dp-img">
                                                        @else
                                                            <img src="{{ URL::to('/assets/images/placeholders/user.png') }}"
                                                                alt="user placeholder image" class="dp-img">
                                                        @endif
                                                        <h4 class="mb-0 pb-0 ms-2">{{ $training->user->name }}</h4>
                                                    </div>
                                                </td>
                                                <td>

                                                    <p class="mb-0 pb-0">{{ $training->training->title }}</p>
                                                    <small>{{ $training->training->brand->title }}</small>
                                                </td>
                                                <td>
                                                    @if ($training->status == 'pending')
                                                        <div class="rejected">Pending</div>
                                                    @else
                                                        <div class="approved">Completed</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <p class="mb-0 pb-0">{{ $training->due_date }}</p>
                                                    </div>
                                                </td>
                                                {{-- <td>
                                                    <div class="d-flex align-items-center">

                                                        <div class="eye table-action cursor-pointer">
                                                            <a href="{{ URL::to(" /learning-center/training/$training->id/view")
                                                                }}">
                                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td> --}}
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
    @include('learning-center.trainings.brands-modal')
@endsection

@section('customScripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.learning-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search User Trainings..."
                },
                columnDefs: [
                    {
                        orderable: false,
                        targets: 0
                    }
                ]
            });
        });
        $('#selectAll').on('click', function () {
            $('.row-checkbox').prop('checked', this.checked);
        });

        // Deselect 'Select All' if any box is unchecked
        $(document).on('change', '.row-checkbox', function () {
            $('#selectAll').prop('checked', $('.row-checkbox:checked').length === $('.row-checkbox').length);
        });

        // Delete selected rows
        $('#approveTraining').on('click', function () {
            let ids = $('.row-checkbox:checked').map(function () {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                alert('No rows selected');
                return;
            }

            trainingApprove(ids);
            // if (confirm('Are you sure you want to delete selected rows?')) {
            // }
        });

        function trainingApprove(id) {
            console.log(id);
            Swal.fire({
                title: 'Are you sure To Confirm This Training?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });

                    $.ajax({

                        type: "Post",
                        data: {
                            'ids': id
                        },
                        url: "/learning-center/training-approve-selected",

                        success: function (response) {
                            // console.log(response);
                            // return;
                            let status = response.status;

                            if (status == 200) {
                                Swal.fire({
                                    title: response.message,
                                    // text: "You won't be able to revert this!",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                console.log("Something went wrong!!!");
                            }
                        },
                    });
                }
            })
        }

    </script>
@endsection
