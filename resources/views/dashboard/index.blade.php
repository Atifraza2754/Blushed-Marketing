@extends('layouts.master', ['module' => 'dashboard'])

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

		.calendar-sidebar>span#sidebarToggler,
		.calendar-sidebar>.calendar-year {
			background: #CD7FAF !important;
		}

		th[colspan="7"] {
			color: #C92085 !important;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12 mt-lg-0 mt-3">
				<div class="d-flex justify-content-between align-items-md-center flex-md-row flex-column align-items-start">
					<div>
						<h1 class="f-36 w-600 text-black">Good morning, {{ Auth::user()->name }}</h1>
						<p class="mb-0 pb-0 f-14 w-500 text-gray">Here’s what’s going on with your team	Designspace</p>
					</div>

					<div class="mt-md-0 mt-3 text-end ms-auto">
						<h3 class="f-20 w-500 text-gray text-end">
							{{ date('l') }}
						</h3>
						<p class="f-14 w-600 text-black mb-0 pb-0">{{ date('d F Y') }}</p>

						{{-- <p class="f-14 w-600 text-black mb-0 pb-0">26 February 2021</p> --}}
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">

			<div class="col-lg-3 mt-4">
				<div class="blushed-card d-flex flex-column align-content-between">
					<p class="f-14 w-500 text-blck">
						No. of Open Shifts
					</p>
					{{-- <h2 class="f-32 w-600 text-black text-center my-4 no_of_open_shift">
						0
					</h2> --}}
					<div class="table-responsive">
						<table class="table table-sm table-borderless mb-0">
							<tbody class="t-body-data">

							</tbody>
						</table>
					</div>
					{{-- <div class="d-flex align-items-center justify-content-between">
						<div class="d-flex align-items-center">
							<img src="{{ URL::to('/assets/images/call_made.png') }}" alt="" height="18px">
							<p class="mb-0 pb-0 w-400 f-14 ms-1">
							</p>
						</div>
						<div class=""> --}}
							{{-- <select class="form-select  dropdown-menu-card" onchange="getOpenShiftUser()" name="" --}}
								{{-- id="published_shift"> --}}
								{{-- <option value="1">Weekly</option> --}}
								{{-- <option value="2">Monthly</option> --}}
								{{-- <option value="3">Yearly</option> --}}
								{{-- </select> --}}
							{{-- </div>
					</div> --}}
				</div>
			</div>
			<div class="col-lg-3 mt-lg-4 mt-3">
				<div class="blushed-card d-flex flex-column align-content-between">
					<p class="f-14 w-500 text-blck">
						No. Recap Due
					</p>
					<h2 class="f-32 w-600 text-black text-center my-4 no_of_recap_due">
						0
					</h2>
					{{-- <div class="d-flex align-items-center justify-content-between">
						<div class="d-flex align-items-center">
							<img src="{{ URL::to('/assets/images/call_made.png') }}" alt="" height="18px">
							<p class="mb-0 pb-0 w-400 f-14 ms-1">
							</p>
						</div> --}}
						{{-- <div class="">
							<select class="form-select  dropdown-menu-card" onchange="jobCountimport()" name=""
								id="import_shift">
								<option value="1">Weekly</option>
								<option value="2">Monthly</option>
								<option value="3">Yearly</option>
							</select>
						</div> --}}
						{{--
					</div> --}}
				</div>
			</div>
			<div class="col-lg-6 mt-lg-4 mt-3">
				<div class="blushed-card">
					<div class="d-flex justify-content-between">
						<h3 class="f-16 w-600">Due Onboarding Items</h3>

						{{-- <div class="dropdown " style="margin-top: -5px;">
							<div class="menu-btn-dots cursor-pointer" id="dropdownMenuButton1" data-bs-toggle="dropdown"
								aria-expanded="false">
								<img src="{{ URL::to('/assets/images/dots.svg') }}" alt="">
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
						</div> --}}
					</div>
					<div class="table-responsive">
						<table class="table center-table mb-0">
							<tbody>
								@foreach($due_on_voting as $dv)
									<tr>
										<td>
											<div class="dp-div">
												<img src="{{ URL::to('/assets/images/Avatar.png') }}" alt="" class="dp-img">
												<h4 class="mb-0 pb-0 ms-2">{{ $dv->name }}</h4>
											</div>
										</td>
										{{-- <td>
											<p class="mb-0 pb-0 f-12 w-500">Due text</p>
										</td> --}}
										<td>
											<p class="mb-0 pb-0 f-12 w-500">{{ $dv->created_at }}</p>
										</td>
										<td>
											<div class="d-flex align-items-center ms-3">
												@if ($dv->status == 'pending')
													<img src="{{ URL::to('/assets/images/pending.svg') }}" alt="" width="20">
													<p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
												@elseif ($dv->status == 'reject')
													<img src="{{ URL::to('/assets/images/x-circle.svg') }}" alt="" width="20">
													<p class="mb-0 pb-0 f-14 w-600 ms-1">Rejected</p>
												@else
													<img src="{{ URL::to('/assets/images/accepted.svg') }}" alt="" width="20">
													<p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
												@endif
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

		{{-- messages --}}
		<div class="row mb-4">
			<div class="col-lg-4 mt-lg-4 mt-3">
				<div class="blushed-card view-more-card">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<h3 class="f-16 w-600 mb-0 pb-0">Messages</h3>
						<div class="d-flex align-items-center">
							<img src="{{ URL::to('/assets/images/refresh.svg') }}" alt="" class="cursor-pointer">
							<div class="dropdown ">
								<div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
									data-bs-toggle="dropdown" aria-expanded="false">
									<img src="{{ URL::to('/assets/images/dots.svg') }}" alt="">
								</div>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
									<li>
										<a class="dropdown-item f-14 w-500" href="">
											Link Name
										</a>
									</li>
									<li>
										<a class="dropdown-item f-14 w-500" href="">
											Link Name
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>

					@foreach ($messages as $msg)
						<a href='{{ URL::to("/messages/$msg->user_id") }}'>
							<div class="d-flex justify-content-between align-items-center mb-2  hover-bg">
								<div class="dp-div">
									@if ($msg->user->profile_image)
										<img src='{{ URL::to('/storage/images/users/sm/' . $msg->user->profile_image) }}' alt=""
											class="dp-img-lg">
									@else
										<img src="{{ URL::to('/assets/images/Avatar.png') }}" alt="" class="dp-img-lg">
									@endif

									<div class="ms-2">
										<h4 class="mb-0 pb-0 ">{{ $msg->user->name }}</h4>
										<p class="mb-0 pb-0 ">{{ $msg->message }}</p>
									</div>
								</div>
								<div class="d-flex align-items-center">
									<img src="{{ URL::to('/assets/images/block.svg') }}" alt="" class="cursor-pointer">
									<img src="{{ URL::to('/assets/images/message.svg') }}" alt="" class=" cursor-pointer ms-2">
								</div>
							</div>
						</a>
					@endforeach

					<div class="text-center view-more">
						{{-- <!-- view all --> --}}
						<hr class="sign-line ">

						<a href="{{ URL::to('/messages') }}"
							class="f-14 w-500 text-gray text-center p-0 m-0 no-decoration">View More
							Messages
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

			{{--
			<div class="col-lg-4 mt-lg-4 mt-3">
				<div class="blushed-card view-more-card">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<h3 class="f-16 w-600 mb-0 pb-0">Open Shifts</h3>
						<div class="d-flex align-items-center">
							<div class="d-flex align-items-center">
								<p class="mb-0 pb-0 f-14 w-500 text-gray">{{ date('d-M-Y') }}</p>
								<svg class="ms-2" width="14" height="14" viewBox="0 0 14 14" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd"
										d="M9.91667 7.58334H7V10.5H9.91667V7.58334ZM9.33333 1.16667V2.33334H4.66667V1.16667H3.5V2.33334H2.91667C2.26917 2.33334 1.75583 2.85834 1.75583 3.50001L1.75 11.6667C1.75 12.3083 2.26917 12.8333 2.91667 12.8333H11.0833C11.725 12.8333 12.25 12.3083 12.25 11.6667V3.50001C12.25 2.85834 11.725 2.33334 11.0833 2.33334H10.5V1.16667H9.33333ZM11.0833 11.6667H2.91667V5.25001H11.0833V11.6667Z"
										fill="#84818A" />
								</svg>

							</div> --}}
							{{-- <div class="dropdown ">
								<div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
									data-bs-toggle="dropdown" aria-expanded="false">
									<img src="{{ URL::to('/assets/images/dots.svg') }}" alt="">
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
							</div> --}}
						{{-- </div> --}}
					{{-- @foreach ($completedShifts as $c)

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
								<h4 class="f-14 w-500 mb-0 pb-0 ">{{ $c->brand ?? '' }}</h4>
								<p class="mb-0 pb-0 ">{{ $c->scheduled_time ?? '' }}
							</div>
						</div>
						<div class="">
							<p class="mb-0 pb-0 f-12 w-600 text-black">+ $ {{ $c->totalCount($c->id) }}</p>
							<p class="mb-0 pb-0 f-12 w-600 text-sky">Completed</p>
						</div>
					</div>

					@endforeach
					<div class="text-center view-more">
						<!-- view all -->
						<hr class="sign-line">
						<a href="{{ URL::to('/shifts') }}"
							class="f-14 w-500 text-gray text-center p-0 m-0 no-decoration-sky">View
							All Shifts
							<svg class="ms-2" width="16" height="17" viewBox="0 0 16 17" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M8.00008 3.37244L7.06008 4.31244L10.7801 8.0391H2.66675V9.37244H10.7801L7.06008 13.0991L8.00008 14.0391L13.3334 8.70577L8.00008 3.37244Z"
									fill="#84818A" />
							</svg>
						</a>

					</div>
				</div> --}}

			<div class="col-lg-3 mt-lg-4 mt-3">
				<div class="blushed-card d-flex flex-column align-content-between">
					<p class="f-14 w-500 text-blck">
						No. Quiz Due
					</p>
					<h2 class="f-32 w-600 text-black text-center my-4 no_of_quiz_due">
						0
					</h2>
					{{-- <div class="d-flex align-items-center justify-content-between">
						<div class="d-flex align-items-center">
							<img src="{{ URL::to('/assets/images/call_made.png') }}" alt="" height="18px">
							<p class="mb-0 pb-0 w-400 f-14 ms-1">
							</p>
						</div> --}}
						{{-- <div class="">
							<select class="form-select  dropdown-menu-card" onchange="jobCountimport()" name=""
								id="import_shift">
								<option value="1">Weekly</option>
								<option value="2">Monthly</option>
								<option value="3">Yearly</option>
							</select>
						</div> --}}
						{{--
					</div> --}}
				</div>
			</div>
				<div class="col-lg-4 mt-lg-4 mt-3 pt-1">
				<div class="blushed-card">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<h3 class="f-16 w-600 mb-0 pb-0">Open Shifts</h3>
					</div>

					<!-- Calendar dashboard container -->
					<div class="">
						<div id="calendar-dashboard" class=" small-calendar evo-calendar  sidebar-hide event-hide"></div>

					</div>

					<!-- Centered content with button -->
					<div class="text-center">
						<hr class="sign-line">
						<div class="w-100">
							<button class="sign-btn w-100">+ Add Shift</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('customScripts')
	<script>

		const calendarEvents = @json($job ?? []);
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
	<script>

		function getOpenShiftUser() {

			let value = 1; // for weekly, if monthly and early needed get the current value
			// alert(deviceId);

			$.ajaxSetup({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
			});

			$.ajax({

				type: "GET",
				url: "/open-shift-user",
				data: {
					value: value,
				},
				success: function (response) {
					console.log(response);
					// return;

					let status = response.status;
					let data = response.data;

					if (status == 200) {
						data.forEach(function (r) {
							// Create the HTML structure for each rider dynamically
							var driverDiv = `

								<tr>
									<td>
										<small>
										${r.name}
										</small>
										<h4> &nbsp |
											<span class=" f-12 ">${r.account}</span>
											</h4>
									</td>

								</tr>

							`;
							$(".t-body-data").append(driverDiv)
						});
					} else {
						console.log("Something went wrong!!!");
					}
				},
			});

		}

		function recapCount() {

			let value = $("#import_shift").val();
			// alert(deviceId);

			$.ajaxSetup({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
			});

			$.ajax({

				type: "GET",
				url: "/user_recap",
				data: {
					value: 1,
				},
				success: function (response) {
					console.log(response);
					// return;

					let status = response.status;

					if (status == 200) {
						var count = response.count;
						$(".no_of_recap_due").text(count);

					} else {
						console.log("Something went wrong!!!");
					}
				},
			});

		}
		function jobCountPublish() {

			let value = $("#published_shift").val();
			// alert(deviceId);

			$.ajaxSetup({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
			});

			$.ajax({

				type: "GET",
				url: "/published-shift",
				data: {
					value: value,
				},
				success: function (response) {
					console.log(response);
					// return;

					let status = response.status;

					if (status == 200) {
						var count = response.count;
						$(".no_of_open_shift").text(count);

					} else {
						console.log("Something went wrong!!!");
					}
				},
			});

		}

		function jobCountimport() {

			let value = $("#import_shift").val();
			// alert(deviceId);

			$.ajaxSetup({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
			});

			$.ajax({

				type: "GET",
				url: "/import-shift",
				data: {
					value: value,
				},
				success: function (response) {
					console.log(response);
					// return;

					let status = response.status;

					if (status == 200) {
						var count = response.count;
						$(".no_of_recap_due").text(count);

					} else {
						console.log("Something went wrong!!!");
					}
				},
			});

		}

		function quizCount() {

			let value = $("#import_shift").val();
			// alert(deviceId);

			$.ajaxSetup({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				},
			});

			$.ajax({

				type: "GET",
				url: "/user_quiz",
				data: {
					value: 1,
				},
				success: function (response) {
					console.log(response);
					// return;

					let status = response.status;

					if (status == 200) {
						var count = response.count;
						$(".no_of_quiz_due").text(count);

					} else {
						console.log("Something went wrong!!!");
					}
				},
			});

		}
		// jobCountPublish();
		// jobCountimport();
		getOpenShiftUser();
		recapCount();
		quizCount();
	</script>
@endsection
