@extends('layouts.master', ['module' => 'team'])

@section('title')
	Team Member Detail
@endsection

@section('customStyles')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
@php
	$colors = [
		'rgba(224, 89, 51, 0.2)', // Light red
		'rgba(51, 85, 87, 0.2)', // Light green
		'rgba(151, 22, 39, 0.2)', // Light blue
		'rgba(20, 51, 10, 0.2)', // Light pink
		'rgba(111, 129, 11, 0.2)', // Light yellow
		'rgba(230, 88, 43, 0.2)', // Light aqua
		'rgba(17, 153, 75, 0.2)', // Light purple
		'rgba(15, 14, 71, 0.2)', // Light orange
		'rgba(4, 55, 31, 0.2)', // Light teal
		'rgba(14, 55, 64, 0.2)', // Light violet
]; @endphp
<style>
	.ccc {
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
</style>
@section('content')
	<div class="container">
		<div class="row mb-lg-4 mb-3 mt-lg-3 my-3">

			<div class="col-lg-12">
				{{-- include alerts --}}
				@include('common.alerts')
				<div class="row">
					<div class="col-md-1">
						<img src="{{ URL::to('/assets/images/placeholders/user.png') }}" alt="user image" class="w-100">
					</div>
					<div class="col-md-11 px-0">
						<h1 class="f-20 w-800 mb-1">
							{{ $user->name }}
						</h1>
						<p class="mb-0">
							<img src="{{ URL::to('/assets/images/mail.svg') }}" alt="user email">
							<small>{{ $user->email }}</small>
						</p>
						<p>
							<img src="{{ URL::to('/assets/images/phone.svg') }}" alt="user mobile no">
							<small>
								@if (empty($user->country_code) && empty($user->mobile_no))
									Not Specified
								@else
									{{ $user->country_code }} {{ $user->mobile_no }}
								@endif
							</small>
						</p>
					</div>
				</div>
			</div>

			{{-- data table row --}}
			<div class="col-lg-12 mt-3">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Flat rate</th>
								<th>Market</th>
								<th>Status</th>
								<th>City</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div class="d-flex align-items-center flex-wrap">
										<div class="designer mx-1 my-1">
											@php
												$string = $user->flat_rate ?? null;
												$cleanedString = str_replace(['[', ']', ',', '"'], '', $string);
											@endphp
											{{ $string ? $cleanedString . ' USD' : 'Not Specified' }}
										</div>
									</div>
								</td>
								<td>
									<div class="d-flex align-items-center flex-wrap">
										<div class="">
											<div class="designer mx-1 my-1">Designer</div>
											<div class="designer mx-1 my-1">Designer</div>
										</div>
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
										@if (true)
											<div class="status-available">Available</div>
										@else
											<div class="status-on-shift">On Shift</div>
										@endif
									@endif
								</td>
								<td>
									<div class="d-flex align-items-center">
										<p class="mb-0 pb-0">{{ $user->city ?? 'Not Specified' }}</p>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="row">
					<div class="col-md-6">

						<div class=" card d-flex justify-content-between align-items-start">
							<div class="d-flex align-items-start">
								<div>
									<img src="assets/images/calendar.svg" alt="">

								</div>

								<div class="ms-3">
									<p class="f-16 w-600 text-primary mb-0 pb-0 mt-2">Shift
										Ongoing</p>

									<?php
	$startTime = $nextShift['time'] ?? null;
	$endTime = $nextShift['end_time'] ?? null;
	$currentTime = date('Y-m-d H:i:s');
	if ($startTime != null && $endTime != null) {
		if (strtotime($currentTime) > strtotime($startTime) && strtotime($currentTime) < strtotime($endTime)) {
			echo ' <h1 class="f-24 w-600 mb-2">
                                                                                 ' .
				$nextShift['account'] ??
				'' .
				'
                                                                            </h1>
                                               <p class="mb-0 pb-0 f-14 w-500 text-gray">' .
				$nextShift['diff'] .
				'Hrs / $' .
				$nextShift['flat_rate'] .
				'
                                                                            </p>
                                                                            <p class="mb-0 pb-0 f-14 w-500 text-gray">' .
				date('D F d, Y') .
				$nextShift['scheduled_time'] .
				'</p>';
		} else {
			echo 'No job found';
		}
	} else {
		echo 'No job found';
	}
		?>
		{{-- <p class="mb-0 pb-0 f-14 w-500 text-gray">0.00 Hrs / $0.00
		</p>
		<p class="mb-0 pb-0 f-14 w-500 text-gray">Sun May 21, 2023
			3:30pm – 4pm (PKT)</p> --}}
		</div>
		</div>

		{{-- <div class="mt-4">
			<button type="button" data-bs-toggle="modal" data-bs-target="#view-brand-details"
				class="sign-btn" style="width: fit-content;">View
				Brand Details</button>
		</div> --}}
		</div>
		</div>
		<div class="col-md-6">
			<div class="card">

				<p class="f-16 w-600 text-primary mb-0 pb-0 ms-3">Recent Shifts</p>
				<div class="d-flex mt-3 ms-3">

					<!-- approved -->
					{{-- <div class="accepted-shift me-3">
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
					</div> --}}
					<!-- pending -->
					{{-- <div class="pending-shift me-3">
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
					</div> --}}
					<!-- blue pending -->
					@forelse($jobList as $index => $d)
						@php
							$color = count($colors) > 0 ? $colors[$index % count($colors)] : '#CCCCCC';
							// Cycle through colors array
						@endphp
						<div class="ccc pending-shift me-3" style="background-color: {{ $color }};">
							<p class="mb-0 pb-0 f-12 w-500" style="color: {{ 'grey' }};">
								{{ $d['date'] ?? '' }}
							</p>
							<p class="mb-0 pb-0 f-12 w-500" style="color: {{ 'grey' }};">
								{{ $d['scheduled_time'] ?? '' }}
							</p>
							<h1 class="f-14 w-600 text-black mt-2">
								{{ $d['account'] ?? '' }}
							</h1>
							<div class="pending-status-tag mt-3 mb-2">
								{{ strtoupper($d['status']) ?? '' }}
							</div>
						</div>
					@empty
						No Job Found
					@endforelse
				</div>
			</div>
		</div>

		</div>

		<div class="row">
			<div class="col-md-12">

				<div class=" card d-flex justify-content-between align-items-start">
					<p class="f-16 w-600 text-primary mb-0 pb-0">Past Shifts</p>

				</div>
			</div>
		</div>
		</div>
		</div>

		<div class="overlay"></div>

		{{-- include user notify modal --}}
		@include('team.modal.notify')

		{{-- include user flatrate modal --}}
		@include('team.modal.flatrate')

		{{-- include user delete modal --}}
		@include('team.modal.delete')

		{{-- include brand detail modal --}}
		@include('team.modal.brand')

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
		$(document).ready(function () {
			$('.dropdown-item').click(function () {
				var userId = $(this).data('user-id');
				var userName = $(this).data('user-name');
				var flatPrice = $(this).data('user-flat');

				$(".user_id").val(userId);
				$(".flat-user-name").val(userName);
				$(".flat-price").val(flatPrice);
			});
		});
	</script>
@endsection
