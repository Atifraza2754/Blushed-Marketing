@extends('layouts.master', ['module' => 'team'])

@section('title')
    Team
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

            <div class="col-lg-12">
                {{-- include alerts --}}
                @include('common.alerts')

                <h1 class="f-32 w-600 ">Team</h1>

                {{-- filters --}}
                <div class="filter-row">
                    <div class="d-flex flex-wrap">
                        <p class="mb-0 pb-0 f-16 w-700 text-blak me-3">
                            Filter:
                        </p>
                        <div class="d-flex flex-wrap">
                            <form action="{{ URL::to('/team') }}" method="get">
                                <input type="hidden" name="tab" value="all">
                                <button type="submit" class="{{ $tab == 'all' ? 'applied-filter' : '' }}">All</button>
                            </form>
                            <form action="{{ URL::to('/team') }}" method="get">
                                <input type="hidden" name="tab" value="available">
                                <button type="submit"
                                    class="{{ $tab == 'available' ? 'applied-filter' : '' }}">Available</button>
                            </form>
                            <form action="{{ URL::to('/team') }}" method="get">
                                <input type="hidden" name="tab" value="unavailable">
                                <button type="submit"
                                    class="{{ $tab == 'unavailable' ? 'applied-filter' : '' }}">Un-available</button>
                            </form>
                            <form action="{{ URL::to('/team') }}" method="get">
                                <input type="hidden" name="tab" value="terminated">
                                <button type="submit"
                                    class="{{ $tab == 'terminated' ? 'applied-filter' : '' }}">Terminated</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-4">
                <div class="table-responsive">
                    <table class="table dashboard-table dashboard-table-lg">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" name="" id="" class="form-check-input me-2">
                                </th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Email</th>
                                <th>Market</th>
                                <th>Status</th>
                                <th>City</th>
                                <th>Actions</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="parent-row">
                                    <td scope="row">
                                        <p class="mb-0 pb-0">
                                            <input type="checkbox" name="" id=""
                                                class="form-check-input me-2">
                                        </p>
                                    </td>
                                    <td>
                                        <div class="dp-div">
                                            <img src="assets/images/Avatar.png" alt="user image" class="dp-img">
                                            <div class="ms-2">
                                                <h4 class="mb-0 pb-0 f-14">{{ $user->name }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/phone.svg" alt="user mobile no">
                                            <p class="mb-0 pb-0 ms-2">{{ $user->country_code }} {{ $user->mobile_no }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/mail.svg" alt="user email">
                                            <p class="mb-0 pb-0 ms-2">{{ $user->email }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <!-- please make sure to add 2 tags in a div -->
                                            <div class="">
                                                <div class="designer mx-1 my-1">Designer</div>
                                                <div class="designer mx-1 my-1">Designer</div>
                                            </div>
                                            <!-- please make sure to add 2 tags in a div -->
                                            <div>
                                                <div class="researcher m-1 my-1">Researcher</div>
                                                <div class="researcher m-1 my-1">Researcher</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($user->deleted_at)
                                            <div class="status-terminated">Terminated</div>
                                        @else
                                            <div class="status-available">Available</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 pb-0">{{ $user->city ?? 'Not Specified' }}</p>
                                        </div>
                                    </td>
                                    <td class="child-target">
                                        <div class="d-flex  justify-content-center">
                                            <div class="edit table-action cursor-pointer">
                                                <img src="assets/images/plus-open.svg" alt=""
                                                    style="display: inline-block;">
                                                <img src="assets/images/close.svg" alt="" style="display: none;">
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-menu  table-action cursor-pointer">

                                            <div class="dropdown ">
                                                <div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="assets/images/dots.svg" alt="">
                                                </div>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#flat-rate" data-user-id="{{ $user->id }}"
                                                            class="dropdown-item f-14 mb-2">
                                                            Set Flat Rate
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#notify" data-user-id="{{ $user->id }}"
                                                            class="dropdown-item f-14 mb-2">
                                                            Send Notify
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#delete-member"
                                                            data-user-id="{{ $user->id }}"
                                                            class="dropdown-item f-14 mb-2" style="color: #F00;"
                                                            href="">
                                                            Delete Member
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="child-row">
                                <td colspan="9">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-start">
                                            <div>
                                                <img src="assets/images/calendar.svg" alt="">

                                            </div>

                                            <div class="ms-3">
                                                <p class="f-16 w-600 text-primary mb-0 pb-0 mt-2">Shift
                                                    Ongoing</p>
                                                <h1 class="f-24 w-600 mb-2">
                                                    Shift Title
                                                </h1>
                                                <p class="mb-0 pb-0 f-14 w-500 text-gray">0.00 Hrs / $0.00
                                                </p>
                                                <p class="mb-0 pb-0 f-14 w-500 text-gray">Sun May 21, 2023
                                                    3:30pm – 4pm (PKT)</p>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#view-brand-details" class="sign-btn"
                                                style="width: fit-content;">View
                                                Brand Details</button>
                                        </div>
                                    </div>
                                    <p class="f-16 w-600 text-primary mb-0 pb-0 mt-4 ms-3">Shift
                                        Ongoing</p>
                                    <div class="d-flex mt-3 ms-3">

                                        <!-- approved -->
                                        <div class="accepted-shift me-3">
                                            <hr class="accepted-shift-line">
                                            <p class="mb-0 pb-0 f-12 w-500" style="color: #20C9AC;">8 - 22 -
                                                2023</p>
                                            <p class="mb-0 pb-0 f-12 w-500" style="color: #20C9AC;">7 -
                                                8.30am</p>
                                            <h1 class="f-14 w-600 text-black mt-2">
                                                Review data<br>
                                                from Q1
                                            </h1>
                                            <div class="accepted-status-tag mt-3 mb-2">
                                                Accepted
                                            </div>
                                        </div>
                                        <!-- pending -->
                                        <div class="pending-shift me-3">
                                            <hr class="pending-shift-line">
                                            <p class="mb-0 pb-0 f-12 w-500" style="color: #FC3400;">8 - 22 -
                                                2023</p>
                                            <p class="mb-0 pb-0 f-12 w-500" style="color: #FC3400;">7 -
                                                8.30am</p>
                                            <h1 class="f-14 w-600 text-black mt-2">
                                                Call data<br>
                                                recapitulation
                                            </h1>
                                            <div class="pending-status-tag mt-3 mb-2">
                                                Pending
                                            </div>
                                        </div>
                                        <!-- blue pending -->
                                        <div class="blue-pending-shift me-3">
                                            <hr class="blue-pending-shift-line">
                                            <p class="mb-0 pb-0 f-12 w-500" style="color: #5542F6;">8 - 22 -
                                                2023</p>
                                            <p class="mb-0 pb-0 f-12 w-500" style="color: #5542F6;">7 -
                                                8.30am</p>
                                            <h1 class="f-14 w-600 text-black mt-2">
                                                Review data<br>
                                                from Q1
                                            </h1>
                                            <div class="blue-pending-status-tag mt-3 mb-2">
                                                Accepted
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr class="parent-row">
                                <td scope="row">
                                    <p class="mb-0 pb-0"><input type="checkbox" name="" id=""
                                            class="form-check-input me-2"> </p>
                                </td>
                                <td>
                                    <div class="dp-div">
                                        <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                        <div class="ms-2">
                                            <h4 class="mb-0 pb-0 f-14">Maria Roselia</h4>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/phone.svg" alt="">
                                        <p class="mb-0 pb-0 ms-2">702-525-0141</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/mail.svg" alt="">
                                        <p class="mb-0 pb-0 ms-2">abc@gmail.com</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="designer mx-1">Designer</div>
                                        <div class="researcher m-1">Researcher</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="status-on-shift">On Shift</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 pb-0">Nwyk</p>
                                    </div>
                                </td>
                                <td class="child-target">
                                    <div class="d-flex  justify-content-center">
                                        <div class="edit table-action cursor-pointer">
                                            <img src="assets/images/plus-open.svg" alt=""
                                                style="display: inline-block;">
                                            <img src="assets/images/close.svg" alt="" style="display: none;">
                                        </div>

                                    </div>
                                </td>
                                <td>


                                    <div class="table-menu  table-action cursor-pointer">

                                        <div class="dropdown ">
                                            <div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="assets/images/dots.svg" alt="">
                                            </div>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#flat-rate" class="dropdown-item f-14 mb-2">
                                                        Set Flat Rate
                                                    </button>
                                                </li>
                                                <li><button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#notify" class="dropdown-item f-14 mb-2">
                                                        Send Notify
                                                    </button>
                                                </li>
                                                <li><button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#delete-member" class="dropdown-item f-14 mb-2"
                                                        style="color: #F00;" href="">
                                                        Delete Member
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="child-row">
                                <td colspan="9">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h1 class="f-24 w-500 text-gray m-0 p-0">No Shift</h1>
                                    </div>
                                </td>
                            </tr>

                            <tr class="parent-row">
                                <td scope="row">
                                    <p class="mb-0 pb-0"><input type="checkbox" name="" id=""
                                            class="form-check-input me-2"> </p>
                                </td>
                                <td>
                                    <div class="dp-div">
                                        <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                        <div class="ms-2">
                                            <h4 class="mb-0 pb-0 f-14">Maria Roselia</h4>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/phone.svg" alt="">
                                        <p class="mb-0 pb-0 ms-2">702-525-0141</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/mail.svg" alt="">
                                        <p class="mb-0 pb-0 ms-2">abc@gmail.com</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="designer mx-1">Designer</div>
                                        <div class="researcher m-1">Researcher</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="status-terminated">Terminated</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 pb-0">Nwyk</p>
                                    </div>
                                </td>
                                <td class="child-target">
                                    <div class="d-flex  justify-content-center">
                                        <div class="edit table-action cursor-pointer">
                                            <img src="assets/images/plus-open.svg" alt=""
                                                style="display: inline-block;">
                                            <img src="assets/images/close.svg" alt="" style="display: none;">
                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <div class="table-menu  table-action cursor-pointer">
                                        <div class="dropdown ">
                                            <div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="assets/images/dots.svg" alt="">
                                            </div>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#flat-rate" data-user-id="{{ $user->id }}"
                                                        class="dropdown-item f-14 mb-2">
                                                        Set Flat Rate
                                                    </button>
                                                </li>
                                                <li><button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#notify" class="dropdown-item f-14 mb-2">
                                                        Send Notify
                                                    </button>
                                                </li>
                                                <li><button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#delete-member" class="dropdown-item f-14 mb-2"
                                                        style="color: #F00;" href="">
                                                        Delete Member
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="child-row">
                                <td colspan="9">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h1 class="f-24 w-500  m-0 p-0" style="color: #F00;">Terminated</h1>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>



            </div>
        </div>

        <div class="overlay"></div>



        {{-- notify Modal --}}
        <div class="modal fade" id="notify" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header mt-1">
                        <h5 class="f-18 w-600" id="exampleModalLabel">Notify user</h5>
                    </div>
                    <div class="modal-body pt-0">

                        <form class="sign__frame-right--form" action="{{ URL::to('/team/notify') }}" method="POST">
                            @csrf

                            <input type="text" name="user_id" value="" class="user_id">

                            <div class="form-floating w-100 mb-4">
                                <select class="form-select w-100 sign-input px-2 " id="floatingSelect"
                                    aria-label="Floating label select example">
                                    <option value="1">Alaxander</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="floatingSelect sign-label">Client Name</label>
                            </div>

                            <div class="form-floating mb-4 w-100">
                                <div class="form-floating">
                                    <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                                        style="height: 100px"></textarea>
                                    <label for="floatingTextarea2 sign-label">Feedback</label>
                                </div>
                            </div>
                        </form>

                        <div class="d-flex justify-content-md-end justify-content-center flex-wrap mt-4">
                            <button type="button" class="main-btn-blank text-white bg-primary "
                                data-bs-dismiss="modal">Done</button>
                            <button type="button" class="main-btn-blank ms-3" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- flat-rate Modal --}}
        <div class="modal fade" id="flat-rate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header mt-1">
                        <h5 class="f-18 w-600" id="exampleModalLabel">Set Shift Flat Rate</h5>
                    </div>
                    <div class="modal-body pt-0">
                        <form class="sign__frame-right--form" action="{{ URL::to('/team/flat-rate') }}" method="POST">
                            @csrf

                            <input type="text" class="user_id" name="user_id" value="">

                            <div class="form-floating mb-4 w-100">
                                <div class="form-floating">
                                    <input class="form-control sign-input" placeholder="Client Name" id="floatinput"
                                        name="name" value="">
                                    <label for="floatinput sign-label">Name</label>
                                </div>
                            </div>

                            <div class="form-floating mb-4 w-100">
                                <div class="form-floating">
                                    <input class="form-control sign-input" placeholder="" id="floatinginput"
                                        name="flat_rate" required>
                                    <label for="floatinginput sign-label">Rate <sup><strong>*</strong></sup></label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-md-end justify-content-center flex-wrap mt-4">
                                <button type="submit" class="main-btn-blank text-white bg-primary">Done</button>
                                <button type="button" class="main-btn-blank ms-3" data-bs-dismiss="modal">Close</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- Delete Member Modal --}}
        <div class="modal fade" id="delete-member" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header mt-1 pb-0">
                        <h5 class="f-18 w-600" id="exampleModalLabel" style="color: #F00;">Delete user</h5>
                        <button type="button" class="btn-close f-12 text-primary" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <p class="f-14 w-500 text-gray">
                            Delete user will not access your software again.
                        </p>

                        <form action="{{ URL::to('/team/terminate') }}" method="post">
                            @csrf

                            <input type="text" class="user_id" name="user_id" value="">

                            <div class="d-flex justify-content-center mt-4 pt-3">
                                <button type="button" class="main-btn-blank bg-primary text-white"
                                    data-bs-dismiss="modal">NO</button>
                                <button type="submit" class="main-btn-blank ms-3" data-bs-dismiss="modal">Yes</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>


        <!--view-brand-details Modal -->
        <div class="modal fade" id="view-brand-details" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="f-18 w-600 text-center w-100 mt-1" id="exampleModalLabel">Shift details</h5>
                        <button type="button" class="btn-close f-12" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="shift-detail-box">
                            <div class="d-flex justify-content-between align-items-start flex-wrap ">
                                <div class="">
                                    <p class="mb-0 pb-0 f-14 w-600">6pm - 09pm &nbsp;&nbsp;&nbsp; <span
                                            class="text-primary">9</span> /10 Contractor</p>
                                    <p class="mb-0 pb-0 f-14 w-600">Nichlos Floor &nbsp;&nbsp; (BA - Nash)</p>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <img src="assets/images/accepted.svg" alt="">
                                    <p class="mb-0 pb-0 f-14 w-600">Accepted</p>
                                </div>
                            </div>

                            <hr class="sign-line my-3">

                            <div
                                class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap">
                                <div class="mt-2">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Account:</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">Green Meadows</p>
                                </div>
                                <div class="mt-2">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Brand:</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">Junction 35</p>
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
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">1147 Hunters Crossing, Alcoa, TN 37701</p>
                                </div>
                                <div class="mt-2">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Phone #:</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">541 533 2551</p>
                                </div>
                            </div>

                            <div
                                class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap mt-3">
                                <div class="mt-2">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Email:</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca@gmai.com</p>
                                </div>
                                <div class="mt-2">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Contact:</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca</p>
                                </div>
                                <div class="mt-2">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Communication via:</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">call</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="mb-0 pb-0 f-14 w-600 text-gray">Skus</p>
                                <p class="mb-0 pb-0 f-14 w-600 text-black">Bam , Straight Bourbon</p>
                            </div>

                            <hr class="sign-line my-3">

                            <h1 class="f-14 w-700 mb-3">Other Shift Contractor</h1>
                            <div class="d-flex align-items-center mb-2">
                                <div class="dp-div" style="min-width: 150px;">
                                    <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                    <div class="ms-2">
                                        <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ms-3">
                                    <img src="assets/images/accepted.svg" alt="" width="20">
                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <div class="dp-div" style="min-width: 150px;">
                                    <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                    <div class="ms-2">
                                        <h4 class="mb-0 pb-0 ">Abhoy Latif</h4>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ms-3">
                                    <img src="assets/images/pending.svg" alt="" width="20">
                                    <p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script>
        // Add click event listeners to toggle child rows when clicking on department
        const departmentCells = document.querySelectorAll('.child-target');

        departmentCells.forEach(departmentCell => {
            departmentCell.addEventListener('click', () => {
                const childRow = departmentCell.parentElement.nextElementSibling;

                if (childRow.style.display === 'none' || childRow.style.display === '') {
                    childRow.style.display = 'table-row';

                    // Show the close.svg image and hide the plus-open.svg image
                    const editImages = departmentCell.querySelectorAll('.edit img');
                    editImages[0].style.display = 'none';
                    editImages[1].style.display = 'inline-block';
                } else {
                    childRow.style.display = 'none';

                    // Show the plus-open.svg image and hide the close.svg image
                    const editImages = departmentCell.querySelectorAll('.edit img');
                    editImages[0].style.display = 'inline-block';
                    editImages[1].style.display = 'none';
                }

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.dropdown-item').click(function() {
                var userId = $(this).data('user-id');
                $(".user_id").val(userId);
            });
        });
    </script>
@endsection
