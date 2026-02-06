@extends('admin.layouts.master', ['module' => 'agents'])

@section('title')
    Agents
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
                            <a href="{{ URL::to('/admin/agents') }}">Agents</a>
                        </li>
                    </ol>
                </nav>
                <div class="dropdown filter custom-dropdown-icon">
                    <a class="btn btn-success" href="{{URL::to('/admin/agents/create')}}">
                        <span class="text">Add New</span>
                    </a>
                </div>
            </div>

            {{-- stats row --}}
            <div class="row layout-top-spacing">
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-one">
                        <div class="widget-heading">
                            <h6 class="my-2">TOTAL AGENTS</h6>
                            <h2>{{ $total_agents }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-one">
                        <div class="widget-heading">
                            <h6 class="my-2">ACTIVE AGENTS</h6>
                            <h2>{{ $active_agents }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-one">
                        <div class="widget-heading">
                            <h6 class="my-2">IN-ACTIVE AGENTS</h6>
                            <h2>{{ $inactive_agents }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- datatables row --}}
            <div class="row layout-spacing">
                <div class="col-lg-12">

                    {{-- include alerts --}}
                    @include('admin.layouts.alerts')

                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <table id="style-3" class="table style-3  table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">Sr.</th>
                                        <th width="5%">Image</th>
                                        <th>Agent Info</th>
                                        <th>No of Cases</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center dt-no-sorting" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agents as $agent)
                                        <tr>
                                            <td class="checkbox-column text-center"> {{ $loop->iteration }} </td>
                                            <td class="text-center">
                                                <span>
                                                    @if ($agent->profile_image)
                                                        <img src='{{ URL::to("/storage/images/users/sm/$agent->profile_image") }}'
                                                            class="rounded mw-100" alt="profile image">
                                                    @else
                                                        <img src="{{ URL::to('/assets/img/placeholders/user.png') }}"
                                                            class="rounded mw-100" alt="avatar">
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <h6 class="mb-1">{{ $agent->name }}</h6>
                                                <p class="mb-2">{{ $agent->email }}</p>
                                            </td>
                                            <td>
                                                <h6>{{ $agent->cases_count }}</h6>
                                            </td>
                                            <td class="text-center">
                                                @if ($agent->status)
                                                    <span class="shadow-none badge badge-success">Active</span>
                                                @else
                                                    <span class="shadow-none badge badge-danger">In-Active</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <ul class="table-controls">
                                                    <li>
                                                        <a href='{{ URL::to("/admin/agents/$agent->id/edit") }}'
                                                            class="bs-tooltip" data-toggle="tooltip" data-placement="top"
                                                            title="" data-original-title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-edit-2 p-1 br-6 mb-1">
                                                                <path
                                                                    d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action='{{ URL::to("/admin/agents/$agent->id") }}'
                                                            method="post" id="submitDeleteForm" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="bs-tooltip border-0 bg-none"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="Delete">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash p-1 br-6 mb-1">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
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
    </div>
@endsection

@section('customScripts')
@endsection
