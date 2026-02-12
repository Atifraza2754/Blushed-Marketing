@extends('user.layouts.master', ['module' => 'payments'])

@section('title')
Recaps
@endsection

@section('customStyles')
<style>
    .table-responsive {
        overflow-x: auto;
    }

    .dashboard-table th,
    .dashboard-table td {
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }

    .deduction {
        position: relative;
        cursor: pointer;
    }

    .deduction-text {
        display: none;
        position: absolute;
        top: 50%;
        right: 105%;
        transform: translateY(-50%);
        background: #ffffff;
        border: 1px solid #e0e0e0;
        padding: 15px;
        z-index: 999;
        min-width: 220px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        border-radius: 8px;
        text-align: left;
    }

    .deduction-text h6 {
        font-weight: 700;
        margin-bottom: 10px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
        color: #333;
    }

    .deduction-text p {
        margin-bottom: 5px;
        font-size: 13px;
        color: #555;
        display: flex;
        justify-content: space-between;
    }

    .deduction-text p span {
        font-weight: 600;
        color: #000;
    }

    .deduction:hover .deduction-text {
        display: block;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-paid { background: #e8f5e9; color: #2e7d32; }
    .status-pending { background: #fff3e0; color: #ef6c00; }

    @media (max-width: 768px) {
        .deduction-text {
            right: auto;
            left: 0;
            top: 100%;
            transform: none;
        }
    }
</style>
@endsection

@php
use App\Models\WorkHistory;
use Illuminate\Support\Facades\Auth;

$payments = WorkHistory::where('user_id', Auth::id())
    ->with(['job.brand', 'payment'])
    ->orderBy('date', 'desc')
    ->get();
@endphp

@section('content')
<div class="main-content">
    <div class="container">
        <div class="row mb-4 mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="f-32 w-600 text-bl">Pay</h1>
                <button class="dropdown-toggle align-dropdown" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    ☰
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <div class="table-responsive">
                    <table class="table dashboard-table pay-table table-hover">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Brand @ Store</th>
                                <th>Date</th>
                                <th>Paid</th>
                                <th>Incentive</th>
                                <!--<th>Deductions</th>-->
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $p)
                                <tr>
                                    <td>
                                        <div class="{{ $p->is_allownce_save ? 'approved' : 'pending' }}">
                                            {{ $p->is_allownce_save ? 'Approved' : 'Pending' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/file.svg') }}" class="me-2" width="16">
                                            {{ $p->job->brand ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}</td>
                                    <td>${{ number_format($p->total_paid ?? 0, 2) }}</td>
                                    <td>${{ number_format($p->sale_incentive ?? 0, 2) }}</td>
                                    <!--<td>-->
                                    <!--    <div class="deduction">-->
                                    <!--        <span class="text-danger">-${{ number_format($p->deduction ?? 0, 2) }}</span>-->
                                    <!--        <div class="deduction-text">-->
                                    <!--            <h6>Payment Breakdown</h6>-->
                                    <!--            <p>Date: <span>{{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}</span></p>-->
                                    <!--            <p>Paid Amount: <span>${{ number_format($p->total_paid ?? 0, 2) }}</span></p>-->
                                    <!--            <p>Incentives: <span>${{ number_format($p->sale_incentive ?? 0, 2) }}</span></p>-->
                                    <!--            <p>Deductions: <span class="text-danger">-${{ number_format($p->deduction ?? 0, 2) }}</span></p>-->
                                    <!--            <p>Out of Pocket: <span>${{ number_format($p->out_of_pocket_expense ?? 0, 2) }}</span></p>-->
                                    <!--            <p>Status: <span>{{ optional($p->payment)->is_paid ? 'Paid' : 'Awaiting' }}</span></p>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</td>-->
                                    <td>
                                        <span class="status-badge {{ optional($p->payment)->is_paid ? 'status-paid' : 'status-pending' }}">
                                            {{ optional($p->payment)->is_paid ? 'Paid' : 'Awaiting Payment' }}
                                        </span>
                                    </td>
                                    <td>{{ $p->note ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No payment records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Share “Recaps Report”</h5>
                </div>
                <div class="modal-body">
                    <p>Coming soon…</p>
                    <button class="sign-btn" data-bs-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customScripts')
<script>
    $(document).ready(function () {
        $('.pay-table').DataTable({
            searching: false,
            paging: true,
            ordering: true,
            responsive: true,
            info: false
        });
    });
</script>
@endsection