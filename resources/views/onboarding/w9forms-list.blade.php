@php
    $layout = Auth::user()->role_id == 5 ? 'user.layouts.master' : 'layouts.master';
@endphp

@extends($layout, ['module' => 'onboarding'])
@section('title')

    W-9 Forms Listing - Onboarding
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">

        {{-- title section --}}
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <h1 class="f-32 w-600 text-bl">
                    Onboarding
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                {{-- tabs --}}
                <div class="tab-div">
                    <div class="tab">
                        <a href="{{ URL::to('/onboarding/w9forms/list') }}">
                            <button class="active">W-9 Form</button>
                        </a>
                        <a href="{{ URL::to('/onboarding/payrolls/list') }}">
                            <button class="">Payrolls</button>
                        </a>
                        <a href="{{ URL::to('/onboarding/ic-aggrement/list') }}">
                            <button class="">IC Aggrement</button>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table dashboard-table-sm tabcontent-table onboard-table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">User</th>
                                <th scope="col">Name</th>
                                <th scope="col">Bussiness Name</th>
                                <th>Address</th>
                                <th>Event Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($w9forms as $form)
                                <tr class="">
                                    <td scope="row">
                                        <p class="mb-0 pb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 pb-0"><strong>{{ $form->user->name }}</strong></p>
                                        <p class="mb-0 pb-0 text-muted"><small>{{ $form->user->email }}</small></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 pb-0">{{ $form->name }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 pb-0">{{ $form->business_name }}</p>
                                    </td>
                                    <td>
                                        {{ $form->address }}
                                    </td>
                                    <td>{{ $form->date }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="eye mx-3 table-action cursor-pointer">
                                                <a href='{{ URL::to("/onboarding/w9form/$form->id") }}'
                                                    class="no-decoration">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.onboard-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search brands..."
                }
            });
        });
    </script>
@endsection
