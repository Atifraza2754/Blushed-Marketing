@extends('layouts.master', ['module' => 'brands'])

@section('title')
    Brands
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
                    Brands
                </h1>

                {{-- <div class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around">
                    <a href="{{ URL::to('/brands/create') }}" class="main-btn-blank ms-sm-3 ms-0 text-white bg-primary">Add
                        New Brand</a>
                </div> --}}
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">

                {{-- tabs --}}
                <div class="tab-div">
                    <div class="tab">
                        <form action="{{ URL::to('/brands') }}" method="get">
                            <input type="hidden" name="tab" value="all">
                            <button type="submit" class="{{ $tab == 'all' ? 'selected-tab' : '' }}">All</button>
                        </form>
                        <form action="{{ URL::to('/brands') }}" method="get">
                            <input type="hidden" name="tab" value="active">
                            <button class="{{ $tab == 'active' ? 'selected-tab' : '' }}">Active</button>
                        </form>
                        <form action="{{ URL::to('/brands') }}" method="get">
                            <input type="hidden" name="tab" value="inactive">
                            <button class="{{ $tab == 'inactive' ? 'selected-tab' : '' }}">Inactive</button>
                        </form>
                    </div>
                </div>

                {{-- table --}}
                <div class="table-responsive">
                    <table class="table dashboard-table tabcontent-table pay-table">
                        <thead>
                            <tr>
                                <th width="5%">Sr.</th>
                                <th width="30%">Title</th>
                                <th width="10%">Status</th>
                                {{-- <th width="10%">Featured</th> --}}
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="mb-0 pb-0">{{ $brand->title }}</p>
                                    </td>
                                    <td scope="row">
                                        @if ($brand->status)
                                            <div class="approved">Yes</div>
                                        @else
                                            <div class="due">No</div>
                                        @endif
                                    </td>
                                    {{-- <td scope="row">
                                        @if ($brand->featured)
                                            <div class="approved">Yes</div>
                                        @else
                                            <div class="due">No</div>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="edit table-action cursor-pointer">
                                                <a href='{{URL::to("/brands/$brand->id/edit")}}'>
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M3 17.2501V21.0001H6.75L17.81 9.94006L14.06 6.19006L3 17.2501ZM20.71 7.04006C21.1 6.65006 21.1 6.02006 20.71 5.63006L18.37 3.29006C17.98 2.90006 17.35 2.90006 16.96 3.29006L15.13 5.12006L18.88 8.87006L20.71 7.04006Z" />
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
            $('.pay-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search brands..."
                }
            });
        });
    </script>
@endsection
