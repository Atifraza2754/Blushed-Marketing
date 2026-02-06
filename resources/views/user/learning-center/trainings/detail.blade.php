@extends('user.layouts.master', ['module' => 'learning-center'])

@section('title')
{{ $user_training->training->title }}
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

        {{-- Title --}}
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="col-lg-12">
                <h1 class="f-32 w-600 text-black">
                    {{ $user_training->training->title }}
                </h1>
                <p class="f-14 w-500 text-gray mb-0 pb-0">
                    {{ $user_training->training->description ?? 'Detail not specified' }}
                </p>
            </div>
        </div>

        {{-- Training Files --}}
        <div class="row">
            <div class="col-lg-12">

                @if(isset($trainingFile) && count($trainingFile))
                <h5 class="mb-3">Training Files</h5>

                @foreach ($trainingFile as $file)


                <a class="btn btn-primary mb-2 w-100"
                    href="{{ asset('storage/files/trainings/' . $file->files) }}"

                    target="_blank">
                    📎 {{ $file->original_name ?? 'Download Training File' }}
                </a>
                @endforeach
                @else
                <p class="text-muted text-center">
                    No training files available.
                </p>
                @endif

            </div>

            {{-- Actions --}}
            <div class="col-lg-12 mx-auto mb-5">
                <hr>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <a href="{{ URL::to('/user/learning-center/trainings') }}"
                        class="main-btn-blank mt-3">
                        Back
                    </a>

                    <a href="{{ URL::to("/user/learning-center/training/$user_training->id/complete") }}"
                        class="main-btn complete-btn mt-3 w-auto training-mark-btn
                       {{ $user_training->status == 'complete' ? 'green-bg' : '' }}">
                        {{ $user_training->status == 'complete'
                            ? 'Completed'
                            : 'Mark as Complete' }}
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('customScripts')
@endsection