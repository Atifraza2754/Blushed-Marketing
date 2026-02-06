@extends('layouts.master', ['module' => 'shifts'])

@section('title')
    Job Members Detail
@endsection

@section('customStyles')
    <style>
        .bg-primary-blue {
            background-color: #1976A6;
            color: white;
        }

        .select2-container--default .select2-selection--single {
            /* background-color: #fff; */
            /* border: 1px solid #aaa; */
            /* border-radius: 4px; */
            width: 300px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #f0f0f0 !important;
            /* optional: to change highlight color */
            color: #000 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected]::after {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="col-md-12 mx-auto">

                {{-- include alerts --}}
                @include('common.alerts')

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p class="mb-0 pb-0 f-14 w-600">{{ $job->scheduled_time ?? '' }} &nbsp;&nbsp;&nbsp; <span
                                class="text-light"></span>
                        </p>
                        <p class="mb-0 pb-0 f-14 w-600">{{ $job->brand }} </p>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap">
                            <div class="mt-2">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Account:</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->account }}</p>
                            </div>
                            <div class="mt-2">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Client:</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->brand }}</p>
                            </div>
                        </div>

                        <div
                            class="d-flex justify-content-between align-items-start  mt-3 flex-md-row flex-column flex-wrap">
                            <div class="mt-2">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Address:</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->address }}</p>
                            </div>
                            <div class="mt-2">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Phone #:</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->phone }}</p>
                            </div>
                        </div>

                        <div
                            class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap mt-3">
                            <div class="mt-2">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Email:</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->email }}</p>
                            </div>
                            <div class="mt-2">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Contact:</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->contact }}</p>
                            </div>
                            <div class="mt-2">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Communication via:</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->method_of_communication }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Brands And Products</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $job->skus }}</p>
                        </div>

                        <hr class="sign-line my-3">
                        <div class="mt-4">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Coverage Status</p>
                            @if ($job->coverage_status)
                                <a type="button" href="{{ URL::to('shifts/requestors-list/' . $job->coverage_status) }}"
                                    class="btn btn-info  f-14  text-black">{{ 'View Coverage' }}</a>
                            @else
                                <p class="mb-0 pb-0 f-14 w-600 text-black">{{ 'No Coverage Yet !' }}</p>
                            @endif
                        </div>

                        <hr class="sign-line my-3">

                        <h1 class="f-14 w-700 mb-3">Other Shift Contractor
                            <!-- Button to Trigger Modal -->
                            <button type="button" class="mx-3 btn btn-sm btn-primary px-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                    <circle cx="24" cy="24" r="22" fill="#ccc" stroke="#000" stroke-width="2" />
                                    <path d="M24 12V36M12 24H36" stroke="#000" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </button>
                        </h1>
                        <div class="satff-div-responsive">
                            <div class="satff-div">

                                @foreach ($members as $member)
                                    @if ($member->user)
                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">

                                                @if ($member->user)
                                                    @php
                                                        $image = $member->user->profile_image;
                                                    @endphp
                                                    <img class="dp-img rounded rounded-circle"
                                                        src="{{ URL::to('/storage/images/users/sm/' . $image) }}"
                                                        onerror="this.onerror=null; this.src='{{ URL::to('/assets/images/imagee.png') }}';"
                                                        alt="">
                                                @else
                                                    <img src="{{ URL::to('/assets/images/Avatar.png') }}" alt="" class="dp-img">
                                                @endif

                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">{{ $member->user->name ?? '' }}</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <a type="button"
                                                    href='{{ URL("/shift/$job->id/member/detail?user=" . $member->user->id) }}'
                                                    class="hover-btn">
                                                    <img src="{{ URL::to('/assets/images/view.svg') }}" alt="view member">
                                                </a>
                                                <form action='{{ URL::to("/shift/$job->id/member/remove") }}' method="post">
                                                    @csrf

                                                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                                                    <input type="hidden" name="member_id" value="{{ $member->id }}">

                                                    <button class="hover-btn delete-detail">
                                                        <img src="{{ URL::to('/assets/images/delete.svg') }}" alt="delete member">
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                {{-- @if ($member->status == 'pending')
                                                <img src="{{ URL::to('/assets/images/pending.svg') }}" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
                                                @elseif ($member->status == 'reject')
                                                <img src="{{ URL::to('/assets/images/x-circle.svg') }}" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Rejected</p>
                                                @else
                                                <img src="{{ URL::to('/assets/images/accepted.svg') }}" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                                @endif --}}
                                                @if ($member->status == 'pending')
                                                    <span style="font-size: 18px;">⏳</span>
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
                                                @elseif ($member->status == 'reject')
                                                    <span style="font-size: 18px;">❌</span>
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Rejected</p>
                                                @elseif ($member->status == 'approved')
                                                    <span style="font-size: 18px;">✅</span>
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Approved</p>
                                                @elseif ($member->status == 'unable')
                                                    <span style="font-size: 18px;">⚠️</span>
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Unable</p>
                                                @elseif ($member->status == 'can_if_needed')
                                                    <span style="font-size: 18px;">🤝</span>
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Can if Needed</p>
                                                @else
                                                    <span style="font-size: 18px;">✔️</span>
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                                @endif

                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">{{ $member->flat_rate }}
                                                </p>
                                            </div>
                                            @php
                                                $total_flat_rate = 0;
                                                $is_payable = 0;
                                                $work_history_id = 0;
                                                if ($member->status == 'approved') {
                                                    $member_data = isset($member->userPayment)
                                                        ? $member->userPayment
                                                        : [];
                                                    if (!empty($member_data)) {
                                                        foreach ($member_data as $key => $md) {
                                                            $total_flat_rate += $md->flat_rate;
                                                            $is_payable = $md->is_payable;
                                                            $work_history_id = $md->work_history_id;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1"><small class="text-muted">Total
                                                        Amount Payable: </small>{{ $total_flat_rate }}</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                @if ($is_payable == 1)
                                                    <a href="{{ URL::to('payments-detail/' . $work_history_id) }}" class="main-btn">Pay
                                                        Now</a>
                                                @else
                                                    <div class="rejected ms-4 mt-md-0 mt-2">
                                                        Shift Not Completed! </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- add members modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        {{-- <h5 class="f-22" style=" font-weight: 600;">Add members to this job</h5> --}}
                        <h5 class="f-22" style=" font-weight: 600;">{{ $job->account }} {{ $job->scheduled_time }}
                        </h5>
                        <p class="mb-0 pb-0 f-600 text-gray f-14">Enter email with hour rate job</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action='{{ URL::to("/shift/$job->id/members/add") }}' method="post"
                        class="sign__frame-right--form">
                        @csrf

                        <div class="row w-100 align-items-center">
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class=" mb-4 w-100">
                                    <label for="floatingInput" class="text-muted">Name</label>
                                    <br>
                                    <select name="email[]" class="form-select   dselect2 " id="floatsingInput" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
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

    <script type="text/template" id="add-role">
            <div class="row align-items-center w-100">
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="form-floating mb-4 w-100">
                        <select name="email[]" class="form-control sign-input dselect2 " id="floatingInput" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-10">
                    <div class="form-floating mb-4 w-100">
                        <input type="text" class="form-control sign-input " value="{{ app('flatRate') }}" id="floatingInput" name="flat_rate[]" required>
                        <label for="floatingInput" class="sign-label">Flat rate</label>
                    </div>
                </div>
                <div class="col-2">
                    <div class="d-flex align-items-end justify-content-md-start justify-content-center">
                        <svg class="delete-appended-element" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 3L15.5 4H19V6H5V4H8.5L9.5 3H14.5ZM6 18.9999C6 20.0999 6.9 20.9999 8 20.9999H16C17.1 20.9999 18 20.0999 18 18.9999V6.9999H6V18.9999ZM8.0001 9H16.0001V19H8.0001V9Z" fill="#FC3400"/>
                        </svg>
                    </div>
                </div>
            </div>
            </script>
@endsection

@section('customScripts')
    <script>
        $(document).ready(function () {

            // Initialize Select2 with correct dropdown parent
            function initSelect2() {
                $('.dselect2').select2({
                    dropdownParent: $('#exampleModal')
                });
            }

            // Append template with filtered users
            function appendRoleTemplate() {
                // Get selected user IDs from existing selects
                let selectedValues = [];
                $('.dselect2').each(function () {
                    const val = $(this).val();
                    if (val) selectedValues.push(val);
                });

                // Clone the Blade template
                const template = $($("#add-role").html());

                // Remove selected users from the new dropdown
                template.find('option').each(function () {
                    if (selectedValues.includes($(this).val())) {
                        $(this).remove();
                    }
                });

                // Append to the form
                $(".appended-row").append(template);

                // Reinitialize Select2
                initSelect2();
            }

            // Add new row on click
            $(".add-role").on("click", appendRoleTemplate);

            // Delete row on delete icon click
            $(".appended-row").on("click", ".delete-appended-element", function () {
                $(this).closest(".row").remove();
            });

            // Initialize Select2 for existing field
            initSelect2();
        });
    </script>
@endsection
