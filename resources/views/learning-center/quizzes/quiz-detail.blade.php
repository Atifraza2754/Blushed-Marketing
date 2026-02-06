@extends('user.layouts.master', ['module' => 'quizzes'])

@section('title')
    {{ 'User Submitter Quiz' }}
@endsection

@section('customStyles')
    <style>
        .complete-btn {
            text-decoration: none;
        }

        .complete-btn:hover {
            color: wheat;
        }
            @media (max-width: 768px) {
        #imagePreviewModal .modal-dialog {
            max-width: 90%;
        }
    }

    @media (min-width: 768px) {
        #imagePreviewModal .modal-dialog {
            max-width: 400px;
        }
    }
    </style>
@endsection

@section('content')

    <div class="main-content py-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <h1 class="text-primary">{{ $user_quiz->user->name ?? '' }}'s Submitted Quiz</h1>
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mt-4">
                        <div>
                            <small class="text-muted">Brand Name</small>
                            <p class="mb-0 f-14">{{ $quiz->brand ? $quiz->brand->title : 'Brand Not Specified' }}</p>
                        </div>
                        <div>
                            <small class="text-muted">Score</small>
                            <p class="mb-0 f-14">1 out of 10</p>
                        </div>
                        <div>
                            <small class="text-muted">Status</small>
                            <p class="mb-0 f-14">
                                @if ($user_quiz->status == 'submitted')
                                    <span class="re-attempt">Submitted</span>
                                @elseif($user_quiz->status == 'approved')
                                    <span class="text-success">Approved</span>
                                @else
                                    <span class="pending">Pending</span>
                                @endif
                            </p>
                        </div>
                        <a href="{{ URL::to('/user/quizzes') }}" class="btn btn-outline-primary">Back</a>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-lg-7 mx-auto text-center mb-4">
                    <div class="display-pictute text-center img-container my-3">
                        <div class="mb-0 mx-auto position-relative">
                            <img class="quiz-added-image w-25  mx-auto "
                                src="{{ URL::to("/storage/images/quizzes/md/$quiz->image") }}"
                                style="width: 60%; height: 150px; object-fit: cover; display: block; margin: 0 auto;"
                                id="output"
                                onerror="this.onerror=null;
                                this.src='{{ URL::to('/assets/images/imagee.png') }}';"
                                data-bs-toggle="modal"
                                data-bs-target="#imagePreviewModal"
                                />
                        </div>
                        <p class="mb-0">
                            <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)"
                                style="display: none;">
                        </p>
                    </div>

                </div>

                @php
                    $all_answer = $user_quiz->all_answers ?? [];
                    $user_answers = is_string($all_answer) ? json_decode($all_answer, true) : $all_answer;
                @endphp

                @foreach ($quiz->questions->chunk(3) as $chunk)
                    <div class="row mb-4">
                        @foreach ($chunk as $question)
                            <div class="col-lg-4 mb-4">
                                <div class="question-container">
                                    <p class="mb-3 f-16 text-dark">
                                        <strong>{{ $loop->parent->iteration }}.{{ $loop->iteration }}:</strong>
                                        {{ $question->title }}
                                    </p>

                                    <div class="display-pictute text-center img-container my-3">
                                        <div class="mb-0 mx-auto position-relative">
                                            <img class="quiz-added-image"
                                                src="{{ URL::to("/storage/images/quizzes/md/$question->image") }}"
                                                style="width: 60%; height: 150px; object-fit: cover; display: block; margin: 0 auto;"
                                                onerror="this.onerror=null; this.src='{{ URL::to('/assets/images/imagee.png') }}';"  data-bs-toggle="modal"
                                data-bs-target="#imagePreviewModal">
                                        </div>
                                    </div>

                                    <hr>

                                    @foreach ($question->options as $opt)
                                        @php
                                            $answerClass = '';
                                            if (isset($user_answers[$question->id]) && $user_answers[$question->id] !== $question->answer) {
                                                if ($question->answer === $opt->option) {
                                                    $answerClass = 'right-option';
                                                } elseif ($user_answers[$question->id] === $opt->option) {
                                                    $answerClass = 'wrong-option';
                                                }
                                            } elseif (isset($user_answers[$question->id]) && $user_answers[$question->id] === $opt->option) {
                                                $answerClass = 'right-option';
                                            }
                                        @endphp
                                        <div class="form-check {{ $answerClass }}">
                                            <input class="form-check-input" type="checkbox" {{ (isset($user_answers[$question->id]) && $user_answers[$question->id] === $opt->option) || (isset($user_answers[$question->id]) && $opt->option === $question->answer) ? 'checked' : '' }} disabled   >
                                            <label class="form-check-label ms-2">{{ $opt->option }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </div>

            <div class="row mb-5">
                <div class="col-lg-7 mx-auto">
                    <div class="d-flex justify-content-between">
                        <button class="main-btn-blank text-dark border-dark" data-bs-toggle="modal"
                            data-bs-target="#reject-reattempt" {{ $user_quiz->status == 'submitted' ? '' : 'disabled' }}>Re-attempt</button>
                        <button class="main-btn-blank text-white bg-success" data-bs-toggle="modal" data-bs-target="#appr"
                            {{ $user_quiz->status == 'submitted' ? '' : 'disabled' }}>
                            {{ $user_quiz->status == 'approved' ? 'Approved' : 'Approve' }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-7 mx-auto text-center">
                    <h3 class="f-28 w-600">{{ $user_quiz->right_answers }}/{{ $user_quiz->total_questions ?? 0 }} correct
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="id" id="quiz_id" value="{{ $user_quiz->id }}">

    <div class="modal fade" id="reject-reattempt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-1">
                    <h5 class="f-18 w-600" id="exampleModalLabel">Re-attempt</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body pt-0">
                    {{-- <input type="hidden" name="id" id="quiz_id" value="{{ $user_quiz->id }}"> --}}
                    {{-- <div class="form-floating mb-4 w-100">
                        <input type="text" class="form-control sign-input client_name" id="floatingInput" placeholder=""
                            value="">
                        <label for="floatingInput sign-label">Name</label>
                    </div> --}}
                    <div class="form-floating mb-4 w-100">
                        <textarea class="form-control  sign-input description" placeholder="Leave a comment here"
                            id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2 " class="sign-label">Feedback</label>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="main-btn-blank text-dark border-dark  "
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="main-btn-blank ms-3 text-white bg-primary reattemptbtn">Done</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="appr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-1">
                    <h5 class="f-18 w-600" id="exampleModalLabel">Re-attempt</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body pt-0">
                    {{-- <div class="form-floating mb-4 w-100">
                        <input type="text" class="form-control sign-input client_name" id="floatingInput" placeholder=""
                            value="">
                        <label for="floatingInput sign-label">Name</label>
                    </div> --}}
                    <div class="form-floating mb-4 w-100">
                        <textarea class="form-control  sign-input a_description" placeholder="Leave a comment here"
                            id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2 " class="sign-label">Feedback</label>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="main-btn-blank text-dark border-dark  "
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="main-btn-blank ms-3 text-white bg-primary appr_btn">Done</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
   <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm"> {{-- Changed to modal-sm --}}
    <div class="modal-content">
      <div class="modal-body p-2">
        <img id="modalPreviewImage" src="" class="img-fluid w-100" style="max-height: 400px; object-fit: contain;" alt="Preview">
      </div>
    </div>
  </div>
</div>
@endsection

@section('customScripts')
    <script>
        $('.reattemptbtn').click(function () {

            Swal.fire({
                title: 'Are you sure To Allow re-attempt?',
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

                    // var client_name = $(".client_name").val();
                    var description = $(".description").val();
                    var quiz_id = $("#quiz_id").val();

                    $.ajax({

                        type: "post",
                        url: "/learning-center/reAttempt",
                        data: {
                            // 'client_name': client_name,
                            'description': description,
                            'quiz_id': quiz_id,
                        },
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

        });
        $('.appr_btn').click(function () {

            Swal.fire({
                title: 'Are you sure ?',
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

                    // var client_name = $(".client_name").val();
                    var description = $(".a_description").val();
                    var quiz_id = $("#quiz_id").val();

                    $.ajax({

                        type: "post",
                        url: "/learning-center/appr",
                        data: {
                            // 'client_name': client_name,
                            'description': description,
                            'quiz_id': quiz_id,
                        },
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

        });

        const ratingStars = [...document.getElementsByClassName("rating__star")];
        const ratingResult = document.querySelector(".rating__result");

        printRatingResult(ratingResult);

        function executeRating(stars, result) {
            const starClassActive = "rating__star fas fa-star";
            const starClassUnactive = "rating__star far fa-star";
            const starsLength = stars.length;
            let i;
            stars.map((star) => {
                star.onclick = () => {
                    i = stars.indexOf(star);

                    if (star.className.indexOf(starClassUnactive) !== -1) {
                        printRatingResult(result, i + 1);
                        for (i; i >= 0; --i) stars[i].className = starClassActive;
                    } else {
                        printRatingResult(result, i);
                        for (i; i < starsLength; ++i) stars[i].className = starClassUnactive;
                    }
                };
            });
        }

        function printRatingResult(result, num = 0) {
            result.textContent = `${num}/5`;
        }

        executeRating(ratingStars, ratingResult);

        //
    </script>
<script>
    document.querySelectorAll('.quiz-added-image').forEach(function (img) {
        img.addEventListener('click', function () {
            const modalImg = document.getElementById('modalPreviewImage');
            modalImg.src = this.src;
        });
    });
</script>
@endsection

