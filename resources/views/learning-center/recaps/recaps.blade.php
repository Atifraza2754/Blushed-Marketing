@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
    Recaps - Learning Center
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

            <div class="col-lg-12">
                <h1 class="f-32 mb-0 w-600">Learning Center</h1>
                <p class="f-14 text-gray w-500 mt-1">Update and manage your account</p>
            </div>

            {{-- include menu --}}
            <div class="col-lg-2">
                @include('learning-center.menu')
            </div>

            {{-- main content --}}
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="d-flex justify-content-between align-items-center flex-md-row flex-column mb-3">
                            <h1 class="f-22 w-600 text-bl">recaps</h1>
                            <div
                                class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                                <div class="dropdown">
                                    <button class="main-btn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#create-recap">
                                        Add recap
                                    </button>
                                </div>
                            </div>
                        </div>


                        {{-- tranings table --}}
                        <div class="table-responsive">
                            <table class="table dashboard-table  dashboard-table-sm tabcontent-table learning-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Recap</th>
                                        <th width="15%">Brand</th>
                                        <th with="15%">Create Date</th>
                                        <th with="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recaps as $recap)
                                        <tr class="">
                                            <td scope="row">
                                                <p class="mb-0 pb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 pb-0">{{ $recap->title }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 pb-0">{{ $recap->brand->title }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 pb-0">{{ $recap->created_at->toDateString() }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center ">
                                                    <div class="edit table-action cursor-pointer">
                                                        <a href="{{ URL::to("/learning-center/recap/$recap->id/edit") }}">
                                                            <svg width="18" height="18" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M3 17.2501V21.0001H6.75L17.81 9.94006L14.06 6.19006L3 17.2501ZM20.71 7.04006C21.1 6.65006 21.1 6.02006 20.71 5.63006L18.37 3.29006C17.98 2.90006 17.35 2.90006 16.96 3.29006L15.13 5.12006L18.88 8.87006L20.71 7.04006Z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="delete table-action cursor-pointer">
                                                        <a onclick="deletefunction({{ $recap->id }})"
                                                            {{-- href="{{ URL::to("/learning-center/training/$training->id/delete") }}"> --}}>
                                                            <svg width="18" height="18" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M20 6H17L16 4H8L7 6H4L4 8L5 19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19L20 8V6ZM9 18C9 18.55 8.55 19 8 19C7.45 19 7 18.55 7 18V9C7 8.45 7.45 8 8 8C8.55 8 9 8.45 9 9V18ZM13 18C13 18.55 12.55 19 12 19C11.45 19 11 18.55 11 18V9C11 8.45 11.45 8 12 8C12.55 8 13 8.45 13 9V18Z"
                                                                    fill="#FF0000" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    {{-- <div class="eye mx-3 table-action cursor-pointer">
                                                        <a href="recap-view.html" class="no-decoration">
                                                            <svg width="18" height="18" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" />
                                                            </svg>
                                                        </a>
                                                    </div> --}}
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
        </div>
    </div>

    {{-- include brand modal --}}
    @include('learning-center.recaps.brands-modal')
@endsection

@section('customScripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.learning-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search recaps..."
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
            url: "/learning-center/recap/" + id + "/delete",

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

    </script>
@endsection
