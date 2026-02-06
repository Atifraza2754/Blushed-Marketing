@extends('layouts.master', ['module' => 'payments'])

@section('title') Payments @endsection

@section('customStyles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .brand-link {
        text-decoration: none;
        color: #333;
        transition: 0.3s;
    }

    .brand-link:hover {
        color: #007bff;
    }

    .tab button.active {
        background: #007bff;
        color: white;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="f-32 w-600 text-bl">Pay</h1>
            </div>
        </div>

        <div class="row">
            {{-- Tabs --}}
            <div class="col-md-12">
                <div class="tab-div">
                    <div class="tab">
                        <a href="{{ url('/payments') }}">
                            <button class="{{ $slug == null ? 'active' : '' }}">All</button>
                        </a>
                        <a href="{{ url('/payments/past') }}">
                            <button class="{{ $slug == 'past' ? 'active' : '' }}">Past (Paid)</button>
                        </a>
                        <a href="{{ url('/payments/current') }}">
                            <button class="{{ $slug == 'current' ? 'active' : '' }}">Current (Due)</button>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="col-md-12 mt-4">
                <div class="table-responsive">
                    <table class="table dashboard-table pay-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Brand @ Venue</th>
                                <th>Event Date</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Pay Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $p)
                            <tr>
                                <td>
                                    @if ($p->is_allownce_save == 1)
                                    <div class="approved">
                                        Payment Approved
                                        @if(optional($p->payment)->is_paid == 1)
                                        & Paid
                                        @endif
                                    </div>
                                    @else
                                    <div class="rejected">
                                        Not Approved Yet
                                    </div>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ url('/paywithusers' . ($slug ?? '') . '?brand_id=' . ($p->job->brand_id ?? '')) }}" class="brand-link">
                                        <p class="mb-0 pb-0 d-flex align-items-center">
                                            <img src="{{ asset('assets/images/file.svg') }}" class="ms-2" width="16">
                                            {{ $p->job->brand ?? 'N/A' }}
                                        </p>
                                    </a>
                                </td>
                                <td>{{ $p->date }}</td>
                                <td>{{ number_format($p->total_paid, 2) }}</td>
                                <td>{{ number_format($p->total_due, 2) }}</td>
                                <td>
                                    {{ (optional($p->payment)->is_paid == 1) ? 'Paid' : 'Awaiting Payment' }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-end">
                                        {{-- 
                                            Yeh link ab same page (payments/slug) par brand filter apply karega 
                                        --}}
                                        <a href="{{ url('/paywithusers' . ($slug ?? '') . '?brand_id=' . ($p->job->brand_id ?? '')) }}" class="main-btn-sm">
                                            View Detail
                                        </a>
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
</div>
@endsection