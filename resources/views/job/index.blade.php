@extends('layouts.master', ['module' => 'shifts'])

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
                    Shifts/Schedule
                </h1>

                <div class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                    <a href="{{ URL::to('/shifts/import') }}" class="main-btn-blank ms-sm-3 ms-0 text-white bg-primary">
                        Upload Shifts</a>
                </div>
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
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <!-- Select All Checkbox -->
                    <div>
                        <input type="checkbox" id="selectAll" class="form-check-input">
                        <label for="selectAll" class="form-check-label">Select All</label>
                    </div>

                    <!-- Buttons Group -->
                    <div class="btn-group">
                        <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm py-1" disabled>Publish
                            Selected</button>
                        {{-- <a href="{{ asset('assets/files/newsample.xlsx') }}" class="btn btn-primary btn-sm py-1">Download
                            Sample</a> --}}
                    </div>
                </div>

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

                <div class="row">

                    <div class="mt-4"></div>
                          @foreach ($shifts as $index => $shift)
                        @php
                            $color = count($colors) > 0 ? $colors[$index % count($colors)] : '#CCCCCC';
                            $b_color = count($b_colors) > 0 ? $b_colors[$index % count($b_colors)] : '#CCCCCC';
                            
                            // Check if shift date is in the future
                            $iszutureShift = \Carbon\Carbon::parse($shift->date)->isFuture() || \Carbon\Carbon::parse($shift->date)->isToday();
                        @endphp

                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="counter-box rounded" style="background-color: {{ $color }}; border:2px solid {{ $b_color }};">
                                    
                                    <div class="form-check">
                                            <input type="checkbox" class="form-check-input select-shift" value="{{ $shift->id }}">
                                        <label class="form-check-label"></label>
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center">
                                        @if ($shift->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Publish Now</span>
                                        @endif
                                    </div>

                                    <h4 class="mb-0">{{ $shift->brand }}</h4>
                                    <hr class="underline">

                                    <div class="text-muted">
                                        <h6 class="mb-1 fs-14"><strong>Account:</strong> {{ $shift->account }}</h6>
                                        <p class="mb-1 fs-14"><strong>Contact:</strong> {{ $shift->contact }} - {{ $shift->phone }}</p>
                                        <p class="mb-0 fs-14"><strong>Shift Info:</strong> {{ $shift->date }} {{ $shift->scheduled_time }}</p>
                                    </div>

                                    <div class="d-flex justify-content-around mt-3">
                                        <button class="btn btn-sm" style="background-color: {{ $color }}; border: 2px solid {{ $b_color }};" 
                                                data-bs-toggle="modal" data-job="{{ $shift->id }}" data-note="{{ $shift->notes }}" data-bs-target="#exampleModal">
                                            + Note
                                        </button>

                                        <a href='{{ URL::to("/shift/$shift->id/members") }}' class="btn btn-sm" style="background-color: {{ $color }}; border: 2px solid {{ $b_color }};">
                                            + Members
                                        </a>

                                        @if (!$shift->is_published)
                                            <div class="edit table-action cursor-pointer" style="border:2px solid {{ $b_color }}">
                                                <a href='{{ URL::to("/shift/$shift->id/edit") }}' class="btn btn-sm" style="background-color: {{ $color }};">
                                                    Edit
                                                </a>
                                            </div>

                                            <button type="button" class="btn btn-sm text-danger" 
                                                    style="background-color: {{ $color }}; border: 2px solid {{ $b_color }};" 
                                                    onclick="deletefunction({{ $shift->id }})">
                                                Delete
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    {{ $shifts->links() }}

                </div>
                {{-- table --}}
                {{-- <div class="table-responsive">
                    <table class="table dashboard-table tabcontent-table pay-table">
                        <thead>
                            <tr>
                                <th width="5%">Sr.</th>
                                <th width="30%">Account & Contact</th>
                                <th width="20%">Brand</th>
                                <th width="15%">Shift Info</th>
                                <th width="12%">Status</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shifts as $shift)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <h6 class="mb-2 ">{{ $shift->account }}</h6>
                                    <p class="mb-0">{{ $shift->contact }}</p>
                                    <p class="mb-0">{{ $shift->phone }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 pb-0">{{ $shift->brand }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 pb-0">{{ $shift->date }}</p>
                                    <p class="mb-0 pb-0">{{ $shift->scheduled_time }}</p>
                                </td>
                                <td scope="row">
                                    @if ($shift->is_published)
                                    <div class="approved">Published</div>
                                    @else
                                    <div class="due">UnPublished</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="edit table-action cursor-pointer">
                                            <a href='{{ URL::to("/shift/$shift->id/members") }}' class="btn  btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M12 12C15.3137 12 18 9.31371 18 6C18 2.68629 15.3137 0 12 0C8.68629 0 6 2.68629 6 6C6 9.31371 8.68629 12 12 12ZM12 14C8.13401 14 4.98816 16.7221 4.23607 20.3639C4.01266 21.3355 4.70711 22.1645 5.62221 21.9879C9.02582 21.1213 12 17.8987 12 17.8987C12 17.8987 14.9742 21.1213 18.3778 21.9879C19.2929 22.1645 19.9873 21.3355 19.7639 20.3639C19.0118 16.7221 15.8659 14 12 14Z"
                                                        fill="#000" />
                                                </svg>
                                            </a>
                                        </div>

                                        <div class="edit table-action cursor-pointer">
                                            <a href='{{ URL::to("/shift/$shift->id/edit") }}' class="btn  btn-sm mx-1">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3 17.2501V21.0001H6.75L17.81 9.94006L14.06 6.19006L3 17.2501ZM20.71 7.04006C21.1 6.65006 21.1 6.02006 20.71 5.63006L18.37 3.29006C17.98 2.90006 17.35 2.90006 16.96 3.29006L15.13 5.12006L18.88 8.87006L20.71 7.04006Z" />
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="edit table-action cursor-pointer">
                                            <form action="{{ URL::to('/shift/delete') }}" method="post">
                                                @csrf

                                                <input type="hidden" name="shift_id" value="{{ $shift->id }}">

                                                <button type="submit" class="btn  btn-sm" {{ $shift->is_published ?
                                                    'disabled' : '' }}>
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M20 6H17L16 4H8L7 6H4L4 8L5 19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19L20 8V6ZM9 18C9 18.55 8.55 19 8 19C7.45 19 7 18.55 7 18V9C7 8.45 7.45 8 8 8C8.55 8 9 8.45 9 9V18ZM13 18C13 18.55 12.55 19 12 19C11.45 19 11 18.55 11 18V9C11 8.45 11.45 8 12 8C12.55 8 13 8.45 13 9V18Z"
                                                            fill="#FF0000" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
