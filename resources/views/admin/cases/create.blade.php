@extends('admin.layouts.master', ['module' => 'cases'])

@section('title')
    Add New Case
@endsection

@section('customStyles')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            {{-- breadcrumb --}}
            <div class="page-header mb-2">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('/admin/dashboard') }}">Dashboad</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ URL::to('/admin/cases') }}">Cases</a>
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- form row --}}
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card border-0">

                        {{-- include alerts --}}
                        @include('admin.layouts.alerts')

                        <div class="card-header bg-white border-0">
                            <h6 class="my-2"><strong>Add New Case</strong></h6>
                        </div>

                        <div class="card-body">
                            <form action="{{ URL::to('/admin/cases') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row mb-4">

                                    @if (Auth::id() == 1)
                                        <div class="col-md-12 mb-3">
                                            <select class="form-control" id="agent_id" name="agent_id">
                                                <option selected disabled>Select Agent</option>
                                                @foreach ($agents as $agent)
                                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="col-md-6 mb-3">
                                        <label for="date_of_report">Reported Date</label>
                                        <input type="date" class="form-control" id="date_of_report" name="date_of_report"
                                            placeholder="Date of Report" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="time_of_report">Reported Time</label>
                                        <input type="time" class="form-control" id="time_of_report" name="time_of_report"
                                            placeholder="Time of Report" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                                            placeholder="Contact Person *" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="contact_no" name="contact_no"
                                            placeholder="Contact No *" required>
                                    </div>

                                    {{-- <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="lift_no" name="lift_no"
                                            placeholder="Lift No *" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="man_trap" name="man_trap"
                                            placeholder="Man Trapped? *" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <textarea type="text" class="form-control" id="fault_reported" name="fault_reported" placeholder="Fault Reported *"
                                            required></textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" id="building_name" name="building_name"
                                            placeholder="Building Name *" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <textarea type="text" class="form-control" id="building_address" name="building_address"
                                            placeholder="Building Address *" required></textarea>
                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <input type="text" class="form-control" id="engineer_assigned"
                                            name="engineer_assigned" placeholder="Engineer Assigned (optional)">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled>Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div> --}}
                                </div>

                                {{-- device info row --}}
                                <div class="form-row mb-4">
                                    <h6>Device Info</h6>
                                    <div class="col-md-12 mb-3">
                                        <select class="form-control" id="deviceId" name="deviceId">
                                            <option selected disabled>Select Device</option>
                                            @foreach ($devices as $device)
                                                <option value="{{ $device->id }}">{{ $device->deviceNumber }}
                                                    ({{ $device->deviceId }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input type="hidden" class="form-control" id="deviceNumber" name="deviceNumber">

                                    <div class="col-md-6 mb-3">
                                        <label for="customer">Customer</label>
                                        <input type="text" class="form-control" id="customer" name="customer"
                                            placeholder="Customer">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="siteName">Site Name</label>
                                        <input type="text" class="form-control" id="siteName" name="siteName"
                                            placeholder="Site Name">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <textarea type="text" class="form-control" id="address" name="address" placeholder="Address"></textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="postcode">Post Code</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode"
                                            placeholder="Post Code">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="dialerphonenumber">Dailer Phone No</label>
                                        <input type="text" class="form-control" id="dialerphonenumber"
                                            name="dialerphonenumber" placeholder="Dailer Phone No">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="engineer">Engineer</label>
                                        <input type="text" class="form-control" id="engineer" name="engineer"
                                            placeholder="Engineer">
                                    </div>
                                </div>

                                <button type="submit" class="mb-3 btn btn-primary float-right">Add Case</button>
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
        $("#deviceId").change(function(e) {
            e.preventDefault();

            let deviceId = $(this).val();
            // alert(deviceId);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({

                type: "GET",
                url: "/admin/device/" + deviceId,
                data: {
                    deviceId: null,
                },
                success: function(response) {
                    // console.log(response);
                    // return;

                    let status = response.status;

                    if (status == 200) {
                        var deviceInfo = response.device;
                        $("#deviceNumber").val(deviceInfo.deviceNumber);
                        $("#customer").val(deviceInfo.customer);
                        $("#siteName").val(deviceInfo.siteName);
                        $("#address").val(deviceInfo.address);
                        $("#postcode").val(deviceInfo.postcode);
                        $("#dialerphonenumber").val(deviceInfo.dialerphonenumber);
                        $("#engineer").val(deviceInfo.engineer);
                    } else {
                        console.log("Something went wrong!!!");
                    }
                },
            });

        });
    </script>
@endsection
