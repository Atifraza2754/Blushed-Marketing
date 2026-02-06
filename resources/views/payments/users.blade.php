@extends('layouts.master', ['module' => 'payments'])

@section('title') Payments @endsection

@section('customStyles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .brand-link { text-decoration: none; color: #333; transition: .3s; }
    .brand-link:hover { color: #007bff; }
    .tab button.active { background: #007bff; color: #fff; border-radius: 4px; }
</style>
@endsection

@section('content')
<div class="main-content">
<div class="container">

    {{-- Heading --}}
    <div class="row mb-3 mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="f-32 w-600 text-bl">{{$brand->title}}</h1>
               <a href="{{ url('/payments/'.$slug) }}" class="btn btn-sm btn-outline-secondary">
                        Clear Brand Filter
                    </a>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="row">
        <div class="col-md-12">
            <div class="tab-div">
               @php
    $brandId = request()->get('brand_id');
@endphp

<div class="tab">
    {{-- All --}}
    <a href="{{ url('/paywithusers') . ($brandId ? '?brand_id='.$brandId : '') }}">
        <button class="{{ $slug == null ? 'active' : '' }}">
            All
        </button>
    </a>

    {{-- Past --}}
    <a href="{{ url('/paywithusers/past') . ($brandId ? '?brand_id='.$brandId : '') }}">
        <button class="{{ $slug == 'past' ? 'active' : '' }}">
            Past (Paid)
        </button>
    </a>

    {{-- Current --}}
    <a href="{{ url('/paywithusers/current') . ($brandId ? '?brand_id='.$brandId : '') }}">
        <button class="{{ $slug == 'current' ? 'active' : '' }}">
            Current (Due)
        </button>
    </a>
</div>

            </div>
        </div>
    </div>

   

    {{-- Table --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table dashboard-table pay-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>User</th>
                              <th>Email</th>
                            <th>Event Date</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Pay Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($payments as $p)
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
                                    <div class="rejected">Not Approved Yet</div>
                                @endif
                            </td>

                            <td>
                               {{ $p->user->name ?? 'N/A' }}
                                
                            </td>
                                <td>
                                {{ $p->user->email ?? 'N/A' }}  
                                </td>   

                            <td>{{ $p->date }}</td>
                            <td>{{ number_format($p->total_paid, 2) }}</td>
                            <td>{{ number_format($p->total_due, 2) }}</td>
                            <td>{{ optional($p->payment)->is_paid ? 'Paid' : 'Awaiting Payment' }}</td>

                            <td>
                                @if (optional($p->payment)->is_paid)
                                    <a href="{{ url('/payments-detail/'.$p->id) }}" class="eye">
                                        👁
                                    </a>
                                @else
                                    <a href="{{ url('/payments-detail/'.$p->id) }}" class="main-btn-sm">
                                        Pay Now
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
