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
        <div class="row mb-lg-4  mt-lg-3 mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <h1 class="f-32 w-600 text-bl">
                    Users Coverage Reuqests
                </h1>

                {{-- <div class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                    <a href="{{ URL::to('/shifts/import') }}" class="main-btn-blank ms-sm-3 ms-0 text-white bg-primary">
                        Upload Shifts</a>
                </div> --}}
            </div>
        </div>


        <div class="row mb-5">
            <div class="col-lg-12">

                {{-- include alerts --}}
                @include('common.alerts')

                {{-- tabs --}}



                <div class="container ">

                    @foreach($groupedJobs as $jobKey => $jobGroup)
                            @php
                                $first = $jobGroup->first();
                                $Job_id = $first->job_id;
                            @endphp
                            <div class="card mb-4 shadow-sm border">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">📋 Job #{{ $first->job_id }} - {{ $first->brand }} / {{ $first->account }}</h5>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>👤 Assignee:</strong> <span
                                                    class="text-dark">{{ $first->job_assignee_id }}</span></p>
                                            <p><strong>📞 Phone:</strong> <span class="text-dark">{{ $first->phone }}</span></p>
                                            <p><strong>📅 Date:</strong> <span class="text-dark">{{ $first->date }}</span> at <span
                                                    class="text-dark">{{ $first->scheduled_time }}</span></p>
                                            <p>
                                                <strong>📣 Published:</strong>
                                                @if($first->is_published)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-danger">No</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>✅ Accepted Requestor:</strong>
                                                @if($first->coverage_user_id)
                                                    <span class="badge bg-primary">{{ $first->coverage_user_id_name }}</span>
                                                @else
                                                    <span class="text-muted">None selected yet</span>
                                                @endif
                                            </p>
                                            <p><strong>📧 Contact:</strong> <span class="text-dark">{{ $first->contact }}</span></p>
                                            <p><strong>📝 Notes:</strong> <span class="text-dark">{{ $first->notes }}</span></p>
                                            <p><strong>📍 Address:</strong> <span class="text-dark">{{ $first->address }}</span></p>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive nested-table">
                                <table class="table table-bordered table-striped requestors-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Requestor Name</th>
                                            <th>ID</th>
                                            <th>Requested Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobGroup as $offer)
                                            <tr>
                                                <td>{{ $offer->requestor_name }}</td>
                                                <td>{{ $offer->requestor_id }}</td>
                                                <td>{{ $offer->requested_date }}</td>
                                                <td>
                                                    {{-- <form method="POST" action="{{ route('approve.user', $offer->requestor_id) }}">
                                                        --}}
                                                        {{-- @csrf --}}
                                                        @if($first->coverage_user_id == null || $first->coverage_user_id == '')
                                                            <button type="button" class="mx-3 btn btn-sm btn-primary px-2 modal_btn"
                                                                data-id="{{$offer->requestor_id}}" data-name="{{ $offer->requestor_name }}"
                                                                data-email="{{ $offer->requestor_email }}" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal"  {{$offer->requestor_id ? '' : 'disabled'}} >
                                                                Approve
                                                            </button>
                                                        @else
                                                            <button type="button" class="mx-3 btn btn-sm btn-info px-2 " disabled>
                                                                Assigned
                                                            </button>
                                                        @endif
                                                        {{--
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
            </div>

        </div>
    </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        {{-- <h5 class="f-22" style=" font-weight: 600;">Add members to this job</h5> --}}
                        <h5 class="f-22" style=" font-weight: 600;">{{ $first->account }} {{ $first->scheduled_time }}</h5>
                        {{-- <p class="mb-0 pb-0 f-600 text-gray f-14">Enter email with hour rate job</p> --}}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action='{{ URL::to("/shifts/requestors-list/submit") }}' method="post"
                        class="sign__frame-right--form">
                        @csrf

                        <div class="row w-100 align-items-center">
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class=" mb-4 w-100">
                                    <label for="floatingInput" class="text-muted">Name</label>
                                    <br>
                                    <p><span id="userName"></span> (<span id="userId"></span>)
                                        <input type="hidden" id="email" name="email[]">
                                        <input type="hidden" id="job_id" name="job_id" value="{{$first->job_id}}">
                                        <input type="hidden" id="job_coverage_requests" name="job_coverage_requests"
                                            value="{{$first->job_coverage_requests}}">
                                    </p>

                                    {{-- <select name="email[]" class="form-select   dselect2 " id="floatsingInput"
                                        required>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-10">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input" id="floatingInput" name="flat_rate[]"
                                        value={{ app('flatRate') }} required>
                                    <label for="floatingInput" class="text-muted">Flat rate</label>
                                </div>
                            </div>
                            <div class="col-2 ">
                                <div class="d-flex align-items-end  justify-content-md-start justify-content-center">
                                    <svg class="me-2 cursor-pointer add-role" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM17 13H13V17H11V13H7V11H11V7H13V11H17V13Z"
                                            fill="#CD7FAF" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class=" appended-row w-100 ">

                        </div>
                        <hr class="sign-line">
                        <div class="col-lg-12">
                            <div class="d-flex mt-4">
                                <button class="sign-btn" type="submit">Assign</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
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

        $(document).on('click', '.modal_btn', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');

            $("#userId").text(id);
            $("#userName").text(name);
            $("#email").val(id);

            console.log(id, name, email);
        })
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
