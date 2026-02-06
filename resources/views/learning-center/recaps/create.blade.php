@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
    Add New Recap - Learning Center
@endsection

@section('customStyles')
    <style>
        .question-container {
            border-radius: 5px;
            padding: 10px 20px;
            background: #f6eef48c;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

            <div class="col-lg-12">
                <h1 class="f-32 mb-0 w-600 ">Learning Center</h1>
                <p class="f-14 text-gray w-500 mt-1">Create and manage your recaps</p>
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
                                Add New Recap
                            </h1>
                            <div
                                class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                                <div class="dropdown ">
                                    <button class="main-btn" type="button" id="submitBtn">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tab content -->
                        <div class="">
                            <form action="{{ URL::to('/learning-center/recap/store') }}" method="POST"
                                class="sign__frame-right--form" id="recap-form">
                                @csrf

                                {{-- recap info --}}
                                <input type="hidden" class="form-control sign-input" id="floatingInput" name="brand_id"
                                    value="{{ $brand->id }}">

                                <div class="question-div w-100">
                                    <div class="form-floating mb-4 w-100">
                                        <input type="text" class="form-control sign-input" id="floatingInput"
                                            name="title" required>
                                        <label for="floatingInput sign-label">Recap Title</label>
                                    </div>
                                </div>

                                {{-- <div class="question-div w-100 mb-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="date" class="form-control sign-input" id="floatingInput"
                                                    name="event_date" required>
                                                <label for="floatingInput sign-label">Event Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-4 w-100">
                                                <input type="date" class="form-control sign-input" id="floatingInput"
                                                    name="due_date" required>
                                                <label for="floatingInput sign-label">Due Date</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <h6>Recap Questions</h6>
                                {{-- recap questions --}}
                                <div class="question-container w-100 tab-content-learinig mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="question-div w-100">
                                                <div class="form-floating mb-3 w-100">
                                                    <input type="text" class="form-control sign-input" id="floatingInput"
                                                        name="questions[]">
                                                    <label for="floatingInput sign-label">Write Your Question</label>
                                                </div>
                                                <button class="form-trash">
                                                    <i class="bi-trash cursor-pointer question-delete"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating w-100 mb-3">
                                                <select class="form-select w-100 sign-input px-2 px-2" id="floatingSelect"
                                                    name="questiontypes[]" aria-label="Floating label select example">
                                                    <option value="input-question">Input</option>
                                                    <option value="textarea-question">Textarea</option>
                                                    <option value="date-question">Date</option>
                                                    <option value="select-question">Select</option>
                                                    <option value="checkbox-question">Checkboxes</option>
                                                    <option value="radio-question">Radio</option>
                                                    <option value="image-question">Image</option>
                                                </select>
                                                <label for="floatingSelect sign-label">Select Question Type</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating mb-3 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="answers[]">
                                                <label for="floatingInput sign-label">Options For Checkbox, Radio, Dropdown
                                                    (separate with comma)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end w-100 mt-4 question-btn">
                                    <button type="button" class="add-question" id="AddQuestion">Add Question</button>
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
        $(document).ready(function() {
            $('#submitBtn').click(function() {
                // Trigger the submit event for the form
                $('#recap-form').submit();
            });
        });
    </script>
    <script>
        // Add Question
        $("#AddQuestion").on("click", function(e) {
            e.preventDefault()

            var questionRow = `<div class="question-container w-100 tab-content-learinig mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="question-div w-100">
                                                <div class="form-floating mb-3 w-100">
                                                    <input type="text" class="form-control sign-input" id="floatingInput"
                                                        name="questions[]">
                                                    <label for="floatingInput sign-label">Write Your Question</label>
                                                </div>
                                                <button class="form-trash">
                                                    <i class="bi-trash cursor-pointer question-delete"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating w-100 mb-3">
                                                <select class="form-select w-100 sign-input px-2 px-2" id="floatingSelect" name="questiontypes[]"
                                                    aria-label="Floating label select example">
                                                    <option value="input-question">Input</option>
                                                    <option value="textarea-question">Textarea</option>
                                                    <option value="date-question">Date</option>
                                                    <option value="select-question">Select</option>
                                                    <option value="checkbox-question">Checkboxes</option>
                                                    <option value="radio-question">Radio</option>
                                                    <option value="image-question">Image</option>
                                                </select>
                                                <label for="floatingSelect sign-label">Question Type</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating mb-3 w-100">
                                                <input type="text" class="form-control sign-input" id="floatingInput"
                                                    name="answers[]">
                                                <label for="floatingInput sign-label">Answers</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

            console.log("cliceknd");

            $(".question-container").last().after(questionRow);
        })

        // Delete Question
        $("body").on("click", ".question-delete", function(e) {
            e.preventDefault()

            $(this).closest(".question-container").remove()
        })
    </script>
@endsection
