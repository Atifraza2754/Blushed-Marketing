@extends('user.layouts.master', ['module' => 'shifts'])

@section('title')
    Notification Detail
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" />
    <style>
        .notification-card {
            border-radius: 20px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            background-color: #fff;
        }
        .notification-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }
        .notification-description {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }
        .notification-description a.btn {
            margin-top: 15px;
            display: inline-block;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10 col-lg-8">
                @include('common.alerts')

                <div class="notification-card">
                    <h1 class="notification-title mb-4">{{ $notification->title }}</h1>

                    <div class="notification-description">
                        {!! $notification->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
    <script>
        // Your DropZone class here if needed...
    </script>
@endsection
