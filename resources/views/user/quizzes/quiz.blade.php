@extends('user.layouts.master', ['module' => 'quizzes'])

@section('title')
    {{ $quiz->title ?? 'Quiz'}}
@endsection

@section('customStyles')
    <style>
        .complete-btn {
            text-decoration: none;
        }

        .complete-btn:hover {
            color: wheat;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
                <div class="col-lg-12">
                    <h1 class="f-32 w-600 text-primary">Quizzes</h1>
                    <div class="d-flex justify-content-between align-items-end border-bottom pb-2 mt-4  mb-2  ">
                        <div>
                            <p class="mb-0 pb-0 f-14 w-500">{{ $quiz->brand ? $quiz->brand->title : 'Brand Not Specified' }}
                            </p>
                        </div>
                        <div>
                            <p class="mb-0 pb-0 f-14 w-500">1 out 10</p>
                        </div>
                        <a href="{{ URL::to('/user/quizzes') }}" class="main-btn-white" title="go back to all quizzes page"
                            style="width: fit-content;">Back</a>
                    </div>
                </div>
            </div>

            <form action='{{ URL::to("user/quiz/$quiz->id") }}' method="post">
                @csrf

                <div class="row mb-4">
                    {{-- quiz image --}}
                    <div class="col-lg-7 mx-auto mb-4">
                        <img src="{{ URL::to('/front-assets/images/image 449.png') }}" alt="">
                    </div>

                    @php
                        $all_answer = $user_quiz->all_answers ?? [];
                        $user_answers = is_string($all_answer) ? json_decode($all_answer, true) : $all_answer;
                    @endphp

                    {{-- quiz questions --}}
                    @foreach ($quiz->questions as $question)
                        <div class="col-lg-7 mx-auto mb-4">
                            <div class="question-container w-100 tab-content-learinig mb-3">
                                <div class="display-pictute text-center img-container my-3">
                                    <div class="mb-0 mx-auto position-relative">
                                        <img class="quiz-added-image w-25  mx-auto "
                                            src="{{ URL::to("/storage/images/quizzes/md/$question->image") }}" id="output" {{--
                                            onerror="this.onerror=null; this.src='{{ URL::to('/assets/images/imagee.png') }}';" />
                                        --}}>
                                    </div>
                                    <p class="mb-0">
                                        <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)"
                                            style="display: none;">
                                    </p>
                                </div>
                                <div class="question-div w-100">
                                    <div class="form-floating mb-2 w-100">
                                        <p class="mb-0 pb-0 f-14 w-500 text-capitalize"><b>{{ $loop->iteration }}:&nbsp;</b>
                                            * <strong>{{ $question->title }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <hr class="border-bottom mb-2">
                                {{-- option --}}
                                @foreach ($question->options as $opt)
                                    @php

                                        $answerClass = '';
                                        if (
                                            isset($user_answers[$question->id]) &&
                                            $user_answers[$question->id] !== $question->answer
                                        ) {
                                            if ($question->answer === $opt->option) {
                                                $answerClass = 'right-option';
                                            } elseif ($user_answers[$question->id] === $opt->option) {
                                                $answerClass = 'wrong-option';
                                            }
                                        } else {
                                            if (
                                                isset($user_answers[$question->id]) &&
                                                ($user_answers[$question->id] === $question->answer && $user_answers[$question->id] === $opt->option)
                                            ) {
                                                $answerClass = 'right-option';
                                            }
                                        }
                                    @endphp

                                    <div class="form-check mb-2 form-creation w-100 d-flex {{ $answerClass }}">
                                        <input class="form-check-input" name="questions[{{ $question->id }}]" type="checkbox"
                                            value="{{ $opt->option }}" id="option-{{ $opt->id }}" {{ (isset($user_answers[$question->id]) && $user_answers[$question->id] === $opt->option) || (isset($user_answers[$question->id]) && $opt->option === $question->answer) ? 'checked' : '' }}>
                                        <input type="hidden" name="answers[{{ $question->id }}]" value="{{ $question->answer }}">
                                        <label class="form-check-label ms-3 text-capitalize" for="option-{{ $opt->id }}">
                                            {{ $opt->option }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
                {{-- buttons --}}
                <div class="row mb-5">
                    <div class="col-lg-7 mx-auto">
                        <div class="d-flex" style="float: right;">
                            {{-- <button class="main-btn-white2" style="width: fit-content;">Previous</button> --}}
                            {{-- <button class="main-btn" style="width: fit-content;">Next</button> --}}
                            @if($user_quiz->status == 'submitted')
                                <button type="button" disabled class="main-btn" style="width: fit-content;">Submitted</button>
                            @else
                                <button type="submit" class="main-btn" style="width: fit-content;">Submit</button>
                            @endif
                        </div>
                    </div>
                </div>

            </form>

            {{-- result --}}
            <div class="row my-5">
                <div class="col-lg-7 mx-auto text-center">
                    <h3 class="f-28 w-600">You got {{ $user_quiz->right_answers ?? 0}}/{{$user_quiz->total_questions ?? 0}}
                        correct!</h3>

                    {{-- @php
                    $percentage = ($user_quiz->right_answers / $user_quiz->total_questions) * 100;
                    dd($percentage);
                    @endphp --}}
                    <p class="mb-0 pb-0 f-16 w-500">If you got 70% or fewer correct, good try! Go ahead and give it another
                        go
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script>
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
    </script>
@endsection
