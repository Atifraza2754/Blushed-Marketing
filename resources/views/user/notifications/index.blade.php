@extends('user.layouts.master', ['module' => 'notifications'])

@section('title')
    Notifications
@endsection

@section('customStyles')
    <style>
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #cd7faf;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
                <div class="col-lg-12">
                    <h1 class="f-32 mb-0 w-600 ">
                        Notification
                    </h1>
                    <p class="f-14 text-gray w-500 mt-1">
                        Update and manage your account
                    </p>
                </div>

                <div class="col-lg-12 mt-1">
                    @if (count($notifications) > 0)
                        <p class="mb-0 pb-0 f-14 w-500 text-gray mb-3 px-3 mt-2">Latest</p>
                    @endif
                    @forelse ($notifications as $notification)
                        <div class="notifications-row mt-1">
                            <a href="{{ $notification->link }}">
                                <div class="dp-div w-100">
                                    <div class="" style="position: relative;">
                                        {{-- <div class="new-notification"></div> --}}
                                        <img src="{{ URL::to('assets/images/Frame ss37.png') }}" alt=""
                                            class="dp-img-lg2">
                                    </div>
                                    <div class="ms-3 w-100">
                                        <div class="d-flex justify-content-between align-items-center mb-1 w-100">
                                            <h4 class="mb-0 pb-0 ">{{ $notification->title }}</h4>
                                            <span class="f-12 w-500 text-gray mb-0 pb-0">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                        <h2 class="mb-0 pb-0 text-gray mt-0 pt-0">{!! $notification->description !!}</h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-lg-4 mx-auto mt-1">
                            <div class="no-notifications">
                                <img src="{{ URL::to('/assets/images/no-notification.svg') }}" alt=""
                                    class="mb-3">
                                <div>
                                    <h2 class="f-18 w-700 text-blue text-center">There are no notifications</h2>
                                    <p class="f-16 w-400 text-blue text-center">
                                        All notifications about submitting applications and saved jobs will appear here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="col-md-12 mt-3">
                    @if ($notifications->hasPages())
                        <div class="pagination-wrapper">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('customScripts')
@endsection
