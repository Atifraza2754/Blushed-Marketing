@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
	Trainings - Learning Center
@endsection

@section('customStyles')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<style>
		.tab-btn {
			background-color: inherit;
			float: left;
			border: none;
			outline: none;
			cursor: pointer;
			padding: 7px 16px;
			transition: 0.3s;
			border-bottom: 2px solid transparent;
			color: #2E2C34;
			text-align: center;
			font-family: Manrope;
			font-size: 14px;
			font-style: normal;
			font-weight: 500;
			line-height: 18px;
		}

		.tab-btn-active {
			border-bottom: 2px solid #CD7FAF;
		}
	</style>
@endsection

@section('content')
<div class="main-content">
	<div class="container">
		<div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

			<div class="col-lg-12">
				<h1 class="f-32 mb-0 w-600 ">Learning Center</h1>
				<p class="f-14 text-gray w-500 mt-1">Update and manage your account</p>
			</div>

			{{-- include menu --}}
			<div class="col-lg-3">
				@include('learning-center.menu')
			</div>

			{{-- main content --}}
			<div class="col-lg-8 ">
				<div class="row">
					<div class="col-lg-12 ">

						{{-- include alerts --}}
						@include('common.alerts')

						<h1 class="f-22 w-600 text-black text-center">{{ $user_training->brand->title }}</h1>
						<div class="d-flex justify-content-between align-items-center mb-3">
							<h1 class="f-22 w-600 text-bl">Training Details</h1>
						</div>

						<!-- Tab content -->
						<div class="tab-content-learinig">
							<div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
								<div class="col-lg-12">
									<h1 class="f-32 w-600 text-black">{{ $user_training->title }}</h1>
									<p class="f-14 w-500 text-gray mb-0 pb-0">
										{{ $user_training->description ?? 'detail not specified' }}</p>

								</div>
							</div>

							<div class="row">
									<h1 class="f-32 w-600 text-black">{{ 'Files' }}</h1>


								@forelse ($trainingFile as $f )
                                <div class="col-lg-4 mb-3">
                                    <div class="file-card position-relative">
                                        {{-- <button class="badge bg-danger text-white file-delete-btn position-absolute top-0 end-0 m-1"
                                        data-file-id="{{ $f->id }}"
                                        data-file-path="{{ $f->files }}"
                                        onclick="deletefunction({{$f->id}})"
                                        title="Delete File"
                                        style="transform: translate(5px, -5px); z-index: 2; border:none;">
                                     <i class="fas fa-trash-alt fa-xs"></i>
                                    X
                                </button> --}}

                                <!-- File content with improved layout -->
                                <a href="{{ URL::to('storage/files/trainings/'.$f->files) }}"
                                   class="d-flex flex-column align-items-center text-decoration-none text-dark h-100 p-3">
                                            @php
                                                $extension = pathinfo($f->files, PATHINFO_EXTENSION);
                                                $icon = match(strtolower($extension)) {
                                                    'pdf' => 'fa-file-pdf',
                                                    'doc', 'docx' => 'fa-file-word',
                                                    'xls', 'xlsx' => 'fa-file-excel',
                                                    'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image',
                                                    default => 'fa-file'
                                                };
                                            @endphp
                                            <i class="fas {{ $icon }} fa-2x text-primary mb-2"></i>

                                            <!-- File Name (Truncated) -->
                                            <span class="file-name text-truncate w-100 px-2" title="{{ $f->files }}">
                                                {{ basename($f->name) }}
                                            </span>

                                            <!-- File Size (Optional - if you have this data) -->
                                            @if(isset($f->size))
                                                <small class="text-muted mt-1">{{ formatFileSize($f->size) }}</small>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                @empty
                                <div class="col-lg-4 mb-3">
                                    <div class="file-card position-relative">
                                No File Found !
                                    </div></div>
								@endforelse

								<div class="col-lg-12 mx-auto mb-5">
									<hr>
									{{-- <div class="d-flex align-items-center">
										<a href="{{ URL::to('/user/learning-center/trainings') }}" class="main-btn-blank mt-3">Back</a>
										<a href='{{ URL::to("/user/learning-center/training/$user_training->id/complete") }}'
											class="main-btn complete-btn ms-3 mt-3 w-auto training-mark-btn {{ $user_training->status == 'complete' ? 'green-bg' : '' }}">
											{{ $user_training->status == 'complete' ? 'Completed' : 'Mark as Complete' }}
										</a>
									</div> --}}
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div> {{-- include brand modal --}}
	@include('learning-center.trainings.brands-modal')
@endsection

@section('customScripts')
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.learning-table').DataTable({
				paging: true,
				language: {
					searchPlaceholder: "Search Trainings..."
				}
			});
		});

		function deletefunction(id) {

			Swal.fire({
				title: 'Are you sure To Confirm This Training?',
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
						url: "/learning-center/training/"+id+"/delete",

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
									}});
							} else {
								console.log("Something went wrong!!!");
							}
						},
					});
				}
			})
		}

        function deletefunctionFile(id) {

Swal.fire({
    title: 'Are you sure To Confirm This File?',
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
            url: "/learning-center/training-file/"+id+"/delete",

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
                        }});
                } else {
                    console.log("Something went wrong!!!");
                }
            },
        });
    }
})
}



    </script>
@endsection
