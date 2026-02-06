@php
$layout = Auth::user()->role_id == 5 ? 'user.layouts.master' : 'layouts.master';
@endphp
@extends($layout, ['module' => 'recaps'])

@section('title')
{{ $user_recap->user->name }}
@endsection

@section('customStyles')
<style>
    /* general layout */
    .main-content {
        padding: 20px 0;
    }

    /* .container {
        max-width: 960px;
    } */

    h1.f-32 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
    }

    /* shift details card */
    .detail-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .detail-card h5 {
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }

    .detail-item {
        margin-bottom: 8px;
        font-size: 15px;
    }

    .detail-label {
        font-weight: 600;
        margin-right: 5px;
        color: #555;
    }

    /* form questions */
    .recap-form {
        background: #fff;
        border-radius: 12px;
        padding: 25px 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .recap-form label {
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }

    .recap-form .form-control,
    .recap-form .form-select,
    .recap-form textarea {
        border-radius: 8px;
        padding: 10px 12px;
    }

    .recap-form hr {
        margin: 20px 0;
    }

    /* buttons row */
    .btn-row {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .main-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
    }

    .main-btn-white {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
    }

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

        {{-- title --}}
        <div class="row">
            <div class="col-12">
                @if (Auth::user()->role_id == 5)
                <h1 class="f-32 text-primary">Recaps</h1>
                @else
                <h1 class="f-32 text-primary">{{ $user_recap->user->name }} Recap ({{ $user_recap->status }})</h1>
                @endif
            </div>
        </div>

        {{-- shift details or admin buttons --}}
        @if (Auth::user()->role_id == 5)
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="detail-card">
                    <h5>Shift Details</h5>
                    <div class="detail-item"><span class="detail-label">User:</span> {{ $user_recap->user->name }}</div>
                    <div class="detail-item"><span class="detail-label">Account:</span> {{ $user_recap->shift->account ?? 'N/A' }}</div>
                    <div class="detail-item"><span class="detail-label">Event Date:</span> {{ $shift->date ?? 'N/A' }}</div>

                    <div class="detail-item">
                        <span class="detail-label">Event Time:</span>

                        @if($shift)
                        {{ $shift->scheduled_time
            ?? (($shift->shift_start && $shift->shift_end)
                ? $shift->shift_start . ' - ' . $shift->shift_end
                : 'N/A') }}
                        @else
                        N/A
                        @endif
                    </div>

                    <div class="detail-item"><span class="detail-label">Address:</span> {{ $shift->address ?? 'N/A' }}</div>
                    <div class="detail-item"><span class="detail-label">Contact:</span> {{ $shift->contact ?? 'N/A' }} ({{ $shift->phone ?? '-' }})</div>
                    <div class="detail-item"><span class="detail-label">Email:</span> {{ $shift->email ?? 'N/A' }}</div>
                    <div class="detail-item"><span class="detail-label">Brand:</span> {{ $shift->brand ?? 'N/A' }}</div>
                    <div class="detail-item"><span class="detail-label">Products:</span> {{ $shift->skus ?? 'N/A' }}</div>
                </div>

            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="btn-row flex-wrap justify-content-between">
                    <button class="main-btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal-approve">
                        Approved
                    </button>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="main-btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal-reject-edit">
                            Reject w/ edit
                        </button>
                        <button class="main-btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal-approve-edit">
                            Approve w/ edit
                        </button>
                        <a href="{{ URL::to('/recaps') }}" class="main-btn-white">Close</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- recap form --}}
        <div class="row mt-4">
            <div class="col-lg-10 mx-auto">
                <div class="recap-form">

                    @include('common.alerts')

                    <form action='{{ URL::to("/user/recap/$user_recap->id") }}' method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_recap_id" value="{{ $user_recap->id }}">

                        @foreach ($questions as $question)
                        <div class="mb-4">
                            <label class="form-label">
                                <b>{{ $loop->iteration }} - </b> {{ $question->recap_question }} <sup>*</sup>
                            </label>

                            {{-- your existing input logic --}}
                            @if ($question->recap_question_type == 'input-question')
                            <input type="text" name="questions[{{ $question->id }}]" value="{{ $question->recap_question_answer }}" class="form-control" required>
                            @elseif($question->recap_question_type == 'date-question')
                            <input type="date" name="questions[{{ $question->id }}]" value="{{ $question->recap_question_answer }}" class="form-control" required>
                            @elseif($question->recap_question_type == 'image-question')
                            <div class="row g-3">
                                <div class="col-3">
                                    @if ($question->recap_question_answer)
                                    <a href='{{ URL::to("/storage/images/recaps/sm/$question->recap_question_answer") }}' target="_blank">
                                        <img src='{{ URL::to("/storage/images/recaps/sm/$question->recap_question_answer") }}' class="img-fluid rounded">
                                    </a>
                                    @else
                                    <img src="{{ URL::to('/assets/images/placeholders/user.png') }}" class="img-fluid rounded">
                                    @endif
                                </div>
                                <div class="col-9">
                                    <input type="file" name="questions[{{ $question->id }}]" class="form-control">
                                </div>
                            </div>
                            @elseif($question->recap_question_type == 'select-question')
                            <select class="form-select" name="questions[{{ $question->id }}]" required>
                                @php $options = explode(',', $question->recap_question_options); @endphp
                                @foreach ($options as $option)
                                <option value="{{ $option }}" {{ $question->recap_question_answer == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @elseif($question->recap_question_type == 'checkbox-question')
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                @php
                                $boxes = explode(',', $question->recap_question_options);
                                $question->recap_question_answer = explode(',', $question->recap_question_answer);
                                @endphp
                                @foreach ($boxes as $box)
                                @php
                                $box = str_replace(' ','',$box);
                                $recap_question_anser = str_replace(' ','',$question->recap_question_answer);
                                @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="questions[{{ $question->id }}][]" value="{{ $box }}" {{ in_array($box, $recap_question_anser) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $box }}</label>
                                </div>
                                @endforeach
                            </div>
                            @elseif($question->recap_question_type == 'radio-question')
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                @php $radios = explode(',', $question->recap_question_options); @endphp
                                @foreach ($radios as $radio)
                                @php
                                $radio = str_replace(' ','',$radio);
                                $recap_question_anser = str_replace(' ','',$question->recap_question_answer);
                                @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[{{ $question->id }}]" value="{{ $radio }}" {{ $radio == $recap_question_anser ? 'checked' : '' }} required>
                                    <label class="form-check-label">{{ $radio }}</label>
                                </div>
                                @endforeach
                            </div>
                            @elseif($question->recap_question_type == 'textarea-question')
                            <textarea name="questions[{{ $question->id }}]" rows="4" class="form-control" required>{{ $question->recap_question_answer }}</textarea>
                            @endif
                        </div>
                        @endforeach

                        @php
                        $role = Auth::user()->role_id;
                        $status = $user_recap->status;
                        $display_submit_btn = !($status == 'submitted' || $status == 'approved');
                        @endphp

                        @if ($role == 5 && $display_submit_btn)
                        <div class="btn-row">
                            <button type="submit" class="main-btn">Submit</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
@include('recaps.modals.approve-with-feedback')
@include('recaps.modals.reject-with-edit')
@include('recaps.modals.approve-with-edit')
@include('recaps.modals.approve-with-rating')
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