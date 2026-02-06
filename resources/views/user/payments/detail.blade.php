@extends('user.layouts.master', ['module' => 'recaps'])

@section('title')
    {{ $user_recap->recap->title }}
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
                    <h1 class="f-32 w-600 text-primary">{{ $user_recap->recap->title }} ({{ $user_recap->status }})</h1>
                    <p>{{ $user_recap->feedback }}</p>
                    <div
                        class="d-flex btn-row  border-bottom pb-2 mt-4 mb-2 flex-md-row flex-column justify-content-between">
                        <button class="main-btn" type="button" data-bs-toggle="modal"
                            data-bs-target="#exampleModal-approve">Approve</button>
                        <div class="d-flex align-items-center flex-md-row flex-column">
                            <button class="main-btn my-md-0 mt-2 me-lg-3" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-approve-feedback">Approve w/ feedback</button>
                            <button class="main-btn my-md-0 mt-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-approve-edit">Approve w/ edit</button>
                            <a href="{{ URL::to('/user/recaps') }}" class="main-btn-white ms-md-3">Close</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-6 mx-auto">

                    {{-- include alerts --}}
                    @include('common.alerts')

                    <form action='{{ URL::to("/user/recap/$user_recap->id") }}' method="post">
                        @csrf

                        <div class="row">

                            @foreach ($user_recap->recap->questions as $question)
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label label-blushed">
                                            <b class="text-black">{{ $loop->iteration }} - </b>
                                            {{ $question->title }} <sup>*</sup>
                                        </label>

                                        {{-- find answer for this question --}}
                                        @php
                                            $answer = null;
                                            if (isset($answers[$question->id])) {
                                                $answer = $answers[$question->id];
                                            }
                                        @endphp

                                        @if ($question->question_type == 'text')
                                            <input type="text" name="questions[{{ $question->id }}]" id=""
                                                value="{{ $answer }}" class="form-control input-blushed"
                                                placeholder="" aria-describedby="helpId" required>
                                        @elseif($question->question_type == 'number')
                                            <input type="number" name="questions[{{ $question->id }}]" id=""
                                                value="{{ $answer }}" class="form-control input-blushed"
                                                min="1" placeholder="" aria-describedby="helpId" required>
                                        @elseif($question->question_type == 'date')
                                            <input type="date" name="questions[{{ $question->id }}]" id=""
                                                value="{{ $answer }}" class="form-control input-blushed"
                                                placeholder="" aria-describedby="helpId" required>
                                        @elseif($question->question_type == 'file')
                                            <input type="file" name="questions[{{ $question->id }}]" id=""
                                                class="form-control input-blushed" placeholder="" aria-describedby="helpId">
                                        @elseif($question->question_type == 'select')
                                            <select class="form-select form-select-lg input-blushed"
                                                name="questions[{{ $question->id }}]" id="" required>
                                                @php
                                                    $options = explode(',', $question->options);
                                                @endphp
                                                @foreach ($options as $option)
                                                    <option value="{{ $option }}"
                                                        {{ $answer == $option ? 'selected' : '' }}>{{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif($question->question_type == 'checkbox')
                                            <div class="d-flex mt-2">
                                                @php
                                                    $boxes = explode(',', $question->options);
                                                    $answer = explode(',', $answer);
                                                @endphp
                                                @foreach ($boxes as $box)
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="questions[{{ $question->id }}][]"
                                                            value="{{ $box }}" id="chk-{{ $loop->iteration }}"
                                                            {{ in_array($box, $answer) ? 'checked' : '' }}>
                                                        <label class="form-check-label label-blushed"
                                                            for="chk-{{ $loop->iteration }}">
                                                            {{ $box }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($question->question_type == 'radio')
                                            <div class="d-flex mt-2">
                                                @php
                                                    $radios = explode(',', $question->options);
                                                @endphp
                                                @foreach ($radios as $radio)
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $question->id }}]"
                                                            id="rad-{{ $loop->iteration }}" value="{{ $radio }}"
                                                            {{ $radio == $answer ? 'checked' : '' }} required>
                                                        <label class="form-check-label label-blushed"
                                                            for="rad-{{ $loop->iteration }}">
                                                            {{ $radio }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($question->question_type == 'textarea')
                                            <textarea name="questions[]{{ $question->id }}" id="" rows="5" style="width: 100%;"
                                                class="input-blushed" required>{{ $answer }}</textarea>
                                        @endif
                                        <hr style="color:#cd7faf;">
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="main-btn">Submit</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <!--approove feedback Modal --> --}}
    <div class="modal fade" id="exampleModal-approve-feedback" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-1">
                    <h5 class="f-18 w-600" id="exampleModalLabel">Approve w/ feedback</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body pt-0">
                    <form class="sign__frame-right--form">
                        <div class="form-floating w-100 mb-4">
                            <input class="form-control  sign-input" placeholder="Name" id="floating-input2">
                            <label for="floating-input2 sign-label">Client Name</label>
                        </div>


                        <div class="form-floating mb-4 w-100">

                            <div class="form-floating">
                                <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                                    style="height: 100px"></textarea>
                                <label for="floatingTextarea2 sign-label">Feedback</label>
                            </div>
                        </div>

                    </form>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="main-btn" data-bs-dismiss="modal">Done</button>
                        <button type="button" class="main-btn-white ms-3" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- <!--aprrove edit Modal --> --}}
    <div class="modal fade" id="exampleModal-approve-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-1">
                    <h5 class="f-18 w-600" id="exampleModalLabel">Approve w/ edit</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body pt-0">
                    <form class="sign__frame-right--form">
                        <div class="form-floating w-100 mb-4">
                            <input class="form-control  sign-input" placeholder="Name" id="floating-input2">
                            <label for="floating-input2 sign-label">Client Name</label>
                        </div>


                        <div class="form-floating mb-4 w-100">

                            <div class="form-floating">
                                <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                                    style="height: 100px"></textarea>
                                <label for="floatingTextarea2 sign-label">Feedback</label>
                            </div>
                        </div>

                    </form>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="main-btn" data-bs-dismiss="modal">Done</button>
                        <button type="button" class="main-btn-white ms-3" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- <!--approve rating Modal --> --}}
    <div class="modal fade" id="exampleModal-approve" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-1">
                    <h5 class="f-18 w-600" id="exampleModalLabel">Rating</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body pt-0">
                    <form class="sign__frame-right--form">
                        <div class="form-floating w-100 mb-4">
                            <input class="form-control  sign-input" placeholder="Name" id="floating-input2">
                            <label for="floating-input2 sign-label">Client Name</label>
                        </div>

                        <div class="rating">
                            <i class="rating__star far fa-star"></i>
                            <i class="rating__star far fa-star"></i>
                            <i class="rating__star far fa-star"></i>
                            <i class="rating__star far fa-star"></i>
                            <i class="rating__star far fa-star"></i>
                            <div class="ms-4">
                                <span class="rating__result"></span>
                            </div>
                        </div>

                        <div class="form-floating mb-4 w-100">

                            <div class="form-floating">
                                <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                                    style="height: 100px"></textarea>
                                <label for="floatingTextarea2 sign-label">Feedback</label>
                            </div>
                        </div>

                    </form>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="main-btn" data-bs-dismiss="modal">Done</button>
                        <button type="button" class="main-btn-white ms-3" data-bs-dismiss="modal">Close</button>
                    </div>
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
