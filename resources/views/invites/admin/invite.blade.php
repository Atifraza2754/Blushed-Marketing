@extends('layouts.master', ['module' => 'admin-invites'])

@section('title')
    Invite new admins
@endsection

@section('customStyles')
@endsection
@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="col-lg-12">

                {{-- include alerts --}}
                @include('common.alerts')

                <h1 class="f-32 w-600 "> Invite Admins</h1>
                <div class="blushed-card mt-3 py-lg-4 px-lg-4">
                    <h1 class="f-24 w-600">Invite admin to manage Blushed App</h1>
                    <p class="f-18 w-500 " style="color: #84818A !important;">Enter email to invite admin on
                        Blushed</p>

                    <form action="{{ URL::to('/admin/invites/store') }}" method="POST" class="sign__frame-right--form">
                        @csrf

                        <div class="row w-100 align-items-center">

                            {{-- role_id --}}
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-select w-100 sign-input px-2 " id="floatingSelect" name="role_id[]"
                                        aria-label="Floating label select example" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect sign-label">Select role</label>
                                </div>
                            </div>
                            {{-- email --}}
                            <div class="col-lg-5 col-md-5 col-10">
                                <div class="form-floating mb-4 w-100">
                                    <input type="email" class="form-control sign-input " id="floatingInput" name="email[]"
                                        value="" required>
                                    <label for="floatingInput" class="sign-label">Email address</label>
                                </div>
                            </div>
                            {{-- add btn --}}
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

                        {{-- new rows will be appended here --}}
                        <div class=" appended-row w-100"></div>
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

    {{-- appendable row --}}
    <div id="add-role" class="d-none">
        <div class="row align-items-center w-100">

            {{-- role_id --}}
            <div class="col-lg-5 col-md-5 col-12">
                <div class="form-floating w-100 mb-4">
                    <select class="form-select w-100 sign-input px-2 " id="floatingSelect" name="role_id[]"
                        aria-label="Floating label select example" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role }}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelect sign-label">Select role</label>
                </div>
            </div>
            {{-- email --}}
            <div class="col-lg-5 col-md-5 col-10">
                <div class="form-floating mb-4 w-100">
                    <input type="email" class="form-control sign-input " id="floatingInput" name="email[]" required>
                    <label for="floatingInput" class="sign-label">Email address</label>
                </div>
            </div>
            {{-- delete btn --}}
            <div class="col-2">
                <div class="d-flex align-items-end justify-content-md-start justify-content-center">
                    <svg class="delete-appended-element" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.5 3L15.5 4H19V6H5V4H8.5L9.5 3H14.5ZM6 18.9999C6 20.0999 6.9 20.9999 8 20.9999H16C17.1 20.9999 18 20.0999 18 18.9999V6.9999H6V18.9999ZM8.0001 9H16.0001V19H8.0001V9Z"
                            fill="#FC3400" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script>
        $(document).ready(function() {
            // Function to append the template when .add-role is clicked
            function appendRoleTemplate() {
                // Clone the template content
                const template = $("#add-role").html();

                // Append the template to the form
                $(".appended-row").append(template);
            }

            // Add a click event listener to the .add-role element
            $(".add-role").on("click", appendRoleTemplate);
        });

        // Event delegation for deleting appended elements
        $(".appended-row").on("click", ".delete-appended-element", function() {
            // Remove the corresponding parent element when the delete icon is clicked
            $(this).closest(".row").remove();
        });
    </script>
@endsection
