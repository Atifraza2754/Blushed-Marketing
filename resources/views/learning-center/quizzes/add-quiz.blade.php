@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
    Add New Quiz - Learning Center
@endsection

@section('customStyles')
@endsection

@section('content')
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
                        <h1 class="f-22 w-600 text-black text-center">
                            {{ $brand->title }}
                        </h1>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="f-22 w-600 text-bl">
                                Add Quiz
                            </h1>

                            <div
                                class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                                <div class="dropdown ">
                                    <button id="addQuiz" class="main-btn" type="button">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>


                        {{--  Tab content --}}
                        <div class="tab-content-learinig">
                            <form id="quizForm" action="{{ URL::to('/learning-center/quiz/store') }}" method="POST"
                                class="sign__frame-right--form" enctype="multipart/form-data">
                                @csrf

                                {{-- brand_id --}}
                                <input type="hidden" name="brand_id" value="{{ $brand->id }}">

                                {{-- title --}}
                                <div class="col-md-12 form-floating mb-4">
                                    <input type="text" class="form-control sign-input" id="floatingInput" name="title"
                                        placeholder="" required>
                                    <label for="floatingInput" class="sign-label">Title</label>
                                </div>

                                {{-- description --}}
                                <div class="col-md-12 form-floating mb-4">
                                    <textarea class="form-control sign-input" placeholder="Leave a comment here" id="floatingTextarea2" name="description"
                                        style="height:100px"></textarea>
                                    <label for="floatingTextarea2 " class="sign-label">Description</label>
                                </div>

                                <div class="display-pictute text-center img-container my-3">
                                    <div class="mb-0 mx-auto position-relative">
                                        <img class="quiz-added-image w-100  mx-auto "
                                            src="{{ URL::to('/assets/images/imagee.png') }}" id="output" />

                                    </div>
                                    <p class="mb-0">
                                        <input type="file" accept="image/*" name="image" id="file"
                                            onchange="loadFile(event)" style="display: none;">
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <button type="button" class="upload-img-btn ">
                                        <label for="file" class="">
                                            Upload Picture
                                        </label>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script>
        $("body").on("click", ".img-delete", function(e) {
            e.preventDefault()
            $(this).closest(".img-container").remove()
        })

        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            $(".remove-picture").removeClass("d-none")
            event.stopPropagation();
        };

        $(".remove-picture").click(function() {
            $("#output").attr('src', 'assets/images/imagee.png')
            $(this).addClass("d-none")
        })


        $(document).ready(function() {
            $('#addQuiz').on('click', function() {
                $('#quizForm').submit();
            });
        });

        // New End
    </script>
@endsection
