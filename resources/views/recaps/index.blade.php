@php
    $layout = Auth::user()->role_id == 5 ? 'user.layouts.master' : 'layouts.master';
@endphp

@extends($layout, ['module' => 'recaps'])

@section('title')
    Recaps
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="main-content">
        <div class="container">

            {{-- btns row --}}
            <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
                <div class="d-flex justify-content-between align-items-center ">
                    <h1 class="f-32 w-600 text-bl">
                        Recaps
                    </h1>

                    <div class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">

                        <button id="approveTraining" class="btn btn-warning btn-sm  float-end text-white
                                    ">Approve Recap</button>

                        <div class="dropdown ">
                            <button class=" dropdown-toggle align-dropdown" type="button">
                                <svg width="25" height="25" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.5 10.8333H4.16667V9.16668H2.5V10.8333ZM2.5 14.1667H4.16667V12.5H2.5V14.1667ZM2.5 7.50001H4.16667V5.83334H2.5V7.50001ZM5.83333 10.8333H17.5V9.16668H5.83333V10.8333ZM5.83333 14.1667H17.5V12.5H5.83333V14.1667ZM5.83333 5.83334V7.50001H17.5V5.83334H5.83333Z"
                                        fill="#84818A" />
                                </svg>
                            </button>
                        </div>

                        <button class="refresh-btn" type="button">
                            <svg width="22" height="22" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.7085 5.29168C13.5001 4.08334 11.8418 3.33334 10.0001 3.33334C6.3168 3.33334 3.3418 6.31668 3.3418 10C3.3418 13.6833 6.3168 16.6667 10.0001 16.6667C13.1085 16.6667 15.7001 14.5417 16.4418 11.6667H14.7085C14.0251 13.6083 12.1751 15 10.0001 15C7.2418 15 5.00013 12.7583 5.00013 10C5.00013 7.24168 7.2418 5.00001 10.0001 5.00001C11.3835 5.00001 12.6168 5.57501 13.5168 6.48334L10.8335 9.16668H16.6668V3.33334L14.7085 5.29168Z"
                                    fill="#CD7FAF" />
                            </svg>
                        </button>

                        <div class="dropdown ">
                            <button class="  download-dropdown" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.8332 7.5H12.4998V2.5H7.49984V7.5H4.1665L9.99984 13.3333L15.8332 7.5ZM4.1665 15V16.6667H15.8332V15H4.1665Z"
                                        fill="white" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                <li class="text-center"><button id="download-btn" class="dropdown-item">
                                        Download</button>
                                </li>
                                <li class="text-center"><button class="dropdown-item" id="send-mail" type="button"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Send Email</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                {{-- tabs/filters --}}
                @if (Auth::user()->role_id == 5)
                    <div class="col-md-12">
                        <div class="tab-div">
                            <div class="tab">
                                <a href="{{ URL::to('/user/recaps') }}">
                                    <button class="{{ $slug == null ? 'active' : '' }}">All Recaps</button>
                                </a>
                                {{-- <a href="{{ URL::to('/user/recaps/due') }}">
                                    <button class="{{ $slug == 'due' ? 'active' : '' }}">Due</button>
                                </a> --}}
                                <a href="{{ URL::to('/user/recaps/submitted') }}">
                                    <button class="{{ $slug == 'submitted' ? 'active' : '' }}">Submitted</button>
                                </a>
                                <a href="{{ URL::to('/user/recaps/redos') }}">
                                    <button class="{{ $slug == 'redos' ? 'active' : '' }}">Redos</button>
                                </a>
                                <a href="{{ URL::to('/user/recaps/approved') }}">
                                    <button class="{{ $slug == 'approved' ? 'active' : '' }}">Approved</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="tab-div">
                            <div class="tab">
                                <a href="{{ URL::to('/recaps') }}">
                                    <button class="{{ $slug == null ? 'active' : '' }}">All Recaps</button>
                                </a>
                                <a href="{{ URL::to('/recaps/approved') }}">
                                    <button class="{{ $slug == 'approved' ? 'active' : '' }}">Approved</button>
                                </a>
                                <a href="{{ URL::to('/recaps/pending') }}">
                                    <button class="{{ $slug == 'pending' ? 'active' : '' }}">Pending</button>
                                </a>
                                <a href="{{ URL::to('/recaps/rejected') }}">
                                    <button class="{{ $slug == 'rejected' ? 'active' : '' }}">Rejected</button>
                                </a>
                                <a href="{{ URL::to('/recaps/due') }}">
                                    <button class="{{ $slug == 'due' ? 'active' : '' }}">Due</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- table --}}

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table dashboard-table display recap-table">
                            <thead>
                                <tr>
                                    <th width="5%"><input type="checkbox" id="selectAll"></th>

                                    <th scope="col">No</th>
                                    @if (Auth::user()->role_id != 5)
                                        <th scope="col">Name</th>
                                    @endif
                                    <th scope="col">BRAND @ STORE</th>
                                    <th>STATUS</th>
                                    <th>EVENT DATE</th>
                                    @if (Auth::user()->role_id == 5)
                                        <th>DUE DATE</th>
                                    @else
                                        <th>SUBMITTED DATE</th>
                                    @endif
                                    <th>ACTIONS</th>
                                    <th>FILE</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($user_recaps as $uc)

                                    {{-- @if($uc->recap != null ) --}}
                                    <tr class="">
                                        @if($uc->status == 'approved')

                                            <td><input type="checkbox" class="row-checkbox" value="{{ $uc->id }}"></td>
                                        @else
                                            <td><input type="hidden" class="row-checkbox" value="{{ $uc->id }}"></td>

                                        @endif

                                        <td scope="row">
                                            <p class="mb-0 pb-0">{{ $loop->iteration }}</p>
                                        </td>
                                        @if (Auth::user()->role_id != 5)
                                            <td>
                                                <a href="{{ URL::to("/user/recap/$uc->id") }}" class="no-decoration"
                                                    style="color: inherit;">
                                                    <div class="d-flex align-items-center brand-info">
                                                        <div class="ms-3">
                                                            <h3 class="mb-0 pb-0 f-16 w-600">{{ $uc->user->name }}</h3>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if (Auth::user()->role_id == 5)
                                                    <p class="mb-0 pb-0">{{ $uc->recap->brand->title }}</p>
                                                @else
                                                    <p class="mb-0 pb-0">{{ $uc->recap->brand->title }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if ($uc->status == 'pending' || $uc->status == null)
                                                @if (Auth::user()->role_id == 5)
                                                    <div class="rejected">Pending</div>
                                                @else
                                                    <div class="rejected">Pending</div>
                                                @endif
                                            @elseif($uc->status == 'submitted')
                                                @if (Auth::user()->role_id == 5)
                                                    <div class="rejected">Submitted</div>
                                                @else
                                                    <div class="rejected">-</div>
                                                @endif
                                            @elseif($uc->status == 'rejected' || $uc->status == 'rejected-with-edit' || $uc->status == 'rejected-with-feedback')
                                                <div class="rejected">Rejected</div>
                                            @elseif($uc->status == 'approved' || $uc->status == 'approved-with-edit')
                                                @if (Auth::user()->role_id == 5)
                                                    <div class="approved">Approved</div>
                                                @else
                                                    <div style="width: fit-content;">
                                                        <div class="d-flex  flex-column align ">
                                                            <p class="mb-0 pb-0 text-center">{{ $uc->rating }}</p>
                                                            <div>
                                                                @for ($i = 1; $i <= $uc->rating; $i++)

                                                                    <i class="bi-star-fill"></i>
                                                                @endfor
                                                                @for ($i = $uc->rating; $i < 5; $i++)
                                                                    <i class="bi-star"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if (Auth::user()->role_id == 5)

                                                    <p class="mb-0 pb-0">{{ $uc->recap->event_date }}</p>
                                                @else
                                                    <p class="mb-0 pb-0">{{ $uc->recap->event_date }}</p>

                                                @endif
                                            </div>
                                        </td>
                                        @if (Auth::user()->role_id == 5)
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 pb-0">{{ $uc->recap->due_date }}</p>
                                                </div>
                                            </td>
                                        @else
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 pb-0">{{ date('Y-M-d, H:i a', strtotime($uc->submit_date)) }}
                                                    </p>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="d-flex align-items-center justify-content-start gap-2">
                                                <div class="eye  table-action cursor-pointer">
                                                    @if (Auth::user()->role_id == 5)
                                                        <a href="{{ URL::to("/user/recap/$uc->id") }}" class="no-decoration">
                                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" />
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <a href="{{ URL::to("/recap/$uc->id") }}" class="no-decoration">
                                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                                @if ($uc->status == 'approved' || $uc->status == 'approved-with-edit')
                                                <a href="#" class="download-recap" data-recap-id="{{ $uc->id }}" title="Download as Excel">Download</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $url = $uc->recap_url ?? null;
                                                @endphp

                                                @if($url && filter_var($url, FILTER_VALIDATE_URL))
                                                    <a href="{{ $url }}" class="mb-0 pb-0" target="_blank">View</a>
                                                @else
                                                    <span class="text-muted">Not Submitted Yet!</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    </tr>
                                    {{-- @endif --}}
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.recap-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search Recap..."
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
                title: 'Are you sure To Confirm This Recap?',
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
                        url: "/recap/approve-with-rating/multiple",

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

        // Download recap as Excel
        $(document).on('click', '.download-recap', function(e) {
            e.preventDefault();
            const recapId = $(this).data('recap-id');
            
            // Create a form and submit it
            const form = $('<form>')
                .attr('method', 'GET')
                .attr('action', '/recap/' + recapId + '/download-excel')
                .appendTo('body');
            
            form.submit();
            form.remove();
        });

    </script>
@endsection
