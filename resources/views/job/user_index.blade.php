@extends('user.layouts.master', ['module' => 'shifts'])

@section('title')
    shifts
@endsection
@php
    $colors = [
        '#a1d5ff', // Light Sky Blue
        '#d0e0e3', // Light Grayish Blue
        '#b2e59c', // Soft Green
        '#ff9a9e', // Light Pinkish Red
        '#ffcccb', // Soft Peach
        '#f3e5e5', // Light Misty Pink
        '#d4e157', // Pastel Lime Green
        '#ffecb5', // Soft Yellow
        '#a0d0ff', // Shiny Sky Blue
        '#fbd3c8', // Pastel Coral
        '#d9c0ff', // Lavender Pastel
        '#c4e17f', // Light Green
        '#e0b3ff', // Shiny Violet
        '#f3b6d9', // Pink Pastel
        '#ffe3e3', // Pale Pink
        '#bff3c9', // Green Mint
        '#d0f4f7', // Light Cyan
        '#d1e7ff', // Pastel Blue
        '#f3f0c5', // Shiny Cream
        '#a3c9ff', // Lighter Blue
        '#ffdb99', // Soft Orange
        '#e2dfff', // Sky Pastel
        '#c9dff0', // Aqua Mist
        '#f3e0a0', // Light Cream Yellow
    ];
    $b_colors = [
        '#5a9bf5', // Darker Sky Blue
        '#7a8b8e', // Darker Grayish Blue
        '#547e42', // Darker Soft Green
        '#d15c5f', // Darker Pinkish Red
        '#b39999', // Darker Peach
        '#cda9a9', // Darker Misty Pink
        '#5a7308', // Darker Pastel Lime Green
        '#b3a05e', // Darker Soft Yellow
        '#4973cc', // Darker Shiny Sky Blue
        '#a0665a', // Darker Pastel Coral
        '#9b6cbf', // Darker Lavender Pastel
        '#3f7f39', // Darker Light Green
        '#a64dc6', // Darker Shiny Violet
        '#9e5a8c', // Darker Pink Pastel
        '#9c6464', // Darker Pale Pink
        '#537e56', // Darker Green Mint
        '#407b88', // Darker Light Cyan
        '#2750a3', // Darker Pastel Blue
        '#aa8433', // Darker Shiny Cream
        '#5f7dba', // Darker Lighter Blue
        '#e08b60', // Darker Soft Orange
        '#a3b7db', // Darker Sky Pastel
        '#5d80aa', // Darker Aqua Mist
        '#9f7c60', // Darker Light Cream Yellow
    ];

@endphp
@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .pagination {
            float: right !important;
        }

        .counter {
            display: block;
            font-size: 32px;
            font-weight: 700;
            color: #666;
            line-height: 28px
        }

        .counter-box {
            display: flex;
            flex-direction: column;
            /* align-items: center; */
            padding: 14px 14px 15px 14px;
            box-shadow: 0 5px 10px rgb(0 0 0 / 40%);
            border-radius: 8px;
            /* border: 1px solid black; */
            margin: 0 0 20px 0;
            border-top: 10px solid #cd7faf;
        }

        .underline {
            border: 2px solid black;
            width: 100%;
        }

        .pub-position {
            position: relative;
            left: 44%;
            top: 0;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #cd7faf;
            border-color: #cd7faf;
        }
        .btn-group-sm>.btn,
        .btn-sm {
            padding: 2px 9px;
            font-size: .875rem;
            /* border-radius: .2rem; */
            color: #00000096;
            font-weight: 700;
            box-shadow: 1px 3px 9px 1px #00000045;
        }
    </style>
@endsection

@section('content')
    <div class="container">

        {{-- title section --}}
        {{-- <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <h1 class="f-32 w-600 text-bl">
                    Shifts/Schedule
                </h1>

                <div class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                    <a href="{{ URL::to('/shifts/import') }}" class="main-btn-blank ms-sm-3 ms-0 text-white bg-primary">
                        Upload Shifts</a>
                </div>
            </div>
        </div> --}}

        <div class="row mb-5">
            <div class="col-lg-12">

                {{-- include alerts --}}
                @include('common.alerts')

                {{-- tabs --}}
                <div class="tab-div">
                    <div class="tab">
                        <form action="{{ URL::to('/shifts') }}" method="get">
                            <input type="hidden" name="tab" value="all">
                            <button type="submit" class="{{ $tab == 'all' ? 'selected-tab' : '' }}">All</button>
                        </form>
                        <form action="{{ URL::to('/shifts') }}" method="get">
                            <input type="hidden" name="tab" value="published">
                            <button class="{{ $tab == 'published' ? 'selected-tab' : '' }}">Published</button>
                        </form>
                        <form action="{{ URL::to('/shifts') }}" method="get">
                            <input type="hidden" name="tab" value="unpublished">
                            <button class="{{ $tab == 'unpublished' ? 'selected-tab' : '' }}">Unpublished</button>
                        </form>
                    </div>
                </div>
                {{-- <form id="fiilter-form" action="" novalidate="novalidate" data-parsley-validate
                class="form-horizontal form-label-left" method="post">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mt-4">
                        <div class="form-group">
                            <label> Search By Date</label>
                           <input type="date" name="date" class="form-control" value="{{$_GET['date'] ?? '' }}" onchange="getByDate(this.value)">
                            <span class="error-container danger w-100"></span>
                        </div>
                    </div>
                </div>
                </form> --}}
                <div class="row">
                    <div class="mt-4"></div>
                    @foreach ($shifts as $index => $shift)
                        @php

                            $color = count($colors) > 0 ? $colors[$index % count($colors)] : '#CCCCCC';
                            $b_color = count($b_colors) > 0 ? $b_colors[$index % count($b_colors)] : '#CCCCCC';
                        @endphp
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="counter-box rounded"
                                style="background-color: {{ $color }}; border:2px solid {{ $b_color }};">

                                <!-- Header Section -->
                                <div class="d-flex justify-content-end align-items-center">
                                    @if ($shift->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Publish Now</span>
                                    @endif
                                </div>
                                <h4 class="mb-0">{{ $shift->brand }}</h4>

                                <!-- Divider -->
                                <hr class="underline">

                                <!-- Shift Info Section -->
                                <div class="text-muted">
                                    <h6 class="mb-1 fs-14">
                                        <strong>Account:</strong> {{ $shift->account }}
                                    </h6>
                                    <p class="mb-1 fs-14">
                                        <strong>Contact:</strong> {{ $shift->contact }} - {{ $shift->phone }}
                                    </p>
                                    <p class="mb-0 fs-14">
                                        <strong>Shift Info:</strong> {{ $shift->date }} {{ $shift->scheduled_time }}
                                    </p>
                                </div>

                                <div class="d-flex justify-content-around mt-3">

                                    <!-- Edit Button -->
                                    <div class="edit table-action cursor-pointer"
                                        style="border:2px solid {{ $b_color }}">
                                        <a href='{{ URL::to("user/shift/$shift->id/detail") }}' class="btn btn-sm"
                                            style="background-color: {{ $color }};">
                                            {{-- <svg width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" />
                                        </svg> --}}
                                    Detail
                                    </a>
                                    </div>

                                    @if ($shift->status == 'approved')
                                        <button class="btn  btn-sm text-success" disabled>
                                            Accepted
                                        </button>
                                    @elseif($shift->status == 'reject' || $shift->status == 'unable')
                                        <button class="btn  btn-sm text-danger" disabled>
                                            {{strtoupper($shift->status) ?? 'REJECTED'}}
                                        </button>
                                    @elseif($shift->status == 'can_if_needed')
                                    <button class="btn  btn-sm text-warning" disabled>
                                            {{'Can, If Needed'}}
                                        </button>
                                    @else
                                        <!-- Accept Button -->
                                        <button class="btn btn-sm text-success"
                                            onclick="acceptShift('{{ $shift->id }}')">
                                            Accept
                                        </button>
                                        <!-- Decline Button -->
                                        <button class="btn btn-sm text-danger"
                                            onclick="declineShift('{{ $shift->id }}')">
                                            Reject
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach

                    {{ $shifts->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="f-22" style=" font-weight: 600;">Shift Notes</h5>
                        <p class="mb-0 pb-0 f-600 text-gray f-14"> </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row w-100 align-items-center">
                        <input type="hidden" id="form_job_id" value="" name="jobId">
                        <div class="col-lg-12 col-md-12 col-10">
                            <div class="form-floating mb-4 w-100">
                                <input type="text" class="form-control sign-input " id="note"
                                    placeholder="Text here" name="note" readonly>
                                <label for="note" class="sign-label">Note</label>
                            </div>
                        </div>

                    </div>

                    <hr class="sign-line">

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
                    searchPlaceholder: "Search shifts..."
                }
            });
        });

        $(document).on('click', '.modal_btn', function() {
            $("#form_job_id").val($(this).data('job'));
            $("#note").val($(this).data('note'));
        });

        function getByDate(date) {
            let url = new URL(window.location.href);
            let params = new URLSearchParams(url.search);

            // Remove any existing 'date' parameter, then set the new value
            params.delete('date');
            params.append('date', date);

            // Update the URL
            window.location.href = url.origin + url.pathname + '?' + params.toString();
        }


        function declineShift(id) {

            Swal.fire({
                title: 'Are you sure To Decline This Shift?',
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

                        type: "get",
                        url: "shift/decline/" + id,

                        success: function(response) {
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


//         function acceptShift(id) {

// Swal.fire({
//     title: 'Are you sure To Confirm This Shift?',
//     // text: "You won't be able to revert this!",
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Submit'
// }).then((result) => {
//     if (result.isConfirmed) {

//         $.ajaxSetup({
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             },
//         });

//         $.ajax({

//             type: "get",
//             url: "shift/accept/" + id,

//             success: function(response) {
//                 // console.log(response);
//                 // return;
//                 let status = response.status;

//                 if (status == 200) {
//                     Swal.fire({
//                         title: response.message,
//                         // text: "You won't be able to revert this!",
//                         icon: 'success',
//                         showCancelButton: false,
//                         confirmButtonColor: '#3085d6',
//                         cancelButtonColor: '#d33',
//                         confirmButtonText: 'ok'
//                     }).then((result) => {
//                         if (result.isConfirmed) {
//                             location.reload();
//                         }
//                     });
//                 } else {
//                     console.log("Something went wrong!!!");
//                 }
//             },
//         });
//     }
// })
// }

function acceptShift(id) {
    Swal.fire({
        title: 'Shift Confirmation',
        text: 'Please choose an option',
        icon: 'question',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: 'I Confirm',
        denyButtonText: 'I Need Coverage',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // I Confirm
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                type: "GET",
              url: "{{ route('user.accept', ':id') }}".replace(':id', id),
                success: function (response) {
                    if (response.status == 200) {
                        Swal.fire({
                            title: "Thank you!",
                            html: `Thank you for confirming your shift on <b>${response.data.date}</b> at <b>${response.data.time}</b> for <b>${response.data.brand}</b> at <b>${response.data.account}</b>. <br><br>You have <b>${response.data.count}</b> quizzes due.<br><a href="${response.data.link}" target="_blank">Take Quizzes</a>`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error", "Something went wrong!", "error");
                    }
                }
            });

        } else if (result.isDenied) {
            // I Need Coverage
            Swal.fire({
                title: 'Coverage Request',
                text: 'Choose one:',
                input: 'radio',
                inputOptions: {
                    'unable': 'I am unable to work this shift.',
                    'can_if_needed': 'I can work if nobody else can cover.'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to choose one!';
                    }
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel'
            }).then((coverageResult) => {
                if (coverageResult.isConfirmed) {
                    const coverageType = coverageResult.value;

                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: "shift/request-coverage",
                        data: {
                            shift_id: id,
                            type: coverageType
                        },
                        success: function (response) {
                            if (response.status == 200) {
                                Swal.fire("Submitted", response.message, "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error", "Could not process coverage request!", "error");
                            }
                        }
                    });
                }
            });
        }
    });
}

    </script>
@endsection
