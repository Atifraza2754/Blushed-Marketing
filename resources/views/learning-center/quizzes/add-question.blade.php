@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
    Quiz Questions - Learning Center
@endsection

@section('customStyles')
    <style>
        .form-creation {
            padding: 10px 10px 10px 10px;
        }

        .question-container {
            background-color: #f3f3f4eb;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
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
                {{-- include alerts --}}
                @include('common.alerts')

                <div class="row">
                    <div class="col-lg-12 ">
                        <h1 class="f-22 w-600 text-black text-capitalize">{{ $quiz->title }}</h1>
                        <p>{{ $quiz->brand->title }}</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6>Add Questions For This Quiz</h6>
                            <div
                                class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                                <button id="addQuestions" class="main-btn" type="button">Save</button>
                            </div>
                        </div>

                        <div class="tab-content-learning">
                            <form id="questionsForm" action="{{ URL::to("/learning-center/quiz/$quiz->id/questions") }}"
                                method="POST" class="sign__frame-right--form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="brand_id" value="{{ $quiz->brand->id }}">
                                <input type="hidden" name="status" value="{{ $quiz->status }}">
                                <div id="questions-wrapper" class="w-100">

                                    <div class="col-md-12 form-floating mb-4">
                                        <input type="text" class="form-control sign-input" id="floatingInput"
                                            name="title" value="{{ $quiz->title }}" placeholder="" required>
                                        <label for="floatingInput" class="sign-label">Title</label>
                                    </div>

                                    {{-- description --}}
                                    <div class="col-md-12 form-floating mb-4">
                                        <textarea class="form-control sign-input" placeholder="Leave a comment here" id="floatingTextarea2" name="description"
                                            style="height:100px">{{ $quiz->description }}</textarea>
                                        <label for="floatingTextarea2 " class="sign-label">Description</label>
                                    </div>

                                    <div class="display-pictute text-center img-container my-3">
                                        <div class="mb-0 mx-auto position-relative">
                                            <img class="quiz-added-image w-25  mx-auto "
                                                src="{{ URL::to("/storage/images/quizzes/md/$quiz->image") }}"
                                                id="output" {{-- onerror="this.onerror=null; this.src='{{ URL::to('/assets/images/imagee.png') }}';" /> --}}>
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
                                    @foreach ($questions as $index => $question)
                                        <div class="question-container mb-3 position-relative"
                                            data-index="{{ $index }}">
                                            <!-- Trash Button -->
                                            <button type="button" onclick="deleteQuestion({{ $question->id }})"
                                                class="form-trash option-delete position-absolute top-0 end-0"
                                                data-qid="{{ $question->id }}">
                                                <img class=""
                                                    style="width: 5%;
                                                        float: inline-end;
                                                        position: relative;
                                                        top: -8px;
                                                        right: -5px;"
                                                    src="{{ URL::to('assets/images/cross.png') }}">
                                            </button>

                                            {{-- Question --}}

                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input"
                                                    name="questions[{{ $index }}][title]"
                                                    value="{{ $question->title }}"
                                                    placeholder="Add Question Description Here">
                                                <label for="floatingInput">Question No {{ $loop->iteration }}.</label>
                                            </div>

                                            {{-- Answer --}}
                                            <div class="form-floating mb-4 w-100">
                                                <input type="text" class="form-control sign-input"
                                                    name="questions[{{ $index }}][answer]"
                                                    value="{{ $question->answer }}" placeholder="Answer">
                                                <label for="floatingInput">Answer</label>
                                            </div>
                                            <input type="text" class="d-none" name="questions[{{ $index }}][image_name]" value="{{ $question->image }}">

                                            {{-- Options --}}
                                            <p class="text-muted">Options</p>
                                            <div class="options-wrapper">
                                                @foreach ($question->options as $optIndex => $option)
                                                    <div class="form-check mb-2 form-creation w-100 d-flex">
                                                        <input type="text"
                                                            name="questions[{{ $index }}][options][{{ $optIndex }}]"
                                                            value="{{ $option->option }}" placeholder="Option"
                                                            class="form-control">
                                                        <button type="button" class="form-trash option-delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <button type="button" class="add-more-options">Add Option</button>
                                        </div>

                                        <div class="form-floating mb-4 w-100">
                                            <div class="display-picture text-center img-container my-3">
                                                <div class="mb-0 mx-auto position-relative">
                                                    <img class="quiz-added-image w-25 mx-auto"
                                                        src=""
                                                        id="{{ 'output-'.$index }}"
                                                        onerror="this.onerror=null; this.src='{{ URL::to('/storage/images/quizzes/md/'.$question->image) }}';" />
                                                </div>
                                                <p class="mb-0">
                                                    <input type="file" accept="image/*" name="questions[{{ $index }}][image]"
                                                        id="{{ 'file-'. $index }}"
                                                        onchange="loadFile2(event, {{ $index }})"
                                                        style="display: none;">
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <button type="button" class="upload-img-btn">
                                                    <label for="{{ 'file-'.$index }}" class="">
                                                        Upload Picture
                                                    </label>
                                                </button>
                                            </div>

                                </div>
                                @endforeach

                                {{-- Add New Question --}}
                                <button type="button" class="add-question">Add Question</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Templates -->
    <script type="text/template" id="question-template">
        <div class="question-container mb-3" data-index="{index}">

            <div class="form-floating mb-4 w-100">

                <input type="text" class="form-control sign-input" name="questions[{index}][title]"
                       placeholder="Add Question Description Here">
                <label>Question No {question_num}.</label>
            </div>
            <div class="form-floating mb-4 w-100">
                <input type="text" class="form-control sign-input" name="questions[{index}][answer]"
                       placeholder="Answer">
                <label>Answer</label>
            </div>
            <p class="text-muted">Options</p>
            <div class="options-wrapper"></div>
            <button type="button" class="add-more-options">Add Option</button>
        </div>
        <div class="form-floating mb-4 w-100">
            <div class="display-picture text-center img-container my-3">
                <div class="mb-0 mx-auto position-relative">
                    <img class="quiz-added-image w-25 mx-auto"
                        src=""
                        id="output-{index}"
                        onerror="this.onerror=null; this.src='{{ URL::to('/assets/images/imagee.png') }}';" />
                </div>
                <p class="mb-0">
                    <input type="file" accept="image/*" name="questions[{index}][image]"
                        id="file-{index}"
                        onchange="loadFile2(event, {index})"
                        style="display: none;">
                </p>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <button type="button" class="upload-img-btn">
                    <label for="file-{index}" class="">
                        Upload Picture
                    </label>
                </button>
            </div>
    </script>

    <script type="text/template" id="option-template">
        <div class="form-check mb-2 form-creation w-100 d-flex">
            <input type="text" name="questions[{index}][options][]"
                   placeholder="Add Option" class="form-control">
            <button type="button" class="form-trash option-delete">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </script>
@endsection

@section('customScripts')
    <script>
        function loadFile2(event, index) {
            const output = document.getElementById(`output-${index}`);
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    output.src = e.target.result; // Set the image preview
                };
                reader.readAsDataURL(file);
            }
        }
        let questionIndex = {{ count($questions) }}; // Initialize question index based on existing questions

        // Add new question
        $('.add-question').on('click', function() {
            let questionTemplate = $('#question-template').html();
            let newQuestion = questionTemplate.replace(/{index}/g, questionIndex).replace('{question_num}',
                questionIndex + 1);
            $('#questions-wrapper').append(newQuestion);
            questionIndex++;
        });

        // Add new option
        $(document).on('click', '.add-more-options', function(e) {
            e.preventDefault();
            let parentContainer = $(this).closest('.question-container');
            let index = parentContainer.data('index');
            let optionTemplate = $('#option-template').html().replace(/{index}/g, index);
            parentContainer.find('.options-wrapper').append(optionTemplate);
        });

        // Delete question
        $(document).on('click', '.question-delete', function(e) {
            e.preventDefault();
            $(this).closest('.question-container').remove();
        });

        // Delete option
        $(document).on('click', '.option-delete', function(e) {
            e.preventDefault();
            $(this).closest('.form-check').remove();
        });

        // Submit form
        $('#addQuestions').on('click', function() {
            $('#questionsForm').submit();
        });
    </script>

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

        function deleteQuestion(id) {

            Swal.fire({
                title: 'Are you sure To Confirm This Question?',
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

                        type: "DELETE",
                        url: "/learning-center/question/" + id,

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
