@extends('user.layouts.master', ['module' => 'dashboard'])
@section('title')
    Dashboard
@endsection

@section('customStyles')
    <style>
        .calendar-sidebar {
            width: 180px;
        }

        .calendar-inner {
            padding: 50px 10px 70px 10px;
            max-width: 100%;
            margin-left: 0;
        }

        .sidebar-hide .calendar-inner,
        .event-hide .calendar-inner {
            max-width: 100%;
        }

        .calendar-inner::after {
            content: "";
            opacity: 1;
        }

        .sidebar-hide.event-hide .calendar-inner::after {
            content: none;
            opacity: 0;
        }

        .event-indicator {
            -webkit-transform: translate(-50%, calc(-100% + -3px));
            -ms-transform: translate(-50%, calc(-100% + -3px));
            transform: translate(-50%, calc(-100% + -3px));
        }

        .event-indicator>.type-bullet {
            padding: 0 1px 3px 1px;
        }

        .calendar-events {
            width: 48%;
            padding: 70px 20px 60px 20px;
            -webkit-box-shadow: -5px 0 18px -3px rgba(135, 115, 193, 0.5);
            box-shadow: -5px 0 18px -3px rgba(135, 115, 193, 0.5);
            z-index: 1;
        }

        .event-hide .calendar-events {
            -webkit-transform: translateX(100%);
            -ms-transform: translateX(100%);
            transform: translateX(100%);
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        #eventListToggler {
            right: 48%;
            -webkit-transform: translateX(100%);
            -ms-transform: translateX(100%);
            transform: translateX(100%);
        }

        .event-hide #eventListToggler {
            -webkit-transform: translateX(0);
            -ms-transform: translateX(0);
            transform: translateX(0);
        }

        .calendar-events>.event-list {
            margin-top: 20px;
        }

        .calendar-sidebar>.calendar-year>button.icon-button {
            width: 16px;
            height: 16px;
        }

        .calendar-sidebar>.calendar-year>button.icon-button>span {
            border-right-width: 2px;
            border-bottom-width: 2px;
        }

        .calendar-sidebar>.calendar-year>p {
            font-size: 22px;
        }

        .calendar-sidebar>.month-list>.calendar-months>li {
            padding: 6px 26px;
        }

        .calendar-events>.event-header>p {
            margin: 0;
        }

        .event-container>.event-info>p.event-title {
            font-size: 20px;
        }

        .event-container>.event-info>p.event-desc {
            font-size: 12px;
        }

        .calendar-sidebar {
            width: 100%;
        }

        .sidebar-hide .calendar-sidebar {
            height: 43px;
        }

        .sidebar-hide .calendar-sidebar {
            -webkit-transform: translateX(0);
            -ms-transform: translateX(0);
            transform: translateX(0);
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .calendar-sidebar>.calendar-year {
            position: relative;
            padding: 10px 20px;
            text-align: center;
            background-color: #8773c1;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .calendar-sidebar>.calendar-year>button.icon-button {
            width: 14px;
            height: 14px;
        }

        .calendar-sidebar>.calendar-year>button.icon-button>span {
            border-right-width: 3px;
            border-bottom-width: 3px;
        }

        .calendar-sidebar>.calendar-year>p {
            font-size: 18px;
            margin: 0 10px;
        }

        .calendar-sidebar>.month-list {
            position: relative;
            width: 100%;
            height: calc(100% - 43px);
            overflow-y: auto;
            background-color: #8773c1;
            -webkit-transform: translateY(0);
            -ms-transform: translateY(0);
            transform: translateY(0);
            z-index: -1;
        }

        .sidebar-hide .calendar-sidebar>.month-list {
            -webkit-transform: translateY(-100%);
            -ms-transform: translateY(-100%);
            transform: translateY(-100%);
        }

        .calendar-sidebar>.month-list>.calendar-months {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            list-style-type: none;
            margin: 0;
            padding: 0;
            padding: 10px;
        }

        .calendar-sidebar>.month-list>.calendar-months::after {
            content: "";
            clear: both;
            display: table;
        }

        .calendar-sidebar>.month-list>.calendar-months>li {
            padding: 10px 20px;
            font-size: 20px;
        }

        .calendar-sidebar>span#sidebarToggler {
            -webkit-transform: translate(0, 0);
            -ms-transform: translate(0, 0);
            transform: translate(0, 0);
            top: 0;
            bottom: unset;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        th[colspan="7"]::after {
            bottom: 0;
        }

        th[colspan="7"] {
            font-size: 20px
        }

        .calendar-inner {
            margin-left: 0;
            padding: 53px 0 40px 0;
            float: unset;
        }

        .calendar-inner::after {
            content: none;
            opacity: 0;
        }

        .sidebar-hide .calendar-inner,
        .event-hide .calendar-inner,
        .calendar-inner {
            max-width: 100%;
        }

        .calendar-sidebar>span#sidebarToggler,
        #eventListToggler {
            width: 40px;
            height: 40px;
        }

        button.icon-button>span.chevron-arrow-right {
            border-right-width: 4px;
            border-bottom-width: 4px;
            width: 18px;
            height: 18px;
            -webkit-transform: translateX(-3px) rotate(-45deg);
            -ms-transform: translateX(-3px) rotate(-45deg);
            transform: translateX(-3px) rotate(-45deg);
        }

        button.icon-button>span.bars,
        button.icon-button>span.bars::before,
        button.icon-button>span.bars::after {
            height: 4px;
        }

        button.icon-button>span.bars::before {
            top: -8px;
        }

        button.icon-button>span.bars::after {
            bottom: -8px;
        }

        tr.calendar-header .calendar-header-day {
            padding: 0;
        }

        tr.calendar-body .calendar-day {
            padding: 8px 0;
        }

        tr.calendar-body .calendar-day .day {
            padding: 10px;
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .event-indicator {
            -webkit-transform: translate(-50%, calc(-100% + -3px));
            -ms-transform: translate(-50%, calc(-100% + -3px));
            transform: translate(-50%, calc(-100% + -3px));
        }

        .event-indicator>.type-bullet {
            padding: 1px;
        }

        .event-indicator>.type-bullet>div {
            width: 6px;
            height: 6px;
        }

        .event-indicator {
            -webkit-transform: translate(-50%, 0);
            -ms-transform: translate(-50%, 0);
            transform: translate(-50%, 0);
        }

        tr.calendar-body .calendar-day .day.calendar-today .event-indicator,
        tr.calendar-body .calendar-day .day.calendar-active .event-indicator {
            -webkit-transform: translate(-50%, 3px);
            -ms-transform: translate(-50%, 3px);
            transform: translate(-50%, 3px);
        }

        .calendar-events {
            position: relative;
            padding: 20px 15px;
            width: 100%;
            height: 185px;
            -webkit-box-shadow: none;
            box-shadow: none;
            overflow-y: auto;
            z-index: 0;
        }

        .event-hide .calendar-events {
            -webkit-transform: translateX(0);
            -ms-transform: translateX(0);
            transform: translateX(0);
            padding: 0 15px;
            height: 0;
        }

        .calendar-events>.event-header>p {
            font-size: 20px;
        }

        .event-list>.event-empty {
            padding: 10px;
        }

        .event-container::before {
            transform: translate(21.5px, 25px);
        }

        .event-container:last-child.event-container::before {
            height: 22.5px;
            transform: translate(21.5px, 0);
        }

        .event-container>.event-icon {
            width: 45px;
            height: 45px;
        }

        .event-container>.event-icon::before {
            left: 21px;
        }

        .event-container:last-child>.event-icon::before {
            height: 50%;
        }

        .event-container>.event-info {
            width: calc(100% - 45px);
        }

        .event-hide #eventListToggler,
        #eventListToggler {
            top: calc(100% - 185px);
            right: 0;
            -webkit-transform: translate(0, -100%);
            -ms-transform: translate(0, -100%);
            transform: translate(0, -100%);
        }

        .event-hide #eventListToggler {
            top: 100%;
        }

        #eventListToggler button.icon-button>span.chevron-arrow-right {
            position: relative;
            display: inline-block;
            -webkit-transform: translate(0, -3px) rotate(45deg);
            -ms-transform: translate(0, -3px) rotate(45deg);
            transform: translate(0, -3px) rotate(45deg);
        }

        .event-tooltip {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 100;
            max-width: 150px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .calendar-inner .calendar-table {

            font-size: 14px;
        }

        tr.calendar-body .calendar-day .day {
            padding: 2px;
            width: 35px;
            height: 35px;
            font-size: 14px;
        }

        .evo-calendar {
            box-shadow: none;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-lg-0 mt-3">
                    <div
                        class="d-flex justify-content-between align-items-md-center flex-md-row flex-column align-items-start">
                        <div>
                            <h1 class="f-36 w-600 text-black">Good morning, {{ Auth::user()->name }}</h1>
                            {{-- <p class="mb-0 pb-0 f-14 w-500 text-gray">Here’s what’s going on with your team
                                Designspace</p> --}}
                        </div>

                        <div class="mt-md-0 mt-3 text-end ms-auto">
                            <h3 class="f-20 w-500 text-gray text-end">
                                {{ date('l') }}
                            </h3>
                            <p class="f-14 w-600 text-black mb-0 pb-0">{{ date('Y M d') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 mt-4">
                    <div class="blushed-card-sm d-flex flex-column align-content-between bg-primary">
                        <p class="f-14 w-500 text-white">
                            Next shift
                        </p>
                        <h2 class="f-32 w-600 text-white text-center my-3">
                            {{ date('d/y') }} - {{ date('D') }}
                        </h2>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 pb-0 w-400 f-14 ms-1 text-white">
                                    {{ $nextShift['diff'] ?? '-' }} Hrs / ${{ $nextShift['flat_rate'] ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mt-4">
                    <div class="blushed-card-sm d-flex flex-column align-content-between">
                        <p class="f-14 w-500 text-blck">
                            Trainings Due
                        </p>
                        <h2 class="f-32 w-600 text-black  my-3 no_of_user_training">
                            0
                        </h2>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="assets/images/call_made.png" alt="" height="18px">
                                <p class="mb-0 pb-0 w-400 f-14 ">
                                </p>
                            </div>
                            <div class="">
                                <select class="form-select  dropdown-menu-card" name="" onchange="userTrainingCount()"
                                    id="user_training">
                                    <option value="1">Weekly</option>
                                    <option value="2">Monthly</option>
                                    <option value="3">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mt-lg-4 mt-3">
                    <div class="blushed-card-sm d-flex flex-column align-content-between">
                        <p class="f-14 w-500 text-blck">
                            Recaps due
                        </p>
                        <h2 class="f-32 w-600 text-black  my-3 no_of_user_recap">
                            0
                        </h2>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="assets/images/call_made.png" alt="" height="18px">
                                <p class="mb-0 pb-0 w-400 f-14 ">
                                </p>
                            </div>
                            <div class="">
                                <select class="form-select  dropdown-menu-card" name="" onchange="userRecapCount()"
                                    id="user_recap">
                                    <option value="1">Weekly</option>
                                    <option value="2">Monthly</option>
                                    <option value="3">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- paused -->
                <!-- <div class="col-lg-5 mt-lg-4 mt-3">
                        <div class="blushed-card-sm d-flex  justify-content-between flex-md-row flex-column">
                            <div class="d-flex flex-column align-content-between">
                                <h3 class="text-gray f-20 w-500">Friday</h3>
                                <p class="f-14 w-500 text-blck">
                                    26 February 2021
                                </p>
                                <h2 class="f-32 w-600 text-black mt-4" style="text-wrap: nowrap;">
                                    12:20 AM
                                </h2>
                            </div>
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <img src="assets/images/lock.svg" alt="" class="mb-2">
                                <p class="text-center f-14 w-500 text-danger">Clock lock due to you’re out of reach
                                    the event place</p>
                                <img src="assets/images/refresh2.svg" alt="">
                            </div>
                        </div>
                        </div> -->
                <!-- active -->
                <div class="col-lg-3 mt-lg-4 mt-3">
                    <div class="blushed-card-sm d-flex  justify-content-between flex-md-row flex-column">
                        <div class="d-flex flex-column align-content-between">
                            <h3 class="text-gray f-20 w-500">{{ date('D') }}</h3>
                            <p class="f-14 w-500 text-blck">
                                {{ date('jS F Y') }}
                            </p>
                            <h2 class="f-32 w-600 text-black mt-4" style="text-wrap: nowrap;">
                                {{ date('H:i a') }}
                            </h2>
                        </div>
                        {{-- <div class="d-flex justify-content-center align-items-center flex-column mx-auto">
                            <img src="assets/images/lock-active.svg" alt="" class="mb-2">
                            <p class="f-14 w-500 text-blck">
                                00:00 hr
                            </p>
                            <button class="f-14 w-500 text-primary bg-transparent p-0 border-0">
                                Starts Now
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="row mb-4">

                <div class="col-lg-6 mt-lg-4 mt-3">
                    <div class="blushed-card view-more-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="f-16 w-600 mb-0 pb-0">Recaps</h3>
                            <div class="d-flex align-items-center">
                                <button class="bg-transparent p-0 border-0"> <img src="assets/images/refresh.svg" alt=""
                                        class="cursor-pointer"></button>
                                <div class="dropdown ">
                                    <div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="assets/images/dots.svg" alt="">
                                    </div>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item f-14 w-500" href="">
                                                Link Name
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item f-14 w-500" href="">
                                                Link Name
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @forelse ($userRecaps as $u)

                            <div class="d-flex justify-content-between align-items-center mb-2  hover-primary">
                                <div class="dp-div align-items-start">
                                    <div class="icon-div--icon" style="background-color: #C92085;">
                                        <svg width="11" height="12" viewBox="0 0 11 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.42839 6.64176H5.51172V9.55843H8.42839V6.64176V6.64176ZM7.84505 0.225098V1.39176H3.17839V0.225098H2.01172V1.39176H1.42839C0.780885 1.39176 0.267552 1.91676 0.267552 2.55843L0.261719 10.7251C0.261719 11.3668 0.780885 11.8918 1.42839 11.8918H9.59505C10.2367 11.8918 10.7617 11.3668 10.7617 10.7251V2.55843C10.7617 1.91676 10.2367 1.39176 9.59505 1.39176H9.01172V0.225098H7.84505V0.225098ZM9.59505 10.7251H1.42839V4.30843H9.59505V10.7251V10.7251Z"
                                                fill="white" />
                                        </svg>

                                    </div>
                                    <div class="ms-2">
                                        <h4 class="f-14 w-500 mb-0 pb-0 ">{{ $u->title }}</h4>
                                        <p class="mb-0 pb-0 ">{{ $u->event_date }}
                                    </div>
                                </div>
                                <div class="">
                                    {{-- <p class="mb-0 pb-0 f-12 w-600 text-black">+ $250.00</p> --}}
                                    <p class="mb-0 pb-0 f-12 w-600 text-sky" style="color: #C92085;">{{ $u->status }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="ms-2">
                                {{-- <h4 class="f-14 w-500 mb-0 pb-0 ">No Recap Found !</h4> --}}
                                <p class="mb-0 pb-0 ">No Recap Found !</p>
                            </div>
                        @endforelse

                        <div class="text-center view-more">
                            <!-- view all -->
                            <hr class="sign-line">
                            <a href="{{ url('/user/recaps') }}"
                                class="f-14 w-500 text-gray text-center p-0 m-0 no-decoration-sky">View
                                All Recaps
                                <svg class="ms-2" width="16" height="17" viewBox="0 0 16 17" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.00008 3.37244L7.06008 4.31244L10.7801 8.0391H2.66675V9.37244H10.7801L7.06008 13.0991L8.00008 14.0391L13.3334 8.70577L8.00008 3.37244Z"
                                        fill="#84818A" />
                                </svg>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-4 mt-3">
                    <div class="blushed-card view-more-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="f-16 w-600 mb-0 pb-0">Open Shifts</h3>
                            <div class="d-flex align-items-center">
                                <button class="bg-transparent p-0 border-0"> <img src="assets/images/refresh.svg" alt=""
                                        class="cursor-pointer"></button>
                                <div class="dropdown ">
                                    <div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="assets/images/dots.svg" alt="">
                                    </div>
                                    {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item f-14 w-500" href="">
                                                Link Name
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item f-14 w-500" href="">
                                                Link Name
                                            </a>
                                        </li>
                                    </ul> --}}
                                </div>
                            </div>
                        </div>
                        @foreach($open_shifts as $o)
                            <div class="d-flex justify-content-between align-items-center mb-2  hover-sky">
                                <div class="dp-div align-items-start">
                                    <div class="icon-div--icon">
                                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.91667 7.64215H7V10.5588H9.91667V7.64215V7.64215ZM9.33333 1.22549V2.39215H4.66667V1.22549H3.5V2.39215H2.91667C2.26917 2.39215 1.75583 2.91715 1.75583 3.55882L1.75 11.7255C1.75 12.3672 2.26917 12.8922 2.91667 12.8922H11.0833C11.725 12.8922 12.25 12.3672 12.25 11.7255V3.55882C12.25 2.91715 11.725 2.39215 11.0833 2.39215H10.5V1.22549H9.33333V1.22549ZM11.0833 11.7255H2.91667V5.30882H11.0833V11.7255V11.7255Z"
                                                fill="white" />
                                        </svg>
                                    </div>
                                    <div class="ms-2">
                                        <h4 class="f-14 w-500 mb-0 pb-0 ">{{ $o->account }}</h4>

                                        <p class="mb-0 pb-0 ">{{ $o->date }}
                                    </div>
                                </div>
                                <div class="">
                                    <p class="mb-0 pb-0 f-12 w-600 text-black">+ $250.00</p>
                                    <p class="mb-0 pb-0 f-12 w-600 text-sky">{{ $o->status }}</p>
                                </div>
                            </div>
                            @endforeach
                        {{-- @empty
                            <div class="ms-2">
                                {{-- <h4 class="f-14 w-500 mb-0 pb-0 ">No Recap Found !</h4> --}}
                                {{-- <p class="mb-0 pb-0 ">No Recap Found !</p>
                            </div>
                        @endforelse --}}
                        <div class="text-center view-more">
                            <!-- view all -->
                            <hr class="sign-line">
                            <a href="{{ url('/user/shifts') }}"
                                class="f-14 w-500 text-gray text-center p-0 m-0 no-decoration-sky">View
                                All Schedule
                                <svg class="ms-2" width="16" height="17" viewBox="0 0 16 17" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.00008 3.37244L7.06008 4.31244L10.7801 8.0391H2.66675V9.37244H10.7801L7.06008 13.0991L8.00008 14.0391L13.3334 8.70577L8.00008 3.37244Z"
                                        fill="#84818A" />
                                </svg>
                            </a>

                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-4 mt-lg-4 mt-3 pt-1">
                    <div class="blushed-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="f-16 w-600 mb-0 pb-0">Open Shifts</h3>
                        </div>

                        <!-- Calendar dashboard container -->
                        <div class="">
                            <div id="calendar-dashboard" class=" small-calendar evo-calendar  sidebar-hide event-hide">
                            </div>

                        </div>

                        <!-- Centered content with button -->
                        {{-- <div class="text-center">
                            <hr class="sign-line">
                            <div class="w-100">
                                <button class="sign-btn w-100">+ Add Shift</button>
                            </div>
                        </div> --}}
                    </div>
                {{-- </div>  --}}
                {{-- <div class="col-lg-4 mt-lg-4 mt-3 pt-1">
                    <div class="blushed-card ">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="f-16 w-600 mb-0 pb-0">Open Shifts</h3>
                        </div>

                        <!-- // Set up your HTML markup -->
                        <div id="calendar-dashboard"></div>

                        <div class="text-center">
                            <!-- view all -->
                            <hr class="sign-line">
                            <!-- <a href="" class="f-14 w-500 text-gray text-center p-0 m-0 ">View All Shifts
                                    <svg class="ms-2" width="16" height="17" viewBox="0 0 16 17" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.00008 3.37244L7.06008 4.31244L10.7801 8.0391H2.66675V9.37244H10.7801L7.06008 13.0991L8.00008 14.0391L13.3334 8.70577L8.00008 3.37244Z"
                                            fill="#84818A" />
                                    </svg>
                                    </a> -->

                            <!-- <div class="w-100">
                                    <button class="sign-btn w-100">+ Add Shift</button>
                                    </div> -->

                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

@endsection

@section('customScripts')
    <script>
        function userTrainingCount() {

            let value = $("#user_training").val();
            // alert(deviceId);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({

                type: "GET",
                url: "/user/user_training",
                data: {
                    value: value,
                },
                success: function (response) {
                    console.log(response);
                    // return;

                    let status = response.status;

                    if (status == 200) {
                        var count = response.count;
                        $(".no_of_user_training").text(count);

                    } else {
                        console.log("Something went wrong!!!");
                    }
                },
            });

        }

        function userRecapCount() {

            let value = $("#user_recap").val();
            // alert(deviceId);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({

                type: "GET",
                url: "/user/user_recap",
                data: {
                    value: value,
                },
                success: function (response) {
                    console.log(response);
                    // return;

                    let status = response.status;

                    if (status == 200) {
                        var count = response.count;
                        $(".no_of_user_recap").text(count);

                    } else {
                        console.log("Something went wrong!!!");
                    }
                },
            });

        }
        userTrainingCount();
        userRecapCount();
    </script>

    <script>
        const calendarEvents = @json($jobs ?? []);
        console.log(calendarEvents);
        $('#calendar-dashboard').evoCalendar({
            calendarEvents: calendarEvents,
            theme: 'midnight-blue'
        });

        // Add hover functionality to show event details
        $(document).ready(function () {
            const eventsMap = {}; // Map to store events by date for quick lookup

            // Populate events map
            calendarEvents.forEach(event => {
                if (!eventsMap[event.date]) {
                    eventsMap[event.date] = [];
                }
                eventsMap[event.date].push(event); // Add event to the list for that date
            });

            // Hover over a calendar day
            $('.calendar-day').hover(function () {
                const dateVal = $(this).find('.day').data('date-val'); // Get the date value of the hovered day

                if (eventsMap[dateVal]) { // Check if there are events for the hovered date
                    // Remove any existing tooltips first to avoid stacking
                    $(this).find('.event-tooltip').remove();

                    // Create a single tooltip div for the events
                    const tooltip = $('<div class="event-tooltip"></div>');

                    // Loop through all events for that date and add them to the tooltip
                    eventsMap[dateVal].forEach(event => {
                        const eventDiv = $('<div class="event-item"></div>');
                        eventDiv.html(`
                        <strong>${event.name}</strong><br>
                        <small>${event.type}</small><br>
                    `);
                        tooltip.append(eventDiv); // Append event div to tooltip
                    });

                    tooltip.appendTo(this); // Append tooltip to the day element
                }
            }, function () {
                // Remove tooltip when hover ends
                $(this).find('.event-tooltip').remove();
            });
        });

    </script>
@endsection
