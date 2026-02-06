@extends('layouts.master', ['module' => 'coverage'])

@section('title')
    Need Coverage
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

        .due {
            display: inline-flex;
            /* padding: 2px 10px 2px 10px; */
            justify-content: center;
            align-items: center;
            border-radius: 4px;
            background: rgba(255, 160, 67, 0.1);
            color: #dc3545;
            font-family: Manrope;
            font-size: 12px;
            font-style: normal;
            font-weight: 600;
            /* border: 2px solid; */
            /* letter-spacing: 1px; */
            /* box-shadow: 0px 4px 5px 0px #6c757d85; */
        }

        .submitted,
        .approved {
            letter-spacing: 2px;
            box-shadow: 0px 4px 5px 0px #6c757d85;
            border: 2px solid;
            color: #12ac92;

        }

        .profile-picture {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .card-design {
            border: 1px solid #cd7faf;
            border-radius: 7px;
            padding: 0 !important;

        }

        p.mb-0 {
            line-height: 1.2;
        }

        .swiper-scrollbar-drag,
        .swiper-button-prev,
        .swiper-button-prev.swiper-button-disabled,
        .swiper-button-next,
        .swiper-button-next.swiper-button-disabled {
            color: #cd7faf;
        }

        .swiper-scrollbar.swiper-scrollbar-horizontal,
        {
        background: #cd7faf;

        }

        .fs-14 {
            font-size: 14px !important;
        }

        .cursor-pointer {
            border-radius: 3px !important;
            margin-right: 1px !important;
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
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <h1 class="f-32 w-600 text-bl">
                    coverage
                </h1>


                {{-- <div class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                    <a href="{{ URL::to('/shifts/import') }}" class="main-btn-blank ms-sm-3 ms-0 text-white bg-primary">
                        Upload Shifts</a>
                </div> --}}
            </div>
        </div>
        {{-- <div class="container my-2 ">
            <h4>Available for shift</h4>

            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <!-- Card 1 -->
                    @foreach ($avalable_user as $a)
                    <div class="swiper-slide mx-1  shadow mb-3">
                        <div class="p-1 card-design d-flex flex-row align-items-center" style="">
                            <img src="{{ $a->profile_image }}" alt="Profile Picture" class="profile-picture "
                                onerror="this.onerror=null; this.src='{{ URL::to('/assets/images/Asset2.png') }}';">
                            <div class="card-body p-1 mx-2 mb-0">
                                <h6 class="p-0 mb-0">{{ $a->name }}</h6>
                                <p class="mb-0"><small class="mb-0 p-0"> {{ $a->email }} <br class="p-0 mb-0">
                                        {{ $a->mobile_no }} </small></p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Add more cards as needed -->
                </div>
                <!-- Navigation buttons and scrollbar -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-scrollbar"></div>
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
                {{-- <div class="d-flex justify-content-between align-items-center mt-3">
                    <!-- Select All Checkbox -->
                    <div>
                        <input type="checkbox" id="selectAll" class="form-check-input">
                        <label for="selectAll" class="form-check-label">Select All</label>
                    </div>

                    <!-- Buttons Group -->
                    <div class="btn-group">
                        <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm py-1" disabled>Publish
                            Selected</button>
                        {{-- <a href="{{ asset('assets/files/newsample.xlsx') }}"
                            class="btn btn-primary btn-sm py-1">Download
                            Sample</a>
                    </div>
                </div> --}}

                <form id="fiilter-form" action="" novalidate="novalidate" data-parsley-validate
                    class="form-horizontal form-label-left" method="post">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mt-4">
                            <div class="form-group">
                                <label> Search By Date</label>
                                <input type="date" name="date" class="form-control" value="{{ $_GET['date'] ?? '' }}"
                                    onchange="getByDate(this.value)">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="col-lg-12 mt-4">
                    <div class="table-responsive">
                        <table class="table table-sm dashboard-table dashboard-table-lg">
                            {{-- <table class="table table-bordered table-striped"> --}}
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>Published</th>
                                        <th>Brand</th>
                                        <th>Account</th>
                                        {{-- <th>Contact</th> --}}
                                        <th>Date</th>
                                        {{-- <th>Phone</th> --}}
                                        {{-- <th>Notes</th> --}}
                                        {{-- <th>Scheduled Time</th> --}}
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Coverage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $job)
                                        <tr>
                                            <td>{{ $job->id }}</td>
                                            <td>{{ $job->is_published ? 'Yes' : 'No' }}</td>
                                            <td>{{ $job->brand }}</td>
                                            <td>{{ $job->account }}</td>
                                            {{-- <td>{{ $job->contact }}</td> --}}
                                            <td>{{ $job->date }}</td>
                                            {{-- <td>{{ $job->phone }}</td> --}}
                                            {{-- <td>{{ $job->notes }}</td> --}}
                                            {{-- <td>{{ $job->scheduled_time }}</td> --}}
                                            <td>{{ $job->assigne }}</td>
                                            <td>
                                                @if ($job->status == 'unable')
                                                    <span class="badge bg-danger">Unable</span>
                                                @elseif ($job->status == 'can_if_needed')
                                                    <span class="badge bg-warning text-dark">Can, If Needed</span>
                                                @elseif ($job->status == 'reject')
                                                    <span class="badge bg-danger">Reject</span>
                                                @elseif ($job->status == 'open')
                                                    <span class="badge bg-info text-dark">Open</span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ URL::to('shifts/requestors-list/'.$job->id) }}"> view requests </a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- pagination --}}
                            @if ($jobs->hasPages())
                                <div class="pagination-wrapper">
                                    {{ $jobs->links() }}
                                </div>
                            @endif
                    </div>
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
                    <form action='{{ URL::to('/shift/note/add') }}' method="post" class="sign__frame-right--form">
                        @csrf

                        <div class="row w-100 align-items-center">
                            <input type="hidden" id="form_job_id" value="" name="jobId">
                            <div class="col-lg-12 col-md-12 col-10">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="note" placeholder="Text here"
                                        name="note" required>
                                    <label for="note" class="sign-label">Note</label>
                                </div>
                            </div>

                        </div>

                        <hr class="sign-line">
                        <div class="col-lg-12">
                            <div class="d-flex mt-4">
                                <button class="sign-btn" type="submit">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            scrollbar: {
                el: ".swiper-scrollbar",
                draggable: true,
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.pay-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search shifts..."
                }
            });
        });

        $(document).on('click', '.modal_btn', function () {
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

        function deletefunction(id) {

            Swal.fire({
                title: 'Are you sure To Confirm This Shift?',
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
                        url: "shift/delete/" + id,

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

        $(document).ready(function () {
            const $selectAll = $("#selectAll");
            const $shiftCheckboxes = $(".select-shift");
            const $bulkDeleteBtn = $("#bulkDeleteBtn");

            // Select All functionality
            $selectAll.on("change", function () {
                $shiftCheckboxes.prop("checked", this.checked);
                toggleDeleteButton();
            });

            // Toggle delete button when individual checkboxes change
            $shiftCheckboxes.on("change", function () {
                const allChecked = $shiftCheckboxes.length === $shiftCheckboxes.filter(":checked").length;
                $selectAll.prop("checked", allChecked);
                toggleDeleteButton();
            });

            function toggleDeleteButton() {
                const anyChecked = $shiftCheckboxes.filter(":checked").length > 0;
                $bulkDeleteBtn.prop("disabled", !anyChecked);
            }

            // Bulk delete functionality
            $bulkDeleteBtn.on("click", function () {
                const selectedIds = $shiftCheckboxes.filter(":checked").map(function () {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) {
                    Swal.fire({
                        title: "No shifts selected!",
                        icon: 'info',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Publish!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "shift/publish",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                job_ids: selectedIds
                            },
                            success: function (response) {

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
                                            selectedIds.forEach(id => {
                                                $(`#shift_${id}`)
                                                    .remove();
                                            });
                                            $selectAll.prop("checked", false);
                                            toggleDeleteButton();
                                            location.reload();
                                        }
                                    });

                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while publoshing shifts. Please try again.",
                                    icon: 'error',
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
