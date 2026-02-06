@extends('layouts.master', ['module' => 'team'])

@section('title')
Team
@endsection

@section('customStyles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

        <div class="col-lg-12">
            {{-- include alerts --}}
            @include('common.alerts')

            <h1 class="f-32 w-600 ">Team</h1>

            {{-- filters --}}
            <div class="filter-row">
                <div class="d-flex flex-wrap">
                    <p class="mb-0 pb-0 f-16 w-700 text-blak me-3">
                        Filter:
                    </p>
                    <div class="d-flex flex-wrap">
                        <form action="{{ URL::to('/team') }}" method="get">
                            <input type="hidden" name="tab" value="all">
                            <button type="submit" class="{{ $tab == 'all' ? 'applied-filter' : '' }}">All</button>
                        </form>
                        <form action="{{ URL::to('/team') }}" method="get">
                            <input type="hidden" name="tab" value="available">
                            <button type="submit"
                                class="{{ $tab == 'available' ? 'applied-filter' : '' }}">Available</button>
                        </form>
                        <form action="{{ URL::to('/team') }}" method="get">
                            <input type="hidden" name="tab" value="unavailable">
                            <button type="submit"
                                class="{{ $tab == 'unavailable' ? 'applied-filter' : '' }}">Un-available</button>
                        </form>
                        <form action="{{ URL::to('/team') }}" method="get">
                            <input type="hidden" name="tab" value="terminated">
                            <button type="submit"
                                class="{{ $tab == 'terminated' ? 'applied-filter' : '' }}">Terminated</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- data table row --}}
        <div class="col-lg-12 mt-4">
            <div class="table-responsive">
                <table class="table dashboard-table dashboard-table-lg">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Email</th>
                            {{-- <th>Flat rate</th> --}}
                            <th>Market</th>
                            <th>Status</th>
                            {{-- <th>City</th> --}}
                            <th>Actions</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr class="parent-row">
                            <td>
                                <h4 class="p-3 f-14">{{ $user->id }}</h4>
                            </td>
                            <td>
                                <a href='{{ URL::to("/team/$user->id") }}' class="">
                                    <div class="dp-div">
                                        <img src="{{ URL::to('/assets/images/Avatar.png') }}" alt="user image"
                                            class="dp-img">
                                        <div class="ms-2">

                                            <h4 class="mb-0 pb-0 f-14">{{ $user->name }}</h4>
                                        </div>
                                    </div>
                                </a>

                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ URL::to('/assets/images/phone.svg') }}" alt="user mobile no">
                                    <p class="mb-0 pb-0 ms-2">
                                        @if (empty($user->country_code) && empty($user->mobile_no))
                                        <small class="text-danger">Not Specified</small>
                                        @else
                                        {{ $user->country_code }} {{ $user->mobile_no }}
                                        @endif
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ URL::to('/assets/images/mail.svg') }}" alt="user email">
                                    <p class="mb-0 pb-0 ms-2">{{ $user->email }}</p>
                                </div>
                            </td>
                            {{-- <td>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <div class="designer mx-1 my-1">
                                                @php
                                                $string = $user->flat_rate ?? null;
                                                $cleanedString = str_replace(['[', ']', ',', '"'], '', $string);
                                                @endphp
                                                {{ $string ? $cleanedString . ' USD' : 'Not Specified' }}
            </div>
        </div>
        </td> --}}
        <td>
            <div class="d-flex align-items-center flex-wrap">
                <div class="">
                    <div class="designer mx-1 my-1">Designer</div>
                    <div class="designer mx-1 my-1">Designer</div>
                </div>
                <div>
                    <div class="researcher m-1 my-1">Researcher</div>
                    <div class="researcher m-1 my-1">Researcher</div>
                </div>
            </div>
        </td>
        <td>
            @if ($user->deleted_at)
            <div class="status-terminated">Terminated</div>
            @else
            {{-- Agar isOnShift true return kare to "On Shift" dikhao --}}
            @if ($user->isOnShift())
            <div class="status-on-shift">On Shift</div>
            @else
            <div class="status-available">Available</div>
            @endif
            @endif
        </td>
        {{-- <td>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 pb-0">{{ $user->city ?? 'Not Specified' }}</p>
    </div>
    </td> --}}
    {{-- <td class="child-target">
                                        <div class="d-flex  justify-content-center">
                                            <div class="edit table-action cursor-pointer">
                                                <img src="assets/images/plus-open.svg" alt="" style="display: inline-block;">
                                                <img src="assets/images/close.svg" alt="" style="display: none;">
                                            </div>
                                        </div>
                                    </td> --}}
    <td>
        <div class="table-menu  table-action cursor-pointer">

            <div class="dropdown ">
                <div class="menu-btn-dots cursor-pointer ms-2" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/dots.svg" alt="">
                </div>
                <ul class="dropdown-menu px-2" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a href='{{ URL::to("/user-setting/$user->id") }}'
                            class="dropdown-item f-14 mb-2">
                            {{-- View member detail --}}
                            Edit User
                        </a>
                    </li>

                    <li>
                        <a href='{{ URL::to("/onboarding/$user->id") }}'
                            class="dropdown-item f-14 mb-2">
                            {{-- onboarding --}}
                            Onboaring
                        </a>
                    </li>
                    {{-- <li>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#flat-rate"
                                                            data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                    data-user-flat="{{ $user->flat_rate }}"
                    class="dropdown-item f-14 mb-2">
                    Set Flat Rate
                    </button>
                    </li> --}}
                    <li>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#notify"
                            data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                            data-user-flat="{{ $user->flat_rate }}"
                            class="dropdown-item f-14 mb-2">
                            Send Notify
                        </button>
                    </li>
                    <li>
                        <button type="button" data-bs-toggle="modal"
                            data-bs-target="#delete-member" data-user-id="{{ $user->id }}"
                            data-user-name="{{ $user->name }}"
                            data-user-flat="{{ $user->flat_rate }}"
                            class="dropdown-item f-14 mb-2" style="color: #F00;" href="">
                            Terminate Member
                        </button>
                    </li>
                    <li>
                        <a href='{{ URL::to("/make-lead/$user->id") }}'
                            class="dropdown-item f-14 mb-2">
                            {{-- View member detail --}}
                            Make Team Lead
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </td>
    </tr>

    @empty
    <tr>
        <td colspan="9" class="text-center bg-white" style="padding: 100px 0px;">No
            Records Found</td>
    </tr>
    @endforelse
    </tbody>
    </table>

    {{-- pagination --}}
    @if ($users->hasPages())
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
    @endif
</div>
</div>
</div>

<div class="overlay"></div>

{{-- include user notify modal --}}
@include('team.modal.notify')

{{-- include user flatrate modal --}}
@include('team.modal.flatrate')

{{-- include user delete modal --}}
@include('team.modal.delete')

{{-- include brand detail modal --}}
@include('team.modal.brand')

</div>
@endsection

@section('customScripts')
<script>
    // Add click event listeners to toggle child rows when clicking on department
    const departmentCells = document.querySelectorAll('.child-target');

    departmentCells.forEach(departmentCell => {
        departmentCell.addEventListener('click', () => {
            const childRow = departmentCell.parentElement.nextElementSibling;

            if (childRow.style.display === 'none' || childRow.style.display === '') {
                childRow.style.display = 'table-row';

                // Show the close.svg image and hide the plus-open.svg image
                const editImages = departmentCell.querySelectorAll('.edit img');
                editImages[0].style.display = 'none';
                editImages[1].style.display = 'inline-block';
            } else {
                childRow.style.display = 'none';

                // Show the plus-open.svg image and hide the close.svg image
                const editImages = departmentCell.querySelectorAll('.edit img');
                editImages[0].style.display = 'inline-block';
                editImages[1].style.display = 'none';
            }

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.dropdown-item').click(function() {
            var userId = $(this).data('user-id');
            var userName = $(this).data('user-name');
            var flatPrice = $(this).data('user-flat');

            $(".user_id").val(userId);
            $(".flat-user-name").val(userName);
            $(".flat-price").val(flatPrice);
        });
    });
</script>
@endsection