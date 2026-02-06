@extends('layouts.master', ['module' => 'team'])

@section('title')
    Make Lead
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        .form-check-input.custom-size {
            transform: scale(2);
            /* Increase size */
            cursor: pointer;
        }

        .form-check-label {
            font-size: 1.4rem;
            /* Optional: increase label size too */
            margin-left: 0.5rem;
        }
    </style>

@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

            <div class="col-lg-12">
                {{-- include alerts --}}
                @include('common.alerts')

                <h1 class="f-32 w-600 ">Make Lead</h1>
                <form action='{{ URL::to('update/lead-user') }}' method="POST">
                    @csrf
                    {{-- data table row --}}
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="col-lg-6 mt-4">
                        <div class=" ">
                            <label class="form-check-label" for="">Select Users <small> for </small> <strong> {{ $user['name'] }} </strong></label>
                            <select id="get_lead_user_id" name="get_lead_user_id[]" class="form-control select2" multiple>
                               @foreach($userListing as $l)
                                <option  value="" disabled>Choose User</option>
                                <option  value="{{$l['id']}}">{{$l['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <div class="d-flex " style="">
                            <button class="sign-btn">Update shift</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="overlay"></div>
    </div>
@endsection

@section('customScripts')


    <script>
        $(document).ready(function () {

            function getusers() {
                var user_id = @json($user->id);
                $.ajax({
                    url: '/getLeadUser',
                    method: 'GET',
                    data: { ajax: true, id: user_id },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    dataType: 'json', // Set the expected data type to JSON
                    beforeSend: function () {
                        $('.error-container').html('');
                    },
                    success: function (data) {
                        if (data && data.status == 1) {
                            editForm(data.data);
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something Went Wrong',
                                'error'
                            );
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        // Handle AJAX errors here
                        Swal.fire(
                            'Error!',
                            'Form submission failed: ' + errorThrown,
                            'error'
                        );
                    }
                });
            }

            function editForm(data) {

                if (data) {
                   if (data.lead_users != null && data.all_users != null) {
    console.log(data.lead_users);
    console.log(data.all_users);

    const leadUserIds = data.lead_users.map(id => parseInt(id));
    let statusOption = "";

    data.all_users.forEach(user => {
        const userId = parseInt(user.id);
        const isSelected = leadUserIds.includes(userId) ? 'selected' : '';
        statusOption += `<option value="${user.id}" ${isSelected}>${user.label}</option>`;
    });

    $('#get_lead_user_id').html(statusOption);
}



                }

                const url = window.location.search;
                if (url) {
                    const urlParams = new URLSearchParams(url);
                    const id = atob(urlParams.get('id'));
                    $('#id').val(id);
                }

            }

            getusers();
        })

    </script>
@endsection
