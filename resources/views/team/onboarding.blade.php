@extends('layouts.master', ['module' => 'team'])

@section('title')
    Onboarding
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        .form-check-input.custom-size {
            transform: scale(2);
            /* Increase size */
            cursor: pointer;
        }

        .form-check-label {
            font-size: 1.4rem;
            /* Optional: increase label size too */
            margin-left: 0.5rem;
        }
    </style>

@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

            <div class="col-lg-12">
                {{-- include alerts --}}
                @include('common.alerts')

                <h1 class="f-32 w-600 ">Onboarding</h1>

                {{-- data table row --}}
                <div class="col-lg-12 mt-4">
                    <div class="px-4 ">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input single-switch" type="checkbox" role="switch" value="w9"
                                id="w9_form" {{ $user->is_w9 ? 'checked' : '' }}>
                            <label class="form-check-label" for="w9_form">W9 Form</label>
                        </div>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input single-switch" type="checkbox" role="switch" value="pr"
                                id="payroll" {{ $user->is_pr ? 'checked' : '' }}>
                            <label class="form-check-label" for="payroll">Payroll</label>
                        </div>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input single-switch" type="checkbox" role="switch" value="ic"
                                id="ic_agreement" {{ $user->is_ic ? 'checked' : '' }}>
                            <label class="form-check-label" for="ic_agreement">IC Agreement Form</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overlay"></div>
        </div>
@endsection

    @section('customScripts')
        <script>
            const switches = document.querySelectorAll('.single-switch');

            switches.forEach((sw) => {
                sw.addEventListener('change', function () {
                    // if (this.checked) {
                    const status = this.checked ? 1 : 0;

                    updateOnbaording(this.value, status);
                    switches.forEach((other) => {
                        // if (other !== this) {
                        //     other.checked = false;
                        // }
                    });
                    // }
                });
            });
            function updateOnbaording(value, status) {
                user_id = @json($user->id);
                Swal.fire({
                    title: 'Are you sure To Change This?',
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

                            type: "post",
                            data: {
                                'id': user_id,
                                form_type: value,
                                status: status
                            },
                            url: "/onboardingchangestatus",

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
        </script>
        <script>
            // // Add click event listeners to toggle child rows when clicking on department
            // const departmentCells = document.querySelectorAll('.child-target');

            // departmentCells.forEach(departmentCell => {
            //     departmentCell.addEventListener('click', () => {
            //         const childRow = departmentCell.parentElement.nextElementSibling;

            //         if (childRow.style.display === 'none' || childRow.style.display === '') {
            //             childRow.style.display = 'table-row';

            //             // Show the close.svg image and hide the plus-open.svg image
            //             const editImages = departmentCell.querySelectorAll('.edit img');
            //             editImages[0].style.display = 'none';
            //             editImages[1].style.display = 'inline-block';
            //         } else {
            //             childRow.style.display = 'none';

            //             // Show the plus-open.svg image and hide the close.svg image
            //             const editImages = departmentCell.querySelectorAll('.edit img');
            //             editImages[0].style.display = 'inline-block';
            //             editImages[1].style.display = 'none';
            //         }

            //     });
            // });
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
