@extends('user.layouts.master', ['module' => 'clock-time'])
@php
    use Carbon\Carbon;
@endphp
@section('title')
    {{ 'Clock Time' }}
@endsection


<?php

$userTimezone = 'America/New_York'; // EST timezone


?>
@section('customStyles')
    <style>
        .complete-btn {
            text-decoration: none;
        }

        .complete-btn:hover {
            color: wheat;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="container">

            @include('common.alerts')

            <div class="blushed-card mt-4 mb-5"
                style="border-radius: 4px;
                    border: 1px solid var(--fill-dark-dark-5, #EBEAED);
                    background: var(--fill-white-white, #FFF);">
                <div class="d-flex flex-md-row flex-column justify-content-between align-items-start">
                    <div class="d-flex align-items-start  flex-md-row flex-column">
                        <div>
                            <img src="assets/images/calendar.svg" alt="">

                        </div>

                        <div class="ms-3">
                            <p class="f-16 w-600 text-primary mb-0 pb-0 mt-2">
                                @empty($nextShift)
                                    No Ongoing Shift
                                @else
                                    Shift Ongoing
                                @endempty
                            </p>
                            <h1 class="f-24 w-600 mb-2">
                                {{ $nextShift['account'] ?? '' }}
                            </h1>
                            <p class="mb-0 pb-0 f-14 w-500 text-gray">{{ $nextShift['diff'] ?? '' }} /
                                ${{ $nextShift['flat_rate'] ?? '' }}
                            </p>
                            <p class="mb-0 pb-0 f-14 w-500 text-gray">
                                {{ $nextShift && $nextShift['date'] ?  date('D F d, Y', strtotime($nextShift['date']) ) : '' }}
                                {{ $nextShift['scheduled_time'] ?? '' }} ( {{ $nextShift['timezone'] ?? '' }} ) <span
                                    class="ms-3"><img src="assets/images/location.svg" alt=""
                                        class="mb-1 me-1">{{ $nextShift['address'] ?? '' }}</span></p>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#view-brand-details"
                                class="main-btn-sm mt-3" style="width: fit-content;">View
                                Brand Details</button>
                        </div>
                    </div>

                    <div class="mt-4 ms-md-0 ms-3 ms-auto">
    @php

        // Define time zone for the user (USA for your users)

        // Parse times in correct timezone
        $givenTime = Carbon::parse($startHour, $userTimezone);
        $endHour = Carbon::parse($endHour, $userTimezone);
        $currentTime = Carbon::now($userTimezone);
    @endphp

    {{-- Debug (optional) --}}
    {{-- <pre>{{ print_r([
        'givenTime' => $givenTime->toDateTimeString(),
        'endHour' => $endHour->toDateTimeString(),
        'currentTime' => $currentTime->toDateTimeString(),
        'timezone' => $userTimezone
    ], true) }}</pre> --}}

    @if ($currentTime->greaterThan($givenTime))
        @if ($workHistory != null && $workHistory->is_confirm == 1)
            @if ($workHistory->check_in != null && $workHistory->check_out != null && $workHistory->check_out != '00:00:00')
                <button type="button" class="main-btn-sm mt-3" disabled style="width: fit-content;">Completed</button>
            @else
                @if ($workHistory->check_in != null && $workHistory->check_in != 0)
                    @if ($currentTime->greaterThan($endHour))
                        <button type="button" class="main-btn-sm mt-3 check_in_btn"
                            data-checkType="check-out" style="width: fit-content;">Check Out</button>
                    @endif
                @else
                    <button type="button" class="main-btn-sm mt-3 check_in_btn"
                        data-checkType="check-in" style="width: fit-content;">Check In</button>
                @endif
            @endif
        @else
            @empty($nextShift)
            @else
                <button type="button" class="main-btn w-100 confirmss"
                    data-rel="{{ $nextShift['id'] ?? '' }}"
                    onclick="confirmJob({{ $nextShift['id'] ?? '' }})">Confirm</button>
                <button type="button" class="main-btn-blank w-100 mt-2">Cancel</button>
            @endempty
        @endif
    @endif
</div>


            </div>

        </div>

        <h1 class="f-24 w-600 mb-2">
            Time Off Details
        </h1>
        <p class="f-14 w-500">This week : <span>{{ $totalTime ?? '00:00' }} min</span></p>
        <div class="blushed-card">
            <div class="table-responsive">
                <table class="table dashboard-table dashboard-table-md">
                    <tbody>
                        @foreach ($time_off_list as $t)
                            <tr>
                                <td scope="row">
                                    <div class="brand-number">
                                        {{ $t->job->brand }}
                                    </div>
                                </td>
                                <td>
                                    <div class="dp-div">
                                        <h4 class="mb-0 pb-0 f-14">{{ $t->job->account }}</h4>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 pb-0 f-14 w-500 text-gray">
                                        <img src="assets/images/calndr.svg" alt="">

                                        {{ date('D F d, Y', strtotime($t->job->date)) }}
                                        {{ $t->job->scheduled_time }} ({{ $t->job->timezone }})
                                    </p>
                                </td>
                                <td>
                                    <p class="mb-0 pb-0 f-14 w-500 text-gray">
                                        Total Hours :
                                        <span>{{ $t->user_working_hour }}</span>
                                    </p>
                                </td>
                                <td>
                                    <div class="dropdown ms-1 ">
                                        <button class="  p-0 border-0 bg-transparent" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15 10C16.375 10 17.5 8.875 17.5 7.5C17.5 6.125 16.375 5 15 5C13.625 5 12.5 6.125 12.5 7.5C12.5 8.875 13.625 10 15 10ZM15 12.5C13.625 12.5 12.5 13.625 12.5 15C12.5 16.375 13.625 17.5 15 17.5C16.375 17.5 17.5 16.375 17.5 15C17.5 13.625 16.375 12.5 15 12.5ZM15 20C13.625 20 12.5 21.125 12.5 22.5C12.5 23.875 13.625 25 15 25C16.375 25 17.5 23.875 17.5 22.5C17.5 21.125 16.375 20 15 20Z"
                                                    fill="#84818A" />
                                            </svg>
                                        </button>
                                        {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li class="text-center"><a class="dropdown-item" href="sign-in.html">
                                                    Menu Option</a>
                                            </li>
                                            <li class="text-center"><a class="dropdown-item" href="sign-in.html">
                                                    Menu Option</a>
                                            </li>
                                        </ul> --}}
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

<!--publish Modal -->
<div class="modal fade" id="publishModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-2 me-2">
                <button type="button" class="btn-close f-16" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <h5 class="f-22" style="color: #F34F4F; font-weight: 600; " id="exampleModalLabel">Alert</h5>
                <p class="mb-0 pb-0 f-600 text-gray f-14">You didn’t create quiz/info/recap for this brands</p>
                <hr class="my-5">
                <div class="d-flex justify-content-center mt-4">
                    <button type="button" class="sign-btn " data-bs-dismiss="modal">Create Now</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="checkInModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-2 me-2 align-items-start">
                <div>
                    <h5 class="f-22" style=" font-weight: 600; " id="checkInModalLabel">Confirm Check In
                    </h5>
                    {{-- <p class="mb-0 pb-0 f-600 text-gray f-14">Enter email with hour rate job</p> --}}
                </div>
                <button type="button" class="btn-close f-16" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 mt-3">
                <form action="{{ URL::to('/user/clock-in/submit') }}" method="post" enctype="multipart/form-data"
                    class="sign__frame-right--form">
                    @csrf <div class="row w-100 align-items-center">
                        <p class="validation"></p>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-floating  w-100 check_in_div">
                                <input type="text" value="{{ Carbon::now($userTimezone)->format('H:i:s') }}" readonly name="check_in" disabled
                                    class="form-control sign-input " id="check_in_input">
                                <label for="floatingInput" class="sign-label">Check In Time</label>
                            </div>
                            <div class="form-floating  w-100 check_out_div d-none">
                                <input type="text" value="{{ Carbon::now($userTimezone)->format('H:i:s') }}" readonly name="check_time" disabled
                                    class="form-control sign-input " id="check_out_input">
                                <label for="floatingInput" class="sign-label">Check Out Time</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-10">
                            <div class="form-floating  w-100">
                                <input type="text" class="form-control sign-input " name="flat_rate"
                                    value="{{ $nextShift['flat_rate'] ?? '' }}" id="floatingInput">
                                <label for="floatingInput" class="sign-label">Flat Rate</label>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-10">
                            <div class="form-floating  w-100">

                        <input type="file" class="form-control sign-input mt-2" id="imageInput" name="file_image" value="">

                                <label for="floatingInput" class="sign-label">Upload Image</label>
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-6 col-10">
                            <div class="col-md-12">

                                <div id="" class="container">
                                    <div class=" text-center">
                                        <input type="hidden" id="check_type" name="check_type" value="">
                                        <input type="hidden" id="base_image" name="image" value="">
                                        <input type="hidden" id="base_image" name="work_history_id"
                                            value="{{ isset($workHistory) && $workHistory != null ? $workHistory->id : '' }}">
                                        <input type="hidden" id="lat" name="lat" value="">
                                        <input type="hidden" id="lon" name="lon" value="">

                                        <div id="camera-container" style="width: 100%; height: 300px;">
                                            <label class="f-14 w-500 mb-2 text-gray">Upload Picture
                                                <span class="text-danger">*</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                {{-- <button type="button" id="captureBtn" class="btn btn-primary mt-2">Capture</button>
                                <button type="button" id="retakeBtn" class="btn btn-secondary mt-2"
                                    style="display: none;">Retake</button> --}}

                            </div>
                        </div>
                    </div>
                    <div class=" appended-row w-100 ">
                    </div>
                    <hr class="sign-line">
                    <div class="col-lg-12">
                        <div class="d-flex mt-4">
                            <button class="sign-btn check_in_confirm_btn" type="submit" disabled>Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--add memebre Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-2 me-2 align-items-start">
                <div>
                    <h5 class="f-22" style=" font-weight: 600; " id="exampleModalLabel">Add members to this job
                    </h5>
                    <p class="mb-0 pb-0 f-600 text-gray f-14">Enter email with hour rate job</p>
                </div>
                <button type="button" class="btn-close f-16" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 mt-3">
                <form action="" class="sign__frame-right--form">
                    <div class="row w-100 align-items-center">
                        <div class="col-lg-5 col-md-5 col-12">
                            <div class="form-floating mb-4 w-100">
                                <input type="email" class="form-control sign-input " id="floatingInput">
                                <label for="floatingInput" class="sign-label">Email address</label>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-10">
                            <div class="form-floating mb-4 w-100">
                                <input type="email" class="form-control sign-input " id="floatingInput">
                                <label for="floatingInput" class="sign-label">Flat rate</label>
                            </div>
                        </div>
                        <div class="col-2 ">
                            <div class="d-flex align-items-end  justify-content-md-start justify-content-center">
                                <svg class="me-2 cursor-pointer add-role" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            <button class="sign-btn">Assign</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="add-role">
        <div class="row align-items-center w-100">
            <div class="col-lg-5 col-md-5 col-12">
                <div class="form-floating mb-4 w-100">
                    <input type="email" class="form-control sign-input " id="floatingInput"
                        >
                    <label for="floatingInput" class="sign-label">Email address</label>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-10">
                <div class="form-floating mb-4 w-100">
                    <input type="email" class="form-control sign-input " id="floatingInput"
                        >
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

<!--view-brand-details Modal -->
<div class="modal fade" id="view-brand-details" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="f-18 w-600 text-center w-100 mt-1" id="exampleModalLabel">Shift details</h5>
                <button type="button" class="btn-close f-12" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="shift-detail-box">
                    <div class="d-flex justify-content-between align-items-start flex-wrap ">
                        <div class="">
                            <p class="mb-0 pb-0 f-14 w-600">{{ $nextShift['scheduled_time'] ?? '' }}
                                &nbsp;&nbsp;&nbsp;
                                <span class="text-primary"></span> Contractor
                            </p>
                            <p class="mb-0 pb-0 f-14 w-600">{{ Auth::user()->name }} &nbsp;&nbsp; </p>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <img src="assets/images/accepted.svg" alt="">
                            <p class="mb-0 pb-0 f-14 w-600">{{ $nextShift['status'] ?? '' }}</p>
                        </div>
                    </div>

                    <hr class="sign-line my-3">

                    <div class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap">
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Account:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $nextShift['account'] ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Brand:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $nextShift['brand'] ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <button style="background-color: transparent; border: none;">
                                <img src="assets/images/btn.svg" alt="">
                            </button>
                        </div>
                    </div>

                    <div
                        class="d-flex justify-content-between align-items-start  mt-3 flex-md-row flex-column flex-wrap">
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Address:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $nextShift['address'] ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Phone #:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $nextShift['phone'] ?? '' }}</p>
                        </div>
                    </div>

                    <div
                        class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap mt-3">
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Email:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $nextShift['email'] ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Contact:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $nextShift['contact'] ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Communication via:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">
                                {{ $nextShift['method_of_communication'] ?? '' }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Skus</p>
                        <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $nextShift['skus'] ?? '' }}</p>
                    </div>

                    <hr class="sign-line my-3">

                    {{-- <h1 class="f-14 w-700 mb-3">Other Shift Contractor</h1>

                        <div class="satff-div-responsive">
                            <div class="satff-div">

                                @foreach ($members as $member)
                                    @if ($member->user->id == Auth::user()->id)
                                    @else
                                        <div class="d-flex align-items-center mb-2 shift-staf-row ">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="{{ URL::to('/assets/images/Avatar.png') }}" alt=""
                                                    class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">{{ $member->user->name }}</h4>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center ">
                                                @if ($member->status == 'pending')
                                                    <img src="{{ URL::to('/assets/images/pending.svg') }}" alt=""
                                                        width="20">
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
                                                @elseif ($member->status == 'reject')
                                                    <img src="{{ URL::to('/assets/images/x-circle.svg') }}"
                                                        alt="" width="20">
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Rejected</p>
                                                @else
                                                    <img src="{{ URL::to('/assets/images/accepted.svg') }}"
                                                        alt="" width="20">
                                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div> --}}
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" id="job_lat" value="">
    <input type="hidden" id="job_lon" value="">
</div>

<!--note Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-2 me-2 align-items-start">
                <div>
                    <h5 class="f-18" style=" font-weight: 600; " id="exampleModalLabel">Shift notes</h5>
                </div>
            </div>
            <div class="modal-body pt-0">
                <form class="sign__frame-right--form">
                    <div class="">
                        <p class="mb-0 pb-0 f-14 w-600">03-22-2023 &nbsp;&nbsp;&nbsp; 6pm - 09pm &nbsp;&nbsp;&nbsp;
                            <span class="text-primary">9</span> /10 Contractor
                        </p>
                        <p class="mb-0 pb-0 f-14 w-600">Nichlos Floor &nbsp;&nbsp; </p>
                    </div>
                    <div class="form-floating mb-4 w-100">
                        <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                            style="height: 100px"></textarea>
                        <label for="floatingTextarea2 " class="sign-label">Note</label>
                    </div>

                </form>
                <div class="d-flex justify-content-end mt-4">
                    <a type="button" class="main-btn-blank ms-3 text-white bg-primary" data-bs-dismiss="modal"
                        data-bs-toggle="modal" data-bs-target="#event-details">Send</a>
                    <button type="button" class="main-btn-blank text-dark border-dark  ms-3" data-bs-dismiss="modal"
                        data-bs-toggle="modal" data-bs-target="#event-details">Close</button>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('customScripts')
<script>
    async function getLatLng(address) {
        const apiKey = @json(config('app.gmap_key')); // Replace with your Google Maps API Key
        const url =
            `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=${apiKey}`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (data.status === "OK") {
                const location = data.results[0].geometry.location;
                return {
                    latitude: location.lat,
                    longitude: location.lng
                };
            } else {
                throw new Error(`Geocoding failed: ${data.status}`);
            }
        } catch (error) {
            console.error(error);
            return null;
        }
    }

    // Example usage
    (async () => {
        const address = @json($nextShift['address'] ?? null);
        if (address != null && address != '') {

            const coordinates = await getLatLng(address);
            if (coordinates) {
                $("#job_lat").val(coordinates.latitude);
                $("#job_lon").val(coordinates.longitude);

                console.log(`Latitude: ${coordinates.latitude}, Longitude: ${coordinates.longitude}`);
            } else {
                console.log("Failed to get coordinates.");
            }
        }

    })();

    let isCaptured = false; // Track whether a picture has been captured

    // Start webcam when modal opens
    $("#checkInModal").on("show.bs.modal", function() {
        if ($("#check_type").val() == "check-out") {
            $("#captureBtn").hide();
            $("#retakeBtn").hide();
            $("#camera-container").hide();

        } else {
            isCaptured = false;
            startWebcam();
        }
    });

    // Stop webcam when modal closes
    $("#checkInModal").on("hidden.bs.modal", function() {
        Webcam.reset();
        $("#retakeBtn").hide(); // Hide retake button on close
    });

    // Function to start the webcam
    function startWebcam() {
        if ($("#check_type").val() != "check-out") {

            Webcam.set({
                width: 400,
                height: 300,
                image_format: "png",
                jpeg_quality: 90,
            });

            Webcam.attach("#camera-container");
            $("#captureBtn").show();
            $("#retakeBtn").hide();
        }
    }

    // Capture photo
    $("#captureBtn").click(function() {
        if (!isCaptured) {
            Webcam.snap(function(data_uri) {
                isCaptured = true;

                $("#camera-container").html('<img src="' + data_uri + '" class="img-fluid"/>');
                $("#base_image").val(data_uri);
                // Show the Retake button
                $("#captureBtn").hide();
                $("#retakeBtn").show();
            });
        }
    });

    $("#retakeBtn").click(function() {
        isCaptured = false;

        startWebcam();
    });
</script>

<script>
    function confirmJob(id) {
        var hr = @json($nextShift['diff'] ?? '');
        var fr = @json($nextShift['flat_rate'] ?? '');
        Swal.fire({
            title: 'Are you sure To Confirm This Job?',
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
                    url: '<?php echo url('user/shift/confirm'); ?>' + '/' + id + '?shift_hour=' + hr + '&flat_rate=' + fr,
                    method: 'GET',
                    dataType: 'json', // Set the expected data type to JSON
                    beforeSend: function() {
                        $('.error-container').html('');
                    },
                    success: function(data) {
                        console.log(data.status);
                        if (data && data.status == 100) {
                            location.reload();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle AJAX errors here

                    }
                });
            }
        })
    }

    $(".check_in_btn").click(function() {
        var type = $(this).attr('data-checkType');
        // console.log
        checkLocation(function(location) {

            var lat = location ? location.latitude : 'w';
            var lon = location ? location.longitude : 'w';

            if (lat != null && lon != null) {
                distance = checkDistance(lat, lon);
                // if (distance <= 15) {
                if (distance <= 15) {
                    $("#lat").val(lat);
                    $("#lon").val(lon);

                    // if (type == 'check-in') {

                        $(".check_in_div").removeClass('d-none');
                        $("#check_in_input").prop('disabled', false);

                    } else {

                        $(".check_in_div").addClass('d-none');
                        $(".check_out_div").removeClass('d-none');
                        $("#check_out_input").prop('disabled', false);
                    }

                    $('.validation')
                        .text('Your location is valid')
                        .css('color', 'green');
                    $('#check_type').val(type);

                    $("#checkInModal").modal("show");
                    $(".check_in_confirm_btn").prop('disabled', false);
                // } else {
                //     $('.validation')
                //         .text('You are not in Targeted Location')
                //         .css('color', 'red');
                //     $("#checkInModal").modal("show");
                //     $(".check_in_confirm_btn").prop('disabled', true);

                // }

            }
        });
    });

    function checkLocation(callback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    callback({
                        latitude,
                        longitude
                    });
                },
                function(error) {
                    console.error("Error getting location:", error.message);
                    alert("Unable to retrieve location. Please ensure location services are enabled.");
                    callback(null);
                }
            );
        } else {
            alert("Geolocation is not supported by this browser.");
            callback(null);
        }
    }

    function checkDistance(lat, lon) {
        const job_lat = parseFloat($("#job_lat").val());
        const job_lon = parseFloat($("#job_lon").val());

        // Function to calculate the distance
        const calculateDistance = (lat1, lon1, lat2, lon2) => {
            const toRadians = (degrees) => degrees * (Math.PI / 180);

            const R = 6371; // Earth's radius in kilometers

            const dLat = toRadians(lat2 - lat1);
            const dLon = toRadians(lon2 - lon1);

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRadians(lat1)) *
                Math.cos(toRadians(lat2)) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c * 1000; // Distance in meters
        };
        const distance = calculateDistance(job_lat, job_lon, lat, lon);
        return distance;
    }

    function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        // When file is successfully read
        reader.onload = () => resolve(reader.result);

        // If there's an error
        reader.onerror = (error) => reject(error);

        // Read file as Data URL (Base64)
        reader.readAsDataURL(file);
    });
}

// Example Usage:
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0]; // Get selected file
    if (file) {
        getBase64(file).then(base64 => {
            $("#base_image").val(base64);
            $("#camera-container").html('<img src="' + base64 + '" class="img-fluid"/>');

        }).catch(error => console.error(error));
    }
});

</script>
@endsection
