@extends('layouts.master', ['module' => 'payments'])

@section('title') Paying to User Shift @endsection

@section('customStyles')
<style>
    :root {
        --primary-pink: #CD7FAF;
        --light-pink: #fdf6fb;
    }

    .text-primary-pink {
        color: var(--primary-pink) !important;
    }

    .bg-primary-pink {
        background-color: var(--primary-pink) !important;
        color: white !important;
    }

    .pay-card {
        background: #fff;
        border: 1px solid #f1f1f1;
        padding: 20px;
        border-radius: 8px;
        height: 100%;
        transition: 0.3s;
    }

    .pay-label {
        width: 200px;
        font-weight: 500;
        color: #444;
    }

    .pay-input {
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        padding: 8px 15px;
        width: 100%;
        max-width: 300px;
        background: #fff;
    }

    .pay-input:disabled {
        background-color: #f9f9f9;
        color: #888;
    }

    .sub-total-box {
        border: 2px dashed var(--primary-pink);
        background: var(--light-pink);
        padding: 15px 40px;
        border-radius: 5px;
        display: inline-block;
    }

    .sub-total-box p {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 0;
    }

    .btn-approve {
        background: var(--primary-pink);
        color: white;
        border: none;
        padding: 8px 25px;
        border-radius: 5px;
    }

    .btn-outline {
        border: 1px solid #ccc;
        background: white;
        padding: 8px 25px;
        border-radius: 5px;
    }

    .perfect-badge {
        color: #28a745;
        font-weight: 600;
        margin-top: 5px;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="container">
        <div class="row mt-4 align-items-center">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h1 class="f-30 w-600 text-primary-pink">Paying to user shift</h1>
                <div class="d-flex gap-2">
                    @if ($data->is_allownce_save != 1)
                    <button class="btn-approve">Approve</button>
                    @endif
                    <button class="btn-outline">Close</button>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end mt-3">
                <button type="button" data-bs-toggle="modal" data-bs-target="#view-brand-details"
                    class="main-btn-sm" style="width: fit-content;">View Shift Details</button>
            </div>
        </div>

        <div class="row mt-4 align-items-center ">
            <div class="col-md-12 d-flex align-items-center justify-content-between ">
                <div class="d-flex align-items-center">
                    <img src="{{ $data->user ? URL::to('/storage/images/users/sm/' . $data->user->profile_image) : asset('assets/images/Avatar.png') }}"
                        class="rounded-circle" width="45" height="45" style="object-fit: cover">

                    <div class="ms-3 d-flex align-items-center flex-wrap">
                        <h5 class="mb-0 f-16 w-600 me-3">
                            {{ $data->user->name ?? 'User' }}
                            <span class="text-muted fw-normal">/ ${{ $data->falt_rate ?? '0.00' }}</span>
                        </h5>

                        @if ($data->is_allownce_save != 0)
                        <div class="status-badge-approved bg-success text-white">
                            Payment Approved
                            @if ($data->payment && $data->payment->is_paid != 0)
                            & Paid
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="pay-card">
                    <h6 class="w-600">Shift Time</h6>
                    <p class="text-muted mb-1">{{ $data->job ? date('D M d, Y', strtotime($data->job->date)) : '-' }}</p>
                    <p class="text-muted mb-1">{{ $data->job?->scheduled_time ?? 'N/A' }} ({{ strtoupper($data->job?->timezone ?? 'PKT') }})</p>
                    <small class="text-primary-pink">2 hours shift</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="pay-card">
                    <h6 class="w-600">User Clock Time</h6>
                    <p class="text-muted mb-1">{{ $data->date ? date('D M d, Y', strtotime($data->date)) : '-' }}</p>
                    <p class="mb-1 f-14">{{ date('h:i a', strtotime($data->check_in)) }} – <span class="text-primary-pink">Clock In</span></p>
                    <p class="mb-1 f-14">{{ date('h:i a', strtotime($data->check_out)) }} – <span class="text-primary-pink">Clock Out</span></p>
                    <small class="text-primary-pink">2 hours shift</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="pay-card">
                    <h6 class="w-600">Event Pay</h6>
                    <h3 class="text-primary-pink mb-0">${{ $data->falt_rate ?? '0' }}</h3>
                    <span class="perfect-badge">Perfect</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="pay-card">
                    <h6 class="w-600">Pending Recap Deduction</h6>
                    <p class="text-muted mb-1">Hours Pending: {{ $hoursPending }} hrs</p>
                    <p class="text-primary-pink mb-0">Deduction: $<span id="recap-deduction">{{ $recapDeduction }}</span></p>
                    <small class="text-muted">Automatically applied for pending recaps</small>
                </div>
            </div>

        </div>

        <div class="mt-5">
            <h5 class="text-primary-pink w-600">Paying details</h5>
            <hr>

            <div class="form-section mt-4">
                <div class="d-flex align-items-center mb-4 flex-wrap">
                    <label class="pay-label">Event Pay:</label>
                    <input type="text" name="flat_rate" class="pay-input" value="{{ $data->falt_rate }}" disabled>
                </div>

                <div class="d-flex align-items-center mb-4 flex-wrap">
                    <label class="pay-label"></label>
                    <div class="d-flex align-items-center gap-4 w-75">
                        <div class="text-primary-pink cursor-pointer w-600" id="add-mileage-btn">
                            <i class="fas fa-plus-circle me-1"></i> Add Mileage
                        </div>
                        <div class="d-flex align-items-center gap-2 text-muted f-14">
                            <span><i class="fas fa-map-marker-alt text-primary-pink"></i> Event location</span>
                            <span>To</span>
                            <span><i class="fas fa-map-marker-alt text-primary-pink"></i> User Location</span>
                            <span>=</span>
                            <span>Expected Mileage: <b class="text-primary-pink">$50</b></span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4 flex-wrap">
                    <label class="pay-label">Sales Incentives:</label>
                    <input type="number" name="sales_incentives" class="pay-input pay-calc" value="{{ $data->sale_incentive ?? 0 }}">
                </div>

                <div class="d-flex align-items-center mb-4 flex-wrap">
                    <label class="pay-label">Out of pocket expenses:</label>
                    <input type="number" name="out_of_pocket" class="pay-input pay-calc" value="{{ $data->out_of_pocket_expense ?? 0 }}">
                </div>

                <div class="d-flex align-items-center mb-4 flex-wrap">
                    <label class="pay-label">Deductions:</label>
                    <input type="number" name="deductions" class="pay-input pay-calc" value="{{ $data->deduction ?? 0 }}">
                </div>

                <div class="d-flex align-items-center mb-5 flex-wrap">
                    <label class="pay-label"></label>
                    <div class="sub-total-box">
                        <p>Sub Total : <span id="display-subtotal">$0.00</span></p>
                    </div>

                  @if (isset($data->payment) && $data->payment->is_paid != 1)
    <a href="javascript:void(0)"
       class="main-btn-blank ms-sm-3 ms-0 text-white bg-primary pay-now"
       data-user-payment-job-history="{{ $data->payment->id }}">
        Pay Now
    </a>
@endif



                </div>



                <div class="d-flex align-items-center mb-4 flex-wrap">
                    <label class="pay-label"></label>
                    <div class="d-flex gap-3">
                        <button class="btn-outline">Discard</button>



                        @if ($data->is_allownce_save != 1)
                        <a type="button" class="main-btn-blank ms-3 text-white bg-primary save">Save</a>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="view-brand-details" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="f-18 w-600 text-center w-100 mt-1" id="exampleModalLabel">Shift details</h5>
                <button type="button" class="btn-close f-12" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="shift-detail-box">
                    <div class="d-flex justify-content-between align-items-start flex-wrap ">
                        <div class="">
                            <p class="mb-0 pb-0 f-14 w-600">{{ $data->job->scheduled_time ?? '' }}
                                &nbsp;&nbsp;&nbsp;
                                {{-- <span class="text-primary">9</span> /10     --}}
                            </p>
                            <p class="mb-0 pb-0 f-14 w-600">{{ $data->job->admin->name }} &nbsp;&nbsp; </p>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <img src="assets/images/accepted.svg" alt="">
                            <p class="mb-0 pb-0 f-14 w-600">{{ $data->job->status ?? '' }}</p>
                        </div>
                    </div>

                    <hr class="sign-line my-3">

                    <div class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap">
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Account:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $data->job->account ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Brand:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $data->job->brand ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <button style="background-color: transparent; border: none;">
                                <img src="assets/images/btn.svg" alt="">
                            </button>
                        </div>
                    </div>

                    <div
                        class="d-flex justify-content-between align-items-start  mt-3 flex-md-row flex-column flex-wrap">
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Address:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $data->job->address ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Phone #:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $data->job->phone ?? '' }}</p>
                        </div>
                    </div>

                    <div
                        class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap mt-3">
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Email:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $data->job->email ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Contact:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $data->job->contact ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                            <p class="mb-0 pb-0 f-14 w-600 text-gray">Communication via:</p>
                            <p class="mb-0 pb-0 f-14 w-600 text-black">
                                {{ $data->job->method_of_communication ?? '' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Skus</p>
                        <p class="mb-0 pb-0 f-14 w-600 text-black">{{ $data->job->skus ?? '' }}</p>
                    </div>

                    <hr class="sign-line my-3">

                </div>
            </div>

        </div>
    </div>
    <input type="hidden" id="job_lat" value="">
    <input type="hidden" id="job_lon" value="">
    <input type="hidden" id="payment_id" value="{{ $data->id }}">

</div>
<input type="hidden" id="payment_id" value="{{ $data->id }}">
<input type="hidden" id="sub_total_val" name="sub_total" value="0">

@endsection

@section('customScripts')
<script>
$(document).ready(function() {

    function calculateTotal() {
        const flatRate = parseFloat($('[name="flat_rate"]').val()) || 0;
        const sales = parseFloat($('[name="sales_incentives"]').val()) || 0;
        const pocket = parseFloat($('[name="out_of_pocket"]').val()) || 0;
        const userDeductions = parseFloat($('[name="deductions"]').val()) || 0;
        const recapDeduction = parseFloat($('#recap-deduction').text()) || 0;

        // Total formula includes recap deduction
        const total = (flatRate + sales + pocket) - (userDeductions + recapDeduction);

        $('#display-subtotal').text('$' + total.toFixed(2));
        $('#sub_total_val').val(total.toFixed(2));

        // Show recap deduction also in deductions input (optional)
        $('[name="deductions"]').val(userDeductions + recapDeduction);
    }

    // Recalculate total on any input change
    $('.pay-calc, [name="deductions"]').on('input', calculateTotal);

    // Initial calculation
    calculateTotal();

    // Save Logic
    $('.save').on('click', function() {
        let id = $("#payment_id").val();
        let data = {
            id: id,
            flatRate: $('[name="flat_rate"]').val(),
            salesIncentives: $('[name="sales_incentives"]').val(),
            outOfPocket: $('[name="out_of_pocket"]').val(),
            deductions: $('[name="deductions"]').val(),
            subTotal: $('#sub_total_val').val()
        };

        Swal.fire({
            title: 'Save Changes?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/payments-detail/update/" + id,
                    type: "POST",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 200) {
                            Swal.fire('Saved!', '', 'success').then(() => location.reload());
                        }
                    }
                });
            }
        });
    });

    // Pay Now Logic
    $(document).on('click', '.pay-now', function() {
        let userPaymenthistory = $(this).data('user-payment-job-history');
        let subTotal = $('#sub_total_val').val();

        Swal.fire({
            title: 'Confirm Payment?',
            text: 'This will mark payment as PAID',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Pay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/payments/pay-now",
                    type: "POST",
                    data: {
                        userPaymenthistory: userPaymenthistory,
                        total_paid: subTotal
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status === 200) {
                            Swal.fire('Paid!', 'Payment marked as paid.', 'success')
                                .then(() => location.reload());
                        }
                    }
                });
            }
        });
    });
});
</script>

@endsection